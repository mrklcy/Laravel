<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Service;
use App\Models\Program;
use App\Models\News;
use App\Models\Event;
use App\Models\Slider;
use App\Models\Inquiry;
use App\Models\Admin;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_offices' => Office::count(),
            'total_services' => Service::count(),
            'total_programs' => Program::count(),
            'total_news' => News::count(),
            'pending_inquiries' => Inquiry::where('status', 'pending')->count(),
            'total_inquiries' => Inquiry::count(),
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('status', 'active')->count(),
            'inactive_employees' => Employee::where('status', 'inactive')->count(),
            'on_leave_employees' => Employee::where('status', 'on_leave')->count(),
            'retired_employees' => Employee::where('status', 'retired')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * HRMO Dashboard
     */
    public function hrmDashboard()
    {
        // Check if user has HRMO admin role
        $admin = Auth::guard('admin')->user();
        if ($admin->role !== 'hrmo_admin' && $admin->role !== 'super_admin') {
            abort(403, 'Unauthorized access to HRMO dashboard.');
        }

        // Filter all stats to only Human Resources department
        $stats = [
            'total_employees' => Employee::where('department', 'Human Resources')->count(),
            'active_employees' => Employee::where('department', 'Human Resources')->where('status', 'active')->count(),
            'inactive_employees' => Employee::where('department', 'Human Resources')->where('status', 'inactive')->count(),
            'on_leave_employees' => Employee::where('department', 'Human Resources')->where('status', 'on_leave')->count(),
            'retired_employees' => Employee::where('department', 'Human Resources')->where('status', 'retired')->count(),
            'regular_employees' => Employee::where('department', 'Human Resources')->where('employment_status', 'regular')->count(),
            'contractual_employees' => Employee::where('department', 'Human Resources')->where('employment_status', 'contractual')->count(),
            'casual_employees' => Employee::where('department', 'Human Resources')->where('employment_status', 'casual')->count(),
            'new_hires_this_month' => Employee::where('department', 'Human Resources')
                                              ->whereMonth('date_hired', now()->month)
                                              ->whereYear('date_hired', now()->year)
                                              ->count(),
        ];

        // Get recent employees - only from Human Resources department
        $recent_employees = Employee::with('office')
                                    ->where('department', 'Human Resources')
                                    ->latest()
                                    ->take(5)
                                    ->get();

        // Get department statistics - only Human Resources
        $departments = Employee::selectRaw('department, COUNT(*) as count')
                               ->where('department', 'Human Resources')
                               ->whereNotNull('department')
                               ->groupBy('department')
                               ->orderByDesc('count')
                               ->get();

        return view('admin.hrm.dashboard', compact('stats', 'recent_employees', 'departments'));
    }

    // ==================== OFFICES ====================
    
    public function officesIndex()
    {
        $adso = Office::where('code', 'ADSO')->with('children')->first();
        $offices = $adso ? $adso->children()->orderBy('order')->get() : collect();

        return view('admin.offices.index', compact('offices'));
    }

    public function officesCreate()
    {
        $parentOffices = Office::whereNull('parent_id')->orderBy('name')->get();
        return view('admin.offices.create', compact('parentOffices'));
    }

    public function officesStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:offices,code',
            'acronym' => 'required|string|max:50',
            'overview' => 'nullable|string',
            'parent_id' => 'nullable|exists:offices,id',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Office::create($validated);

        return redirect()->route('admin.offices.index')
            ->with('success', 'Office created successfully.');
    }

    public function officesEdit(Office $office)
    {
        $parentOffices = Office::whereNull('parent_id')
            ->where('id', '!=', $office->id)
            ->orderBy('name')
            ->get();
        
        return view('admin.offices.edit', compact('office', 'parentOffices'));
    }

    public function officesUpdate(Request $request, Office $office)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:offices,code,' . $office->id,
            'acronym' => 'required|string|max:50',
            'overview' => 'nullable|string',
            'parent_id' => 'nullable|exists:offices,id',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $office->update($validated);

        return redirect()->route('admin.offices.index')
            ->with('success', 'Office updated successfully.');
    }

    public function officesDestroy(Office $office)
    {
        if ($office->children()->count() > 0) {
            return redirect()->route('admin.offices.index')
                ->with('error', 'Cannot delete office with sub-offices.');
        }

        $office->delete();

        return redirect()->route('admin.offices.index')
            ->with('success', 'Office deleted successfully.');
    }

    // ==================== SERVICES ====================
    
    public function servicesIndex()
    {
        $services = Service::with('office')->orderBy('order')->get();
        return view('admin.services.index', compact('services'));
    }

    public function servicesCreate()
    {
        $offices = Office::active()->orderBy('name')->get();
        return view('admin.services.create', compact('offices'));
    }

    public function servicesStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'office_id' => 'required|exists:offices,id',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function servicesEdit(Service $service)
    {
        $offices = Office::active()->orderBy('name')->get();
        return view('admin.services.edit', compact('service', 'offices'));
    }

    public function servicesUpdate(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'office_id' => 'required|exists:offices,id',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function servicesDestroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    // ==================== PROGRAMS ====================
    
    public function programsIndex()
    {
        $programs = Program::with('office')->orderBy('order')->get();
        return view('admin.programs.index', compact('programs'));
    }

    public function programsCreate()
    {
        $offices = Office::active()->orderBy('name')->get();
        return view('admin.programs.create', compact('offices'));
    }

    public function programsStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'office_id' => 'required|exists:offices,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        Program::create($validated);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program created successfully.');
    }

    public function programsEdit(Program $program)
    {
        $offices = Office::active()->orderBy('name')->get();
        return view('admin.programs.edit', compact('program', 'offices'));
    }

    public function programsUpdate(Request $request, Program $program)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'office_id' => 'required|exists:offices,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        $program->update($validated);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program updated successfully.');
    }

    public function programsDestroy(Program $program)
    {
        $program->delete();

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program deleted successfully.');
    }

    // ==================== NEWS ====================
    
    public function newsIndex()
    {
        $news = News::with('office')->latest()->get();
        return view('admin.news.index', compact('news'));
    }

    public function newsCreate()
    {
        $offices = Office::active()->orderBy('name')->get();
        return view('admin.news.create', compact('offices'));
    }

    public function newsStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'office_id' => 'required|exists:offices,id',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        News::create($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'News created successfully.');
    }

    public function newsEdit(News $news)
    {
        $offices = Office::active()->orderBy('name')->get();
        return view('admin.news.edit', compact('news', 'offices'));
    }

    public function newsUpdate(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'office_id' => 'required|exists:offices,id',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');
        
        if ($validated['is_published'] && !$news->published_at) {
            $validated['published_at'] = now();
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'News updated successfully.');
    }

    public function newsDestroy(News $news)
    {
        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'News deleted successfully.');
    }

    // ==================== INQUIRIES ====================
    
    public function inquiriesIndex()
    {
        $inquiries = Inquiry::with('office')->latest()->get();
        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function inquiriesShow(Inquiry $inquiry)
    {
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function inquiriesUpdate(Request $request, Inquiry $inquiry)
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

        return redirect()->route('admin.inquiries.show', $inquiry)
            ->with('success', 'Inquiry updated successfully.');
    }

    public function inquiriesDestroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')
            ->with('success', 'Inquiry deleted successfully.');
    }

    // ==================== EMPLOYEES ====================
    
    public function usersIndex()
    {
        $employees = Employee::with('office')->latest()->get();
        return view('admin.users.index', compact('employees'));
    }

    public function usersCreate()
    {
        $offices = Office::all();
        return view('admin.users.create', compact('offices'));
    }

    public function usersStore(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|string|unique:employees',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees',
            'phone' => 'nullable|string',
            'office_id' => 'nullable|exists:offices,id',
            'position' => 'nullable|string',
            'department' => 'nullable|string',
            'date_hired' => 'nullable|date',
            'employment_status' => 'required|in:regular,casual,contractual,job_order',
            'status' => 'required|in:active,inactive,on_leave,retired',
        ]);

        Employee::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Employee created successfully.');
    }

    public function usersEdit($id)
    {
        $employee = Employee::findOrFail($id);
        $offices = Office::all();
        return view('admin.users.edit', compact('employee', 'offices'));
    }

    public function usersUpdate(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        
        $validated = $request->validate([
            'employee_id' => 'required|string|unique:employees,employee_id,' . $id,
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone' => 'nullable|string',
            'office_id' => 'nullable|exists:offices,id',
            'position' => 'nullable|string',
            'department' => 'nullable|string',
            'date_hired' => 'nullable|date',
            'employment_status' => 'required|in:regular,casual,contractual,job_order',
            'status' => 'required|in:active,inactive,on_leave,retired',
        ]);

        $employee->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function usersDestroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Employee deleted successfully.');
    }

    // ==================== SETTINGS & REPORTS ====================
    
    public function settings()
    {
        $admin = Auth::guard('admin')->user();
        $officeCode = $this->getOfficeCode($admin->role);
        $office = Office::where('code', $officeCode)->first();
        $themeColor = $office ? $office->theme_color : '#009639';

        return view('admin.settings', compact('themeColor'));
    }

    /**
     * Update appearance settings
     */
    public function settingsAppearanceUpdate(Request $request)
    {
        $request->validate([
            'theme_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
        ]);

        $admin = Auth::guard('admin')->user();
        $officeCode = $this->getOfficeCode($admin->role);
        $office = Office::where('code', $officeCode)->first();

        if ($office) {
            $office->update(['theme_color' => $request->theme_color]);
            return redirect()->back()->with('success', 'Appearance updated successfully.');
        }

        return redirect()->back()->with('error', 'Office not found for current role.');
    }

    /**
     * Helper to get office code based on role
     */
    private function getOfficeCode($role)
    {
        return match ($role) {
            'super_admin', 'admin' => 'ADSO',
            'hrmo_admin' => 'HRMO',
            'pmo_admin' => 'PMO',
            'pso_admin' => 'PSO',
            'rmo_admin' => 'RMO',
            default => 'ADSO',
        };
    }

    public function analytics()
    {
        $stats = [
            'total_offices' => Office::count(),
            'active_offices' => Office::where('is_active', true)->count(),
            'total_services' => Service::count(),
            'active_services' => Service::where('is_active', true)->count(),
            'total_programs' => Program::count(),
            'active_programs' => Program::where('is_active', true)->count(),
            'total_news' => News::count(),
            'published_news' => News::where('is_published', true)->count(),
            'total_inquiries' => Inquiry::count(),
            'pending_inquiries' => Inquiry::where('status', 'pending')->count(),
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('status', 'active')->count(),
        ];

        return view('admin.analytics', compact('stats'));
    }

    public function reports()
    {
        $stats = [
            'total_offices' => Office::count(),
            'active_offices' => Office::where('is_active', true)->count(),
            'total_services' => Service::count(),
            'active_services' => Service::where('is_active', true)->count(),
            'total_programs' => Program::count(),
            'active_programs' => Program::where('is_active', true)->count(),
            'total_news' => News::count(),
            'published_news' => News::where('is_published', true)->count(),
            'total_inquiries' => Inquiry::count(),
            'pending_inquiries' => Inquiry::where('status', 'pending')->count(),
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('status', 'active')->count(),
        ];

        return view('admin.reports', compact('stats'));
    }

    // ==================== HRM-SPECIFIC VIEWS ====================
    
    /**
     * HRM Employees View (uses HRM layout)
     */
    public function hrmEmployees()
    {
        // Only show employees from Human Resources department
        $employees = Employee::with('office')
                            ->where('department', 'Human Resources')
                            ->latest()
                            ->get();
        return view('admin.hrm.employees', compact('employees'));
    }

    /**
     * HRM Analytics View (uses HRM layout)
     */
    public function hrmAnalytics()
    {
        // Only show stats for Human Resources department
        $stats = [
            'total_employees' => Employee::where('department', 'Human Resources')->count(),
            'active_employees' => Employee::where('department', 'Human Resources')->where('status', 'active')->count(),
            'inactive_employees' => Employee::where('department', 'Human Resources')->where('status', 'inactive')->count(),
            'on_leave_employees' => Employee::where('department', 'Human Resources')->where('status', 'on_leave')->count(),
            'retired_employees' => Employee::where('department', 'Human Resources')->where('status', 'retired')->count(),
        ];

        return view('admin.hrm.analytics', compact('stats'));
    }

    /**
     * HRM Reports View (uses HRM layout)
     */
    public function hrmReports()
    {
        // Only show stats for Human Resources department
        $stats = [
            'total_employees' => Employee::where('department', 'Human Resources')->count(),
            'active_employees' => Employee::where('department', 'Human Resources')->where('status', 'active')->count(),
            'inactive_employees' => Employee::where('department', 'Human Resources')->where('status', 'inactive')->count(),
            'on_leave_employees' => Employee::where('department', 'Human Resources')->where('status', 'on_leave')->count(),
            'retired_employees' => Employee::where('department', 'Human Resources')->where('status', 'retired')->count(),
        ];

        return view('admin.hrm.reports', compact('stats'));
    }

    /**
     * HRM Employees Create Form
     */
    public function hrmEmployeesCreate()
    {
        $offices = Office::all();
        return view('admin.hrm.employees-create', compact('offices'));
    }

    /**
     * HRM Employees Store (HR department only)
     */
    public function hrmEmployeesStore(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|string|unique:employees',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees',
            'phone' => 'nullable|string',
            'office_id' => 'nullable|exists:offices,id',
            'position' => 'nullable|string',
            'date_hired' => 'nullable|date',
            'employment_status' => 'required|in:regular,casual,contractual,job_order',
            'status' => 'required|in:active,inactive,on_leave,retired',
        ]);

        // Force department to be Human Resources
        $validated['department'] = 'Human Resources';

        Employee::create($validated);

        return redirect()->route('admin.hrm.employees')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * HRM Employees Edit Form
     */
    public function hrmEmployeesEdit($id)
    {
        $employee = Employee::where('department', 'Human Resources')->findOrFail($id);
        $offices = Office::all();
        return view('admin.hrm.employees-edit', compact('employee', 'offices'));
    }

    /**
     * HRM Employees Update
     */
    public function hrmEmployeesUpdate(Request $request, $id)
    {
        $employee = Employee::where('department', 'Human Resources')->findOrFail($id);
        
        $validated = $request->validate([
            'employee_id' => 'required|string|unique:employees,employee_id,' . $id,
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone' => 'nullable|string',
            'office_id' => 'nullable|exists:offices,id',
            'position' => 'nullable|string',
            'date_hired' => 'nullable|date',
            'employment_status' => 'required|in:regular,casual,contractual,job_order',
            'status' => 'required|in:active,inactive,on_leave,retired',
        ]);

        // Ensure department remains Human Resources
        $validated['department'] = 'Human Resources';

        $employee->update($validated);

        return redirect()->route('admin.hrm.employees')
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * HRM Employees Delete
     */
    public function hrmEmployeesDestroy($id)
    {
        $employee = Employee::where('department', 'Human Resources')->findOrFail($id);
        $employee->delete();

        return redirect()->route('admin.hrm.employees')
            ->with('success', 'Employee deleted successfully.');
    }

    /**
     * HRM Settings View
     */
    public function hrmSettings()
    {
        $office = Office::where('code', 'HRMO')->first();
        $themeColor = $office ? $office->theme_color : '#009639';

        return view('admin.hrm.settings', compact('themeColor'));
    }

    /**
     * HRM Appearance Update
     */
    public function hrmSettingsAppearanceUpdate(Request $request)
    {
        $request->validate([
            'theme_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
        ]);

        $office = Office::where('code', 'HRMO')->first();

        if ($office) {
            $office->update(['theme_color' => $request->theme_color]);
            return redirect()->back()->with('success', 'Appearance updated successfully.');
        }

        return redirect()->back()->with('error', 'Office not found.');
    }

    /**
     * HRM Inquiries
     */
    public function hrmInquiries()
    {
        $office = Office::where('code', 'HRMO')->first();
        $inquiries = Inquiry::where('office_id', $office?->id)->latest()->get();
        return view('admin.hrm.inquiries', compact('inquiries'));
    }

    public function hrmInquiryShow(Inquiry $inquiry)
    {
        return view('admin.hrm.inquiry-show', compact('inquiry'));
    }

    public function hrmInquiryUpdate(Request $request, Inquiry $inquiry)
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

        return redirect()->route('admin.hrm.inquiries.show', $inquiry)
            ->with('success', 'Inquiry updated successfully.');
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
            case 'Offices Summary':
            case 'offices':
                $title = 'Offices Summary';
                $data = Office::all();
                $type = 'offices';
                break;
            case 'Services Summary':
            case 'services':
                $title = 'Services Summary';
                $data = Service::with('office')->get();
                $type = 'services';
                break;
            case 'Programs Summary':
            case 'programs':
                $title = 'Programs Summary';
                $data = Program::with('office')->get();
                $type = 'programs';
                break;
            case 'News Summary':
            case 'news':
                $title = 'News Summary';
                $data = News::with('office')->latest()->get();
                $type = 'news';
                break;
            case 'Inquiries Summary':
            case 'inquiries':
                $title = 'Inquiries Summary';
                $data = Inquiry::latest()->get();
                $type = 'inquiries';
                break;
            case 'Users Summary':
            case 'users':
                $title = 'User Accounts Summary';
                $data = Employee::with('office')->latest()->get();
                $type = 'users';
                break;
            default:
                $type = 'generic';
                break;
        }

        $pdf = Pdf::loadView('admin.pdf.report', compact('data', 'title', 'type'));
        
        while (ob_get_level()) ob_end_clean();
        return $pdf->download(Str::slug($title) . '-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Generate HRM Report
     */
    public function hrmGenerateReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|string',
            'format' => 'nullable|string',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'status' => 'nullable|array',
        ]);

        $statuses = $request->input('status', ['active', 'on_leave', 'inactive', 'retired']);

        $query = Employee::where('department', 'Human Resources');

        $data = null;
        $title = $request->report_type;

        switch ($request->report_type) {
            case 'Employee List':
                $query->whereIn('status', $statuses);
                if ($request->date_from && $request->date_to) {
                    $query->whereBetween('date_hired', [$request->date_from, $request->date_to]);
                }
                $data = $query->with('office')->orderBy('last_name')->get();
                break;

            case 'Status Summary':
                $data = Employee::where('department', 'Human Resources')
                    ->select('status', \DB::raw('count(*) as total'))
                    ->groupBy('status')
                    ->pluck('total', 'status');
                break;

            case 'Employment Type Distribution':
                $data = Employee::where('department', 'Human Resources')
                    ->select('employment_status', \DB::raw('count(*) as total'))
                    ->groupBy('employment_status')
                    ->pluck('total', 'employment_status');
                break;

            case 'Department Overview':
                // Group by Office for HR employees
                $data = Employee::where('department', 'Human Resources')
                    ->leftJoin('offices', 'employees.office_id', '=', 'offices.id')
                    ->select(\DB::raw('COALESCE(offices.name, "Unassigned") as office_name'), \DB::raw('count(*) as total'))
                    ->groupBy('office_name')
                    ->pluck('total', 'office_name');
                break;
        }

        $pdf = Pdf::loadView('admin.hrm.pdf-report', [
            'data' => $data,
            'title' => $title,
            'reportType' => $request->report_type,
            'dateFrom' => $request->date_from,
            'dateTo' => $request->date_to,
            'filters' => $statuses
        ]);

        while (ob_get_level()) ob_end_clean();
        return $pdf->download(Str::slug($title) . '_' . now()->format('Y-m-d_His') . '.pdf');
    }

    // ==================== OVERVIEW ====================

    public function overview()
    {
        $admin = Auth::guard('admin')->user();
        if ($admin->role !== 'super_admin') {
            abort(403, 'Unauthorized access.');
        }

        $sliders = Slider::ordered()->get();
        $stats = [
            'total_news' => News::count(),
            'total_programs' => Program::count(),
            'total_events' => Event::count(),
            'total_services' => Service::count(),
            'total_offices' => Office::count(),
        ];

        $adso = Office::where('code', 'ADSO')->first();

        return view('admin.overview', compact('sliders', 'stats', 'adso'));
    }

    // ==================== APPEARANCE ====================

    public function updateAppearance(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if ($admin->role !== 'super_admin') {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'primary_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'secondary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'accent_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $adso = Office::where('code', 'ADSO')->first();
        if ($adso) {
            $adso->update([
                'website_theme_color' => $request->primary_color,
            ]);
        }

        return back()->with('success', 'Website appearance updated successfully!');
    }

    // ==================== SLIDERS ====================

    public function sliderStore(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        $file = $request->file('image');
        $filename = 'slider_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/slider'), $filename);

        Slider::create([
            'image' => 'images/slider/' . $filename,
            'title' => $request->title,
            'caption' => $request->caption,
            'order' => $request->order ?? Slider::max('order') + 1,
            'is_active' => true,
        ]);

        return redirect()->route('admin.overview')->with('success', 'Slider image added successfully.');
    }

    public function sliderUpdate(Request $request, Slider $slider)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'caption' => $request->caption,
            'order' => $request->order ?? $slider->order,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            $oldPath = public_path($slider->image);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            $file = $request->file('image');
            $filename = 'slider_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/slider'), $filename);
            $data['image'] = 'images/slider/' . $filename;
        }

        $slider->update($data);

        return redirect()->route('admin.overview')->with('success', 'Slider updated successfully.');
    }

    public function sliderDestroy(Slider $slider)
    {
        $path = public_path($slider->image);
        if (file_exists($path)) {
            unlink($path);
        }

        $slider->delete();

        return redirect()->route('admin.overview')->with('success', 'Slider deleted successfully.');
    }

    // ==================== EVENTS ====================

    public function eventsIndex()
    {
        $events = Event::with('office')->orderBy('event_date', 'desc')->get();
        return view('admin.events.index', compact('events'));
    }

    public function eventsCreate()
    {
        $offices = Office::active()->orderBy('name')->get();
        return view('admin.events.create', compact('offices'));
    }

    public function eventsStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'office_id' => 'nullable|exists:offices,id',
            'location' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'event_end_date' => 'nullable|date|after_or_equal:event_date',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    public function eventsEdit(Event $event)
    {
        $offices = Office::active()->orderBy('name')->get();
        return view('admin.events.edit', compact('event', 'offices'));
    }

    public function eventsUpdate(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'office_id' => 'nullable|exists:offices,id',
            'location' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'event_end_date' => 'nullable|date|after_or_equal:event_date',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function eventsDestroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }
}


