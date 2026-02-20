<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\InquiryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PmoController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/office/{code}', [OfficeController::class, 'show'])->name('office.show');

// News Routes
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// Services Routes
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

// Programs Routes
Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
Route::get('/programs/{slug}', [ProgramController::class, 'show'])->name('programs.show');

// Inquiry Routes
Route::get('/contact', [InquiryController::class, 'create'])->name('inquiries.create');
Route::post('/contact', [InquiryController::class, 'store'])->name('inquiries.store');

// Public office detail page
Route::get('/office/{code}', [OfficeController::class, 'show'])->name('office.show');

// Protected PMO Routes
Route::prefix('pmo')->name('pmo.')->middleware('pmo.auth')->group(function () {
    Route::get('/dashboard', [PmoController::class, 'dashboard'])->name('dashboard');
    Route::get('/buildings', [PmoController::class, 'buildings'])->name('buildings');
    Route::post('/buildings', [PmoController::class, 'storeBuilding'])->name('buildings.store');
    Route::put('/buildings/{building}', [PmoController::class, 'updateBuilding'])->name('buildings.update');
    Route::delete('/buildings/{building}', [PmoController::class, 'destroyBuilding'])->name('buildings.destroy');
    Route::get('/equipment', [PmoController::class, 'equipment'])->name('equipment');
    Route::post('/equipment', [PmoController::class, 'storeEquipment'])->name('equipment.store');
    Route::put('/equipment/{equipment}', [PmoController::class, 'updateEquipment'])->name('equipment.update');
    Route::delete('/equipment/{equipment}', [PmoController::class, 'destroyEquipment'])->name('equipment.destroy');
    Route::get('/maintenance', [PmoController::class, 'maintenance'])->name('maintenance');
    Route::post('/maintenance', [PmoController::class, 'storeMaintenance'])->name('maintenance.store');
    Route::put('/maintenance/{maintenance}/assign', [PmoController::class, 'assignMaintenance'])->name('maintenance.assign');
    Route::put('/maintenance/{maintenance}/status', [PmoController::class, 'updateMaintenanceStatus'])->name('maintenance.status');
    Route::get('/reservations', [PmoController::class, 'reservations'])->name('reservations');
    Route::post('/reservations', [PmoController::class, 'storeReservation'])->name('reservations.store');
    Route::put('/reservations/{reservation}/approve', [PmoController::class, 'approveReservation'])->name('reservations.approve');
    Route::put('/reservations/{reservation}/reject', [PmoController::class, 'rejectReservation'])->name('reservations.reject');
    Route::put('/reservations/{reservation}/cancel', [PmoController::class, 'cancelReservation'])->name('reservations.cancel');
    Route::get('/analytics', [PmoController::class, 'analytics'])->name('analytics');
    Route::get('/reports', [PmoController::class, 'reports'])->name('reports');
    Route::get('/reports/download', [PmoController::class, 'downloadReport'])->name('reports.download');
    Route::get('/settings', [PmoController::class, 'settings'])->name('settings');
    Route::put('/settings/appearance', [PmoController::class, 'settingsAppearanceUpdate'])->name('settings.appearance');
    Route::get('/inquiries', [PmoController::class, 'inquiries'])->name('inquiries');
    Route::get('/inquiries/{inquiry}', [PmoController::class, 'inquiryShow'])->name('inquiries.show');
    Route::put('/inquiries/{inquiry}', [PmoController::class, 'inquiryUpdate'])->name('inquiries.update');
});

// Protected PSO Routes
Route::prefix('pso')->name('pso.')->middleware('pso.auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\PsoController::class, 'dashboard'])->name('dashboard');
    Route::get('/strategic-plans', [App\Http\Controllers\PsoController::class, 'strategicPlans'])->name('strategic-plans');
    Route::post('/strategic-plans', [App\Http\Controllers\PsoController::class, 'storeStrategicPlan'])->name('strategic-plans.store');
    Route::put('/strategic-plans/{strategicPlan}', [App\Http\Controllers\PsoController::class, 'updateStrategicPlan'])->name('strategic-plans.update');
    Route::delete('/strategic-plans/{strategicPlan}', [App\Http\Controllers\PsoController::class, 'destroyStrategicPlan'])->name('strategic-plans.destroy');
    Route::get('/projects', [App\Http\Controllers\PsoController::class, 'projects'])->name('projects');
    Route::post('/projects', [App\Http\Controllers\PsoController::class, 'storeProject'])->name('projects.store');
    Route::put('/projects/{project}', [App\Http\Controllers\PsoController::class, 'updateProject'])->name('projects.update');
    Route::delete('/projects/{project}', [App\Http\Controllers\PsoController::class, 'destroyProject'])->name('projects.destroy');
    Route::get('/performance', [App\Http\Controllers\PsoController::class, 'performance'])->name('performance');
    Route::get('/reports', [App\Http\Controllers\PsoController::class, 'reports'])->name('reports');
    Route::post('/reports/generate', [App\Http\Controllers\PsoController::class, 'generateReport'])->name('reports.generate');
    Route::get('/analytics', [App\Http\Controllers\PsoController::class, 'analytics'])->name('analytics');
    Route::get('/settings', [App\Http\Controllers\PsoController::class, 'settings'])->name('settings');
    Route::put('/settings/appearance', [App\Http\Controllers\PsoController::class, 'settingsAppearanceUpdate'])->name('settings.appearance');
    Route::get('/inquiries', [App\Http\Controllers\PsoController::class, 'inquiries'])->name('inquiries');
    Route::get('/inquiries/{inquiry}', [App\Http\Controllers\PsoController::class, 'inquiryShow'])->name('inquiries.show');
    Route::put('/inquiries/{inquiry}', [App\Http\Controllers\PsoController::class, 'inquiryUpdate'])->name('inquiries.update');
});

