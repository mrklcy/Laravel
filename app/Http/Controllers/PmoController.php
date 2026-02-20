<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Employee;
use App\Models\Equipment;
use App\Models\MaintenanceRequest;
use App\Models\Reservation;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class PmoController extends Controller
{
    /**
     * PMO Dashboard
     */
    public function dashboard()
    {
        // PMO-specific statistics
        $stats = [
            'total_employees' => Employee::where('department', 'Procurement')->count(),
            'active_employees' => Employee::where('department', 'Procurement')->where('status', 'active')->count(),
            'inactive_employees' => Employee::where('department', 'Procurement')->where('status', 'inactive')->count(),
            'on_leave_employees' => Employee::where('department', 'Procurement')->where('status', 'on_leave')->count(),
            'retired_employees' => Employee::where('department', 'Procurement')->where('status', 'retired')->count(),
            'regular_employees' => Employee::where('department', 'Procurement')->where('employment_status', 'regular')->count(),
            'contractual_employees' => Employee::where('department', 'Procurement')->where('employment_status', 'contractual')->count(),
            'casual_employees' => Employee::where('department', 'Procurement')->where('employment_status', 'casual')->count(),
            'new_hires_this_month' => Employee::where('department', 'Procurement')
                                              ->whereMonth('date_hired', now()->month)
                                              ->whereYear('date_hired', now()->year)
                                              ->count(),
        ];

        // Get recent users - only from Procurement department
        $recent_employees = Employee::with('office')
                                    ->where('department', 'General Services')
                                    ->latest()
                                    ->take(5)
                                    ->get();

        // Get department statistics - only Procurement
        $departments = Employee::selectRaw('department, COUNT(*) as count')
                               ->where('department', 'General Services')
                               ->whereNotNull('department')
                               ->groupBy('department')
                               ->orderByDesc('count')
                               ->get();

        return view('admin.pmo.dashboard', compact('stats', 'recent_employees', 'departments'));
    }

    // =============================================
    // Purchase Requests Management
    // =============================================

    public function buildings()
    {
        $buildings = Building::latest()->get();

        $stats = [
            'total' => Building::count(),
            'active' => Building::where('status', 'active')->count(),
            'maintenance' => Building::where('status', 'maintenance')->count(),
            'total_rooms' => Building::sum('rooms'),
        ];

        return view('admin.pmo.buildings', compact('buildings', 'stats'));
    }

    public function storeBuilding(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:buildings,code|max:50',
            'rooms' => 'nullable|integer|min:0',
            'floors' => 'nullable|integer|min:1',
            'year_built' => 'nullable|integer|min:1900|max:2030',
            'total_area' => 'nullable|numeric|min:0',
            'status' => 'required|string|in:active,maintenance,inactive',
            'manager' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $building = Building::create($validated);

        return response()->json(['success' => true, 'message' => 'Purchase request added successfully!', 'data' => $building]);
    }

    public function updateBuilding(Request $request, Building $building)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:buildings,code,' . $building->id,
            'rooms' => 'nullable|integer|min:0',
            'floors' => 'nullable|integer|min:1',
            'year_built' => 'nullable|integer|min:1900|max:2030',
            'total_area' => 'nullable|numeric|min:0',
            'status' => 'required|string|in:active,maintenance,inactive',
            'manager' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $building->update($validated);

        return response()->json(['success' => true, 'message' => 'Purchase request updated successfully!', 'data' => $building]);
    }

    public function destroyBuilding(Building $building)
    {
        $building->delete();

        return response()->json(['success' => true, 'message' => 'Purchase request deleted successfully!']);
    }

    // =============================================
    // Suppliers & Items Management
    // =============================================

    public function equipment()
    {
        $equipment = Equipment::latest()->get();

        $stats = [
            'total' => Equipment::count(),
            'in_use' => Equipment::where('status', 'in_use')->count(),
            'under_repair' => Equipment::where('status', 'under_repair')->count(),
            'decommissioned' => Equipment::where('status', 'decommissioned')->count(),
        ];

        return view('admin.pmo.equipment', compact('equipment', 'stats'));
    }

    public function storeEquipment(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'serial_number' => 'required|string|unique:equipment,serial_number',
            'location' => 'nullable|string|max:255',
            'status' => 'required|string|in:in_use,under_repair,available,decommissioned',
            'condition' => 'required|string|in:excellent,good,fair,needs_repair',
            'assigned_to' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $equipment = Equipment::create($validated);

        return response()->json(['success' => true, 'message' => 'Supplier/Item added successfully!', 'data' => $equipment]);
    }

    public function updateEquipment(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'serial_number' => 'required|string|unique:equipment,serial_number,' . $equipment->id,
            'location' => 'nullable|string|max:255',
            'status' => 'required|string|in:in_use,under_repair,available,decommissioned',
            'condition' => 'required|string|in:excellent,good,fair,needs_repair',
            'assigned_to' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $equipment->update($validated);

        return response()->json(['success' => true, 'message' => 'Supplier/Item updated successfully!', 'data' => $equipment]);
    }

    public function destroyEquipment(Equipment $equipment)
    {
        $equipment->delete();

        return response()->json(['success' => true, 'message' => 'Supplier/Item deleted successfully!']);
    }

    // =============================================
    // Order Tracking
    // =============================================

    public function maintenance()
    {
        $maintenanceRequests = MaintenanceRequest::latest()->get();

        $stats = [
            'total' => MaintenanceRequest::count(),
            'pending' => MaintenanceRequest::where('status', 'pending')->count(),
            'in_progress' => MaintenanceRequest::where('status', 'in_progress')->count(),
            'completed' => MaintenanceRequest::where('status', 'completed')->count(),
        ];

        return view('admin.pmo.maintenance', compact('maintenanceRequests', 'stats'));
    }

    public function storeMaintenance(Request $request)
    {
        $validated = $request->validate([
            'request_id' => 'required|string|unique:maintenance_requests,request_id',
            'issue' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'priority' => 'required|string|in:low,medium,high',
            'reporter' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['status'] = 'pending';

        $maintenance = MaintenanceRequest::create($validated);

        return response()->json(['success' => true, 'message' => 'Procurement order submitted successfully!', 'data' => $maintenance]);
    }

    public function assignMaintenance(Request $request, MaintenanceRequest $maintenance)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|string|max:255',
            'target_date' => 'nullable|date',
            'assigned_notes' => 'nullable|string',
        ]);

        $validated['status'] = 'in_progress';

        $maintenance->update($validated);

        return response()->json(['success' => true, 'message' => 'Handler assigned successfully!', 'data' => $maintenance]);
    }

    public function updateMaintenanceStatus(Request $request, MaintenanceRequest $maintenance)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:in_progress,completed,on_hold',
            'progress_notes' => 'nullable|string',
        ]);

        $maintenance->update($validated);

        return response()->json(['success' => true, 'message' => 'Status updated successfully!', 'data' => $maintenance]);
    }

    // =============================================
    // Bid Management
    // =============================================

    public function reservations()
    {
        $reservations = Reservation::latest()->get();

        $stats = [
            'total' => Reservation::count(),
            'pending' => Reservation::where('status', 'pending')->count(),
            'approved' => Reservation::where('status', 'approved')->count(),
            'this_week' => Reservation::where('status', 'approved')
                ->whereBetween('reservation_date', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
        ];

        return view('admin.pmo.reservations', compact('reservations', 'stats'));
    }

    public function storeReservation(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|string|unique:reservations,reservation_id',
            'facility' => 'required|string|max:255',
            'requester' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'reservation_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'purpose' => 'nullable|string|max:255',
            'attendees' => 'nullable|integer|min:1',
            'equipment_needed' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'pending';

        $reservation = Reservation::create($validated);

        return response()->json(['success' => true, 'message' => 'Bid submitted for review!', 'data' => $reservation]);
    }

    public function approveReservation(Request $request, Reservation $reservation)
    {
        $reservation->update([
            'status' => 'approved',
            'admin_note' => $request->input('admin_note'),
        ]);

        return response()->json(['success' => true, 'message' => 'Bid awarded!', 'data' => $reservation]);
    }

    public function rejectReservation(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'reject_reason' => 'required|string|max:255',
            'admin_note' => 'nullable|string',
        ]);

        $reservation->update([
            'status' => 'rejected',
            'reject_reason' => $validated['reject_reason'],
            'admin_note' => $validated['admin_note'] ?? null,
        ]);

        return response()->json(['success' => true, 'message' => 'Bid rejected.', 'data' => $reservation]);
    }

    public function cancelReservation(Request $request, Reservation $reservation)
    {
        $reservation->update([
            'status' => 'cancelled',
            'admin_note' => $request->input('admin_note'),
        ]);

        return response()->json(['success' => true, 'message' => 'Bid cancelled.', 'data' => $reservation]);
    }

    /**
     * PMO Analytics
     */
    public function analytics()
    {
        return view('admin.pmo.analytics');
    }

    /**
     * PMO Reports
     */
    public function reports()
    {
        return view('admin.pmo.reports');
    }

    /**
     * PMO Settings
     */
    public function settings()
    {
        $office = Office::where('code', 'PMO')->first();
        $themeColor = $office ? $office->theme_color : '#009639';

        return view('admin.pmo.settings', compact('themeColor'));
    }

    /**
     * PMO Appearance Update
     */
    public function settingsAppearanceUpdate(Request $request)
    {
        $request->validate([
            'theme_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
        ]);

        $office = Office::where('code', 'PMO')->first();

        if ($office) {
            $office->update(['theme_color' => $request->theme_color]);
            return redirect()->back()->with('success', 'Appearance updated successfully.');
        }

        return redirect()->back()->with('error', 'Office not found.');
    }

    /**
     * Download Reports
     */
    public function downloadReport(Request $request)
    {
        $type = $request->query('type', 'generic');
        $data = [];
        $title = 'Report';

        switch($type) {
            case 'procurement':
            case 'Purchase Request Report':
                $title = 'Purchase Request Report';
                $data = Building::all();
                $type = 'procurement';
                break;
            case 'suppliers':
            case 'Supplier Directory':
                $title = 'Supplier Directory';
                $data = Equipment::all();
                $type = 'suppliers';
                break;
            case 'orders':
            case 'Procurement Summary':
                $title = 'Procurement Summary';
                $data = MaintenanceRequest::all();
                $type = 'orders';
                break;
            default:
                $type = 'generic';
                break;
        }

        $pdf = Pdf::loadView('admin.pmo.pdf.report', compact('data', 'title', 'type'));
        
        while (ob_get_level()) ob_end_clean();
        return $pdf->download(Str::slug($title) . '-' . now()->format('Y-m-d') . '.pdf');
    }

    // ==================== INQUIRIES ====================

    public function inquiries()
    {
        $office = Office::where('code', 'PMO')->first();
        $inquiries = \App\Models\Inquiry::where('office_id', $office?->id)->latest()->get();
        return view('admin.pmo.inquiries', compact('inquiries'));
    }

    public function inquiryShow(\App\Models\Inquiry $inquiry)
    {
        return view('admin.pmo.inquiry-show', compact('inquiry'));
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

        return redirect()->route('pmo.inquiries.show', $inquiry)
            ->with('success', 'Inquiry updated successfully.');
    }
}
