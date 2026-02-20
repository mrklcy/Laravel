<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Office;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RmoController extends Controller
{
    /**
     * Display RMO dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_documents' => Document::count(),
            'active_requests' => Document::where('status', 'pending')->count(),
            'archived_records' => Document::where('status', 'archived')->count(),
            'pending_approvals' => Document::where('status', 'pending')->count(),
        ];

        return view('admin.rmo.dashboard', compact('stats'));
    }

    /**
     * Display documents page with all active documents
     */
    public function documents(Request $request)
    {
        $query = Document::where('status', '!=', 'archived');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('reference_no', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply category filter
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Apply status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.rmo.documents', compact('documents'));
    }

    /**
     * Store a new document
     */
    public function storeDocument(Request $request)
    {
        $request->validate([
            'document_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'reference_no' => 'required|string|unique:documents,reference_no',
            'document_file' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'status' => 'required|in:active,pending,restricted',
        ]);

        $file = $request->file('document_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents', $fileName, 'public');

        Document::create([
            'name' => $request->document_name,
            'description' => $request->description,
            'category' => $request->category,
            'reference_no' => $request->reference_no,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'status' => $request->status,
            'uploaded_by' => Auth::guard('admin')->id(),
        ]);

        return redirect()->route('rmo.documents')->with('success', 'Document added successfully!');
    }

    /**
     * Show a single document (JSON for AJAX)
     */
    public function showDocument(Document $document)
    {
        return response()->json($document);
    }

    /**
     * Generate next reference number for a given prefix and year
     */
    public function nextRef(Request $request)
    {
        $prefix = $request->query('prefix', 'DOC');
        $year = $request->query('year', date('Y'));
        $pattern = "{$prefix}-{$year}-%";

        $latest = Document::where('reference_no', 'like', $pattern)
            ->orderByRaw("CAST(SUBSTRING_INDEX(reference_no, '-', -1) AS UNSIGNED) DESC")
            ->value('reference_no');

        $nextNum = 1;
        if ($latest) {
            $parts = explode('-', $latest);
            $nextNum = (int) end($parts) + 1;
        }

        return response()->json([
            'reference_no' => "{$prefix}-{$year}-" . str_pad($nextNum, 3, '0', STR_PAD_LEFT),
        ]);
    }

    /**
     * Download a document file
     */
    public function downloadDocument(Document $document)
    {
        // 1. Disable Zlib compression to prevent Content-Length mismatch
        if (ini_get('zlib.output_compression')) {
            ini_set('zlib.output_compression', 'Off');
        }

        // 2. Recursively clear all output buffers
        while (ob_get_level()) ob_end_clean();

        $disk = Storage::disk('public');
        $validFile = false;

        // 3. Strict existence and validation check
        if ($document->file_path && $disk->exists($document->file_path)) {
            if ($disk->size($document->file_path) > 0) {
                $validFile = true;
            }
        }

        // Helper to get base64 logo
        $logoPath = public_path('images/CLSU_LOGO.png');
        $logoData = '';
        if (file_exists($logoPath)) {
            $type = pathinfo($logoPath, PATHINFO_EXTENSION);
            $data = file_get_contents($logoPath);
            $logoData = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        // 4. Fallback: Generate "File Not Found" PDF if missing or empty
        if (!$validFile) {
            $pdf = Pdf::loadHTML('
                <!DOCTYPE html>
                <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                    <style>
                        body { font-family: sans-serif; text-align: center; padding-top: 50px; }
                        .logo { height: 80px; margin-bottom: 20px; }
                        .icon { font-size: 48px; color: #dc3545; margin-bottom: 10px; }
                        h1 { color: #333; margin-bottom: 10px; }
                        p { color: #666; line-height: 1.6; }
                        .details { margin: 30px auto; padding: 20px; background: #f8f9fa; border-radius: 8px; width: 80%; max-width: 500px; text-align: left; border: 1px solid #eee; }
                        .meta { margin-top: 30px; font-size: 11px; color: #999; border-top: 1px solid #eee; padding-top: 20px; }
                    </style>
                </head>
                <body>
                    ' . ($logoData ? '<img src="' . $logoData . '" class="logo">' : '') . '
                    <div class="icon">⚠️</div>
                    <h1>File Not Available</h1>
                    <p>The system could not retrieve the original digital file for this record.</p>
                    
                    <div class="details">
                        <p><strong>Record Name:</strong> ' . ($document->name ?? 'N/A') . '</p>
                        <p><strong>Filename:</strong> ' . ($document->file_name ?? 'Unknown') . '</p>
                        <p><strong>Reference No:</strong> ' . $document->reference_no . '</p>
                        <p><strong>Status:</strong> File missing or corrupted on server.</p>
                    </div>

                    <p>Please contact the system administrator to restore this file.</p>
                    
                    <div class="meta">
                        Generated by CLSU RMO System | ' . now()->format('F d, Y h:i A') . '
                    </div>
                </body>
                </html>
            ');
            return $pdf->download('File_Status_' . $document->reference_no . '.pdf');
        }

        // 5. Check if file is a placeholder/dummy text file
        $path = $disk->path($document->file_path);
        
        // Final buffer clean
        while (ob_get_level()) ob_end_clean();

        // Heuristic: If it claims to be a PDF but isn't (or is known dummy text), wrap it.
        $isPlaceholder = false;
        $extension = strtolower(pathinfo($document->file_name, PATHINFO_EXTENSION));

        if ($extension === 'pdf') {
             // Read first 100 bytes to check header
            $handle = fopen($path, 'r');
            $header = fread($handle, 100);
            fclose($handle);

            if (!str_starts_with($header, '%PDF-') || str_contains($header, 'Sample digitized document')) {
                $isPlaceholder = true;
                $placeholderContent = file_get_contents($path);
            }
        }

        if ($isPlaceholder) {
            $pdf = Pdf::loadHTML('
                <!DOCTYPE html>
                <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                    <style>
                        body { font-family: sans-serif; padding: 40px; color: #333; }
                        .header { text-align: center; border-bottom: 2px solid #006eb3; padding-bottom: 20px; margin-bottom: 30px; }
                        .logo { height: 80px; margin-bottom: 10px; }
                        .title { font-size: 18px; margin-top: 5px; color: #555; font-weight: bold; }
                        .content { padding: 30px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 5px; font-family: monospace; white-space: pre-wrap; }
                        .meta { margin-top: 50px; font-size: 12px; color: #999; text-align: center; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        ' . ($logoData ? '<img src="' . $logoData . '" class="logo">' : '<div style="font-size:24px;color:#006eb3;">CLSU RMO</div>') . '
                        <div class="title">Digitized Document Record</div>
                    </div>
                    
                    <p><strong>Document ID:</strong> ' . $document->reference_no . '</p>
                    <p><strong>Filename:</strong> ' . ($document->file_name ?? 'Unknown') . '</p>
                    <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
                    
                    <h3>File Content Preview:</h3>
                    <div class="content">' . htmlspecialchars($placeholderContent) . '</div>
                    
                    <div class="meta">
                        This is a placeholder or plain text file converted to PDF for viewing.<br>
                        Generated by CLSU RMO System | ' . now()->format('F d, Y h:i A') . '
                    </div>
                </body>
                </html>
            ');
            return $pdf->download('Document_' . $document->reference_no . '.pdf');
        }

        // Return download response for valid files
        return response()->download($path, str_replace('"', '_', $document->file_name));
    }

    /**
     * Archive a document
     */
    public function archiveDocument(Document $document)
    {
        $document->update([
            'status' => 'archived',
            'archived_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Document archived successfully!']);
    }

    /**
     * Restore an archived document
     */
    public function restoreDocument(Document $document)
    {
        $document->update([
            'status' => 'active',
            'archived_at' => null,
        ]);

        return response()->json(['success' => true, 'message' => 'Document restored successfully!']);
    }

    /**
     * Digitize an archived document (upload file for physical-only record)
     */
    public function digitizeDocument(Request $request, Document $document)
    {
        $request->validate([
            'document_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $file = $request->file('document_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents', $fileName, 'public');

        $document->update([
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
        ]);

        return response()->json(['success' => true, 'message' => 'Document digitized successfully!']);
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(Document $document)
    {
        // Delete physical file if it exists
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return response()->json(['success' => true, 'message' => 'Document deleted successfully!']);
    }

    /**
     * Display archives page
     */
    public function archives(Request $request)
    {
        $query = Document::where('status', 'archived');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('reference_no', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply category filter
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Apply year filter
        if ($request->filled('year') && $request->year !== 'all') {
            $query->whereYear('archived_at', $request->year);
        }

        $documents = $query->orderBy('archived_at', 'desc')->paginate(10);

        $stats = [
            'total_archived' => Document::where('status', 'archived')->count(),
            'digital' => Document::where('status', 'archived')->whereNotNull('file_path')->count(),
            'physical_only' => Document::where('status', 'archived')->whereNull('file_path')->count(),
            'retrieved_this_month' => Document::where('status', 'active')
                ->whereNotNull('archived_at')
                ->whereMonth('updated_at', now()->month)
                ->whereYear('updated_at', now()->year)
                ->count(),
        ];

        return view('admin.rmo.archives', compact('documents', 'stats'));
    }

    /**
     * Display requests page
     */
    public function requests()
    {
        return view('admin.rmo.requests');
    }

    /**
     * Display reports page
     */
    public function reports()
    {
        $recentReports = Document::latest()->take(5)->get();

        $stats = [
            'total_documents' => Document::count(),
            'active' => Document::where('status', 'active')->count(),
            'pending' => Document::where('status', 'pending')->count(),
            'archived' => Document::where('status', 'archived')->count(),
            'categories' => Document::selectRaw('category, COUNT(*) as count')
                ->whereNotNull('category')
                ->groupBy('category')
                ->pluck('count', 'category')
                ->toArray(),
        ];

        return view('admin.rmo.reports', compact('recentReports', 'stats'));
    }

    /**
     * Generate and download a PDF report
     */
    public function generateReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|string',
            'format' => 'nullable|string',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        $reportType = $request->report_type;

        $pdf = null;
        $filename = '';

        switch ($reportType) {
            case 'Document Inventory':
                $query = Document::query();
                if ($dateFrom && $dateTo) {
                    $query->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59']);
                }
                $data = $query->orderBy('created_at', 'desc')->get();
                $categoryCounts = $data->groupBy('category')->map->count();
                $pdf = Pdf::loadView('admin.rmo.reports.document-inventory', compact('data', 'dateFrom', 'dateTo', 'categoryCounts'));
                $filename = 'Document_Inventory_' . now()->format('Y-m-d_His') . '.pdf';
                break;

            case 'Request Fulfillment Status':
                $query = Document::whereIn('status', ['pending', 'active']);
                if ($dateFrom && $dateTo) {
                    $query->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59']);
                }
                $data = $query->orderBy('created_at', 'desc')->get();
                $statusCounts = $data->groupBy('status')->map->count();
                $pdf = Pdf::loadView('admin.rmo.reports.request-status', compact('data', 'dateFrom', 'dateTo', 'statusCounts'));
                $filename = 'Request_Fulfillment_' . now()->format('Y-m-d_His') . '.pdf';
                break;

            case 'Archive Summary':
                $query = Document::where('status', 'archived');
                if ($dateFrom && $dateTo) {
                    $query->whereBetween('archived_at', [$dateFrom, $dateTo . ' 23:59:59']);
                }
                $data = $query->orderBy('archived_at', 'desc')->get();
                $categoryCounts = $data->groupBy('category')->map->count();
                $pdf = Pdf::loadView('admin.rmo.reports.archive-summary', compact('data', 'dateFrom', 'dateTo', 'categoryCounts'));
                $filename = 'Archive_Summary_' . now()->format('Y-m-d_His') . '.pdf';
                break;

            case 'Disposal Log':
                $query = Document::where('status', 'archived');
                if ($dateFrom && $dateTo) {
                    $query->whereBetween('archived_at', [$dateFrom, $dateTo . ' 23:59:59']);
                }
                $data = $query->orderBy('archived_at', 'desc')->get();
                $categoryCounts = $data->groupBy('category')->map->count();
                $pdf = Pdf::loadView('admin.rmo.reports.archive-summary', compact('data', 'dateFrom', 'dateTo', 'categoryCounts'));
                $filename = 'Disposal_Log_' . now()->format('Y-m-d_His') . '.pdf';
                break;

            case 'Access Log':
            default:
                $query = Document::query();
                if ($dateFrom && $dateTo) {
                    $query->whereBetween('updated_at', [$dateFrom, $dateTo . ' 23:59:59']);
                }
                $data = $query->orderBy('updated_at', 'desc')->get();
                $categoryCounts = $data->groupBy('category')->map->count();
                $pdf = Pdf::loadView('admin.rmo.reports.document-inventory', compact('data', 'dateFrom', 'dateTo', 'categoryCounts'));
                $filename = 'Access_Log_' . now()->format('Y-m-d_His') . '.pdf';
                break;
        }

        while (ob_get_level()) ob_end_clean();
        return $pdf->download($filename);
    }

    /**
     * Display analytics page
     */
    public function analytics()
    {
        $stats = [
            'total_documents' => Document::count(),
            'active_requests' => Document::where('status', 'pending')->count(),
            'archived_records' => Document::where('status', 'archived')->count(),
            'pending_approvals' => Document::where('status', 'pending')->count(),
            'document_types' => [
                'Memorandums' => Document::where('category', 'administrative')->count(),
                'Academic' => Document::where('category', 'academic')->count(),
                'Legal' => Document::where('category', 'legal')->count(),
                'Financial' => Document::where('category', 'financial')->count(),
            ],
            'monthly_requests' => [65, 59, 80, 81, 56, 55, 40]
        ];

        return view('admin.rmo.analytics', compact('stats'));
    }

    /**
     * Display settings page
     */
    public function settings()
    {
        $office = Office::where('code', 'RMO')->first();
        $themeColor = $office ? $office->theme_color : '#009639';

        return view('admin.rmo.settings', compact('themeColor'));
    }

    /**
     * RMO Appearance Update
     */
    public function settingsAppearanceUpdate(Request $request)
    {
        $request->validate([
            'theme_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
        ]);

        $office = Office::where('code', 'RMO')->first();

        if ($office) {
            $office->update(['theme_color' => $request->theme_color]);
            return redirect()->back()->with('success', 'Appearance updated successfully.');
        }

        return redirect()->back()->with('error', 'Office not found.');
    }

    // ==================== INQUIRIES ====================

    public function inquiries()
    {
        $office = Office::where('code', 'RMO')->first();
        $inquiries = \App\Models\Inquiry::where('office_id', $office?->id)->latest()->get();
        return view('admin.rmo.inquiries', compact('inquiries'));
    }

    public function inquiryShow(\App\Models\Inquiry $inquiry)
    {
        return view('admin.rmo.inquiry-show', compact('inquiry'));
    }

    public function inquiryUpdate(Request $request, \App\Models\Inquiry $inquiry)
    {
        $inquiry->update($request->only('response', 'status'));

        // Send response email to the inquirer
        try {
            if ($request->filled('response') && $inquiry->email) {
                $inquiry->load('office');
                \Illuminate\Support\Facades\Mail::to($inquiry->email)
                    ->send(new \App\Mail\InquiryResponseNotification($inquiry));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send inquiry response email: ' . $e->getMessage());
        }

        return redirect()->route('rmo.inquiries.show', $inquiry)
            ->with('success', 'Inquiry updated successfully.');
    }
}