// Protected RMO Routes
Route::prefix('rmo')->name('rmo.')->middleware('rmo.auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\RmoController::class, 'dashboard'])->name('dashboard');
    Route::get('/documents', [App\Http\Controllers\RmoController::class, 'documents'])->name('documents');
    Route::post('/documents', [App\Http\Controllers\RmoController::class, 'storeDocument'])->name('documents.store');
    Route::get('/documents/next-ref', [App\Http\Controllers\RmoController::class, 'nextRef'])->name('documents.next-ref');
    Route::get('/documents/{document}', [App\Http\Controllers\RmoController::class, 'showDocument'])->name('documents.show');
    Route::get('/documents/{document}/download', [App\Http\Controllers\RmoController::class, 'downloadDocument'])->name('documents.download');
    Route::post('/documents/{document}/archive', [App\Http\Controllers\RmoController::class, 'archiveDocument'])->name('documents.archive');
    Route::post('/documents/{document}/restore', [App\Http\Controllers\RmoController::class, 'restoreDocument'])->name('documents.restore');
    Route::post('/documents/{document}/digitize', [App\Http\Controllers\RmoController::class, 'digitizeDocument'])->name('documents.digitize');
    Route::delete('/documents/{document}', [App\Http\Controllers\RmoController::class, 'destroy'])->name('documents.destroy');
    Route::get('/archives', [App\Http\Controllers\RmoController::class, 'archives'])->name('archives');
    Route::get('/requests', [App\Http\Controllers\RmoController::class, 'requests'])->name('requests');
    Route::get('/reports', [App\Http\Controllers\RmoController::class, 'reports'])->name('reports');
    Route::post('/reports/generate', [App\Http\Controllers\RmoController::class, 'generateReport'])->name('reports.generate');
    Route::get('/analytics', [App\Http\Controllers\RmoController::class, 'analytics'])->name('analytics');
    Route::get('/settings', [App\Http\Controllers\RmoController::class, 'settings'])->name('settings');
    Route::put('/settings/appearance', [App\Http\Controllers\RmoController::class, 'settingsAppearanceUpdate'])->name('settings.appearance');
    Route::get('/inquiries', [App\Http\Controllers\RmoController::class, 'inquiries'])->name('inquiries');
    Route::get('/inquiries/{inquiry}', [App\Http\Controllers\RmoController::class, 'inquiryShow'])->name('inquiries.show');
    Route::put('/inquiries/{inquiry}', [App\Http\Controllers\RmoController::class, 'inquiryUpdate'])->name('inquiries.update');
});

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});

