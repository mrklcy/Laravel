<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Project;
use App\Models\StrategicPlan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PsoController extends Controller
{
    /**
     * Display Property and Supply Office dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_strategic_plans' => StrategicPlan::count(),
            'active_projects' => Project::where('status', 'active')->count(),
            'completed_projects' => Project::where('status', 'completed')->count(),
            'pending_reviews' => StrategicPlan::where('status', 'under_review')->count(),
        ];

        return view('admin.pso.dashboard', compact('stats'));
    }

    // =============================================
    // Supply Management
    // =============================================

    public function strategicPlans()
    {
        $plans = StrategicPlan::latest()->get();

        $stats = [
            'total' => StrategicPlan::count(),
            'active' => StrategicPlan::where('status', 'active')->count(),
            'under_review' => StrategicPlan::where('status', 'under_review')->count(),
            'archived' => StrategicPlan::where('status', 'archived')->count(),
        ];

        return view('admin.pso.strategic-plans', compact('plans', 'stats'));
    }

    public function storeStrategicPlan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'focus_area' => 'required|string',
            'period' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,under_review,archived,draft',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        // Auto-generate plan code: SP-YEAR-NNN
        $year = date('Y');
        $latest = StrategicPlan::where('plan_code', 'like', "SP-{$year}-%")
            ->orderByRaw("CAST(SUBSTRING_INDEX(plan_code, '-', -1) AS UNSIGNED) DESC")
            ->value('plan_code');

        $nextNum = 1;
        if ($latest) {
            $parts = explode('-', $latest);
            $nextNum = (int) end($parts) + 1;
        }

        $planCode = "SP-{$year}-" . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        StrategicPlan::create([
            'plan_code' => $planCode,
            'name' => $request->name,
            'description' => $request->description,
            'focus_area' => $request->focus_area,
            'period' => $request->period,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'progress' => $request->progress ?? 0,
        ]);

        return response()->json(['success' => true, 'message' => 'Strategic Plan created successfully!']);
    }

    public function updateStrategicPlan(Request $request, StrategicPlan $strategicPlan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'focus_area' => 'required|string',
            'period' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,under_review,archived,draft',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        $strategicPlan->update($request->only([
            'name', 'description', 'focus_area', 'period',
            'start_date', 'end_date', 'status', 'progress',
        ]));

        return response()->json(['success' => true, 'message' => 'Strategic Plan updated successfully!']);
    }

    public function destroyStrategicPlan(StrategicPlan $strategicPlan)
    {
        $strategicPlan->delete();
        return response()->json(['success' => true, 'message' => 'Strategic Plan deleted successfully!']);
    }

    // =============================================
    // Property Records Management
    // =============================================

    public function projects()
    {
        $projects = Project::latest()->get();

        $stats = [
            'total' => Project::count(),
            'active' => Project::where('status', 'active')->count(),
            'completed' => Project::where('status', 'completed')->count(),
            'on_hold' => Project::where('status', 'on_hold')->count(),
        ];

        return view('admin.pso.projects', compact('projects', 'stats'));
    }

    /**
     * Store a new project
     */
    public function storeProject(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,on_hold,completed,cancelled',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        // Auto-generate project code: PRJ-YEAR-NNN
        $year = date('Y');
        $latest = Project::where('project_code', 'like', "PRJ-{$year}-%")
            ->orderByRaw("CAST(SUBSTRING_INDEX(project_code, '-', -1) AS UNSIGNED) DESC")
            ->value('project_code');

        $nextNum = 1;
        if ($latest) {
            $parts = explode('-', $latest);
            $nextNum = (int) end($parts) + 1;
        }

        $projectCode = "PRJ-{$year}-" . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        Project::create([
            'project_code' => $projectCode,
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'budget' => $request->budget,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'progress' => $request->progress ?? 0,
        ]);

        return response()->json(['success' => true, 'message' => 'Project created successfully!']);
    }

    /**
     * Update an existing project
     */
    public function updateProject(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,on_hold,completed,cancelled',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        $project->update($request->only([
            'name', 'description', 'category', 'budget',
            'start_date', 'end_date', 'status', 'progress',
        ]));

        return response()->json(['success' => true, 'message' => 'Project updated successfully!']);
    }

    /**
     * Delete a project
     */
    public function destroyProject(Project $project)
    {
        $project->delete();
        return response()->json(['success' => true, 'message' => 'Project deleted successfully!']);
    }

    /**
     * Display performance metrics page
     */
    public function performance()
    {
        return view('admin.pso.performance');
    }

    /**
     * Display reports page
     */
    public function reports()
    {
        return view('admin.pso.reports');
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|string',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;

        $pdf = null;
        $filename = '';

        switch ($request->report_type) {
            case 'Strategic Plan Progress':
                $query = StrategicPlan::query();
                if ($dateFrom && $dateTo) {
                    $query->whereBetween('updated_at', [$dateFrom, $dateTo]);
                }
                $data = $query->get();
                $pdf = Pdf::loadView('admin.pso.reports.strategic-plan', compact('data', 'dateFrom', 'dateTo'));
                $filename = 'Strategic_Plan_Progress_' . now()->format('Y-m-d_His') . '.pdf';
                break;

            case 'Project Portfolio':
                $query = Project::query();
                if ($dateFrom && $dateTo) {
                    $query->whereBetween('updated_at', [$dateFrom, $dateTo]);
                }
                $data = $query->get();
                $pdf = Pdf::loadView('admin.pso.reports.project-portfolio', compact('data', 'dateFrom', 'dateTo'));
                $filename = 'Project_Portfolio_' . now()->format('Y-m-d_His') . '.pdf';
                break;

            case 'Performance Dashboard':
            default:
                $totalProjects = Project::count();
                $stats = [
                    'total_plans' => StrategicPlan::count(),
                    'active_plans' => StrategicPlan::where('status', 'active')->count(),
                    'total_projects' => $totalProjects,
                    'completed_projects' => Project::where('status', 'completed')->count(),
                    'project_status_counts' => [
                        'Active' => Project::where('status', 'active')->count(),
                        'On Hold' => Project::where('status', 'on_hold')->count(),
                        'Completed' => Project::where('status', 'completed')->count(),
                        'Cancelled' => Project::where('status', 'cancelled')->count(),
                    ]
                ];
                $pdf = Pdf::loadView('admin.pso.reports.performance', compact('stats'));
                $filename = 'Performance_Dashboard_' . now()->format('Y-m-d_His') . '.pdf';
                break;
        }

        return $pdf->download($filename);
    }

    /**
     * Display analytics page
     */
    public function analytics()
    {
        $stats = [
            'total_strategic_plans' => StrategicPlan::count(),
            'active_projects' => Project::where('status', 'active')->count(),
            'completed_projects' => Project::where('status', 'completed')->count(),
            'pending_reviews' => StrategicPlan::where('status', 'under_review')->count(),
            'project_status_counts' => [
                'On Track' => Project::where('status', 'active')->where('progress', '>', 0)->count(),
                'Delayed' => 0,
                'Completed' => Project::where('status', 'completed')->count(),
                'On Hold' => Project::where('status', 'on_hold')->count(),
            ],
            'monthly_project_starts' => [4, 6, 8, 5, 9, 7, 10]
        ];

        return view('admin.pso.analytics', compact('stats'));
    }

    /**
     * Display settings page
     */
    public function settings()
    {
        $office = Office::where('code', 'PSO')->first();
        $themeColor = $office ? $office->theme_color : '#009639';

        return view('admin.pso.settings', compact('themeColor'));
    }

    /**
     * PSO Appearance Update
     */
    public function settingsAppearanceUpdate(Request $request)
    {
        $request->validate([
            'theme_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
        ]);

        $office = Office::where('code', 'PSO')->first();

        if ($office) {
            $office->update(['theme_color' => $request->theme_color]);
            return redirect()->back()->with('success', 'Appearance updated successfully.');
        }

        return redirect()->back()->with('error', 'Office not found.');
    }

    // ==================== INQUIRIES ====================

    public function inquiries()
    {
        $office = Office::where('code', 'PSO')->first();
        $inquiries = \App\Models\Inquiry::where('office_id', $office?->id)->latest()->get();
        return view('admin.pso.inquiries', compact('inquiries'));
    }

    public function inquiryShow(\App\Models\Inquiry $inquiry)
    {
        return view('admin.pso.inquiry-show', compact('inquiry'));
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

        return redirect()->route('pso.inquiries.show', $inquiry)
            ->with('success', 'Inquiry updated successfully.');
    }
}