// Protected Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Overview (super admin website management)
    Route::get('/overview', [AdminController::class, 'overview'])->name('overview');

    // Slider management
    Route::post('/overview/sliders', [AdminController::class, 'sliderStore'])->name('sliders.store');
    Route::put('/overview/sliders/{slider}', [AdminController::class, 'sliderUpdate'])->name('sliders.update');
    Route::delete('/overview/sliders/{slider}', [AdminController::class, 'sliderDestroy'])->name('sliders.destroy');

    // Appearance / theme management
    Route::put('/overview/appearance', [AdminController::class, 'updateAppearance'])->name('appearance.update');

    // Events management routes
    Route::get('/events', [AdminController::class, 'eventsIndex'])->name('events.index');
    Route::get('/events/create', [AdminController::class, 'eventsCreate'])->name('events.create');
    Route::post('/events', [AdminController::class, 'eventsStore'])->name('events.store');
    Route::get('/events/{event}/edit', [AdminController::class, 'eventsEdit'])->name('events.edit');
    Route::put('/events/{event}', [AdminController::class, 'eventsUpdate'])->name('events.update');
    Route::delete('/events/{event}', [AdminController::class, 'eventsDestroy'])->name('events.destroy');

    Route::get('/hrm', [AdminController::class, 'hrmDashboard'])->name('hrm.dashboard');
    
    // HRM-specific routes (using HRM layout)
    Route::get('/hrm/employees', [AdminController::class, 'hrmEmployees'])->name('hrm.employees');
    Route::get('/hrm/employees/create', [AdminController::class, 'hrmEmployeesCreate'])->name('hrm.employees.create');
    Route::post('/hrm/employees', [AdminController::class, 'hrmEmployeesStore'])->name('hrm.employees.store');
    Route::get('/hrm/employees/{id}/edit', [AdminController::class, 'hrmEmployeesEdit'])->name('hrm.employees.edit');
    Route::put('/hrm/employees/{id}', [AdminController::class, 'hrmEmployeesUpdate'])->name('hrm.employees.update');
    Route::delete('/hrm/employees/{id}', [AdminController::class, 'hrmEmployeesDestroy'])->name('hrm.employees.destroy');
    Route::get('/hrm/analytics', [AdminController::class, 'hrmAnalytics'])->name('hrm.analytics');
    Route::get('/hrm/reports', [AdminController::class, 'hrmReports'])->name('hrm.reports');
    Route::post('/hrm/reports/generate', [AdminController::class, 'hrmGenerateReport'])->name('hrm.reports.generate');
    Route::get('/hrm/settings', [AdminController::class, 'hrmSettings'])->name('hrm.settings');
    Route::put('/hrm/settings/appearance', [AdminController::class, 'hrmSettingsAppearanceUpdate'])->name('hrm.settings.appearance');
    Route::get('/hrm/inquiries', [AdminController::class, 'hrmInquiries'])->name('hrm.inquiries');
    Route::get('/hrm/inquiries/{inquiry}', [AdminController::class, 'hrmInquiryShow'])->name('hrm.inquiries.show');
    Route::put('/hrm/inquiries/{inquiry}', [AdminController::class, 'hrmInquiryUpdate'])->name('hrm.inquiries.update');
    
    // Office management routes
    Route::get('/offices', [AdminController::class, 'officesIndex'])->name('offices.index');
    Route::get('/offices/create', [AdminController::class, 'officesCreate'])->name('offices.create');
    Route::post('/offices', [AdminController::class, 'officesStore'])->name('offices.store');
    Route::get('/offices/{office}/edit', [AdminController::class, 'officesEdit'])->name('offices.edit');
    Route::put('/offices/{office}', [AdminController::class, 'officesUpdate'])->name('offices.update');
    Route::delete('/offices/{office}', [AdminController::class, 'officesDestroy'])->name('offices.destroy');

    // Services management routes
    Route::get('/services', [AdminController::class, 'servicesIndex'])->name('services.index');
    Route::get('/services/create', [AdminController::class, 'servicesCreate'])->name('services.create');
    Route::post('/services', [AdminController::class, 'servicesStore'])->name('services.store');
    Route::get('/services/{service}/edit', [AdminController::class, 'servicesEdit'])->name('services.edit');
    Route::put('/services/{service}', [AdminController::class, 'servicesUpdate'])->name('services.update');
    Route::delete('/services/{service}', [AdminController::class, 'servicesDestroy'])->name('services.destroy');

    // Programs management routes
    Route::get('/programs', [AdminController::class, 'programsIndex'])->name('programs.index');
    Route::get('/programs/create', [AdminController::class, 'programsCreate'])->name('programs.create');
    Route::post('/programs', [AdminController::class, 'programsStore'])->name('programs.store');
    Route::get('/programs/{program}/edit', [AdminController::class, 'programsEdit'])->name('programs.edit');
    Route::put('/programs/{program}', [AdminController::class, 'programsUpdate'])->name('programs.update');
    Route::delete('/programs/{program}', [AdminController::class, 'programsDestroy'])->name('programs.destroy');

    // News management routes
    Route::get('/news', [AdminController::class, 'newsIndex'])->name('news.index');
    Route::get('/news/create', [AdminController::class, 'newsCreate'])->name('news.create');
    Route::post('/news', [AdminController::class, 'newsStore'])->name('news.store');
    Route::get('/news/{news}/edit', [AdminController::class, 'newsEdit'])->name('news.edit');
    Route::put('/news/{news}', [AdminController::class, 'newsUpdate'])->name('news.update');
    Route::delete('/news/{news}', [AdminController::class, 'newsDestroy'])->name('news.destroy');

    // Inquiries management routes
    Route::get('/inquiries', [AdminController::class, 'inquiriesIndex'])->name('inquiries.index');
    Route::get('/inquiries/{inquiry}', [AdminController::class, 'inquiriesShow'])->name('inquiries.show');
    Route::put('/inquiries/{inquiry}', [AdminController::class, 'inquiriesUpdate'])->name('inquiries.update');
    Route::delete('/inquiries/{inquiry}', [AdminController::class, 'inquiriesDestroy'])->name('inquiries.destroy');

    // Users management routes
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'usersCreate'])->name('users.create');
    Route::post('/users', [AdminController::class, 'usersStore'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'usersEdit'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'usersUpdate'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'usersDestroy'])->name('users.destroy');

    // Settings & Reports
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings/profile', [AdminController::class, 'settingsProfileUpdate'])->name('settings.profile');
    Route::put('/settings/password', [AdminController::class, 'settingsPasswordUpdate'])->name('settings.password');
    Route::put('/settings/preferences', [AdminController::class, 'settingsPreferencesUpdate'])->name('settings.preferences');
    Route::put('/settings/appearance', [AdminController::class, 'settingsAppearanceUpdate'])->name('settings.appearance');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/reports/download', [AdminController::class, 'downloadReport'])->name('reports.download');
});
