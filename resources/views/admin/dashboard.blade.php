@extends('admin.admin-layout')

@section('title','Dashboard')
@section('crumb','Dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <img src="/images/clsu-logo-green.png" alt="CLSU Seal" style="width:56px;height:56px;border-radius:14px;background:#fff;border:2px solid var(--clsu-green-500);object-fit:contain;">
    <div>
      <h1 class="h3 fw-bold mb-1">CLSU Admin Dashboard</h1>
      <div class="text-muted">Manage records, view reports, and monitor system activity.</div>
    </div>
  </div>
  <div class="d-flex gap-2">
    <button class="btn btn-outline rounded-4 fw-bold">Export</button>
  </div>
</div>

@if(Auth::guard('admin')->user()->role === 'super_admin')
<div class="row g-3 mb-4">
    <div class="col-12">
        <h5 class="fw-bold mb-3">Administrative Modules</h5>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.hrm.dashboard') }}" class="text-decoration-none">
            <div class="card card-accent rounded-4 border h-100 transition-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-3 p-3 bg-primary bg-opacity-10 text-primary">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h5 class="fw-bold mb-0 text-dark">HRMO</h5>
                    </div>
                    <p class="text-muted small mb-0">Human Resource Management Office</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('pmo.dashboard') }}" class="text-decoration-none">
            <div class="card card-accent rounded-4 border h-100 transition-hover" style="border-top-color: var(--clsu-gold);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-3 p-3 text-warning" style="background: rgba(224, 167, 13, 0.1);">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h5 class="fw-bold mb-0 text-dark">PMO</h5>
                    </div>
                    <p class="text-muted small mb-0">Procurement Management Office</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('pso.dashboard') }}" class="text-decoration-none">
            <div class="card card-accent rounded-4 border h-100 transition-hover" style="border-top-color: var(--clsu-cobra);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-3 p-3 text-success" style="background: rgba(30, 96, 49, 0.1);">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <h5 class="fw-bold mb-0 text-dark">PSO</h5>
                    </div>
                    <p class="text-muted small mb-0">Strategic Planning & Management</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('rmo.dashboard') }}" class="text-decoration-none">
            <div class="card card-accent rounded-4 border h-100 transition-hover" style="border-top-color: #6c757d;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-3 p-3 bg-secondary bg-opacity-10 text-secondary">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v6a2 2 0 01-2 2H5z"></path>
                            </svg>
                        </div>
                        <h5 class="fw-bold mb-0 text-dark">RMO</h5>
                    </div>
                    <p class="text-muted small mb-0">Records Management Office</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endif

<div class="row g-3 mb-4">
  @php
    $cards = [
      ['Offices', $stats['total_offices'], 'Active offices'],
      ['Services', $stats['total_services'], 'Available services'],
      ['Programs', $stats['total_programs'], 'Employee programs'],
      ['News', $stats['total_news'], 'Announcements'],
      ['Inquiries', $stats['pending_inquiries'], 'Pending'],
      ['Users', $stats['total_employees'], 'Admin users'],
    ];
  @endphp

  @foreach($cards as $c)
  <div class="col-12 col-md-6 col-xl-3">
    <div class="card card-accent rounded-4 border">
      <div class="card-body">
        <div class="text-muted small">{{ $c[0] }}</div>
        <div class="display-6 fw-black" style="font-weight:900;color:var(--clsu-green-700);">
          {{ $c[1] }}
        </div>
        <div class="text-muted small">{{ $c[2] }}</div>
      </div>
    </div>
  </div>
  @endforeach
</div>

<!-- Analytics Section -->
<div class="row g-3 mb-4">
  <div class="col-lg-8">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-3">Content Overview</h5>
        <div class="row g-3">
          <div class="col-md-6">
            <div class="p-3 bg-light rounded-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small">Services</span>
                <span class="badge bg-success">{{ $stats['total_services'] }}</span>
              </div>
              <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-success" style="width: {{ min(($stats['total_services'] / 20) * 100, 100) }}%"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="p-3 bg-light rounded-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small">Programs</span>
                <span class="badge bg-primary">{{ $stats['total_programs'] }}</span>
              </div>
              <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-primary" style="width: {{ min(($stats['total_programs'] / 20) * 100, 100) }}%"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="p-3 bg-light rounded-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small">News Articles</span>
                <span class="badge bg-info">{{ $stats['total_news'] }}</span>
              </div>
              <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-info" style="width: {{ min(($stats['total_news'] / 20) * 100, 100) }}%"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="p-3 bg-light rounded-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small">Offices</span>
                <span class="badge" style="background: var(--clsu-gold);">{{ $stats['total_offices'] }}</span>
              </div>
              <div class="progress" style="height: 8px;">
                <div class="progress-bar" style="width: {{ min(($stats['total_offices'] / 10) * 100, 100) }}%; background: var(--clsu-gold);"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-3">Inquiry Status</h5>
        <div class="mb-3">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="small">Pending</span>
            <span class="fw-bold text-warning">{{ $stats['pending_inquiries'] }}</span>
          </div>
          <div class="progress" style="height: 6px;">
            <div class="progress-bar bg-warning" style="width: {{ $stats['total_inquiries'] > 0 ? ($stats['pending_inquiries'] / $stats['total_inquiries']) * 100 : 0 }}%"></div>
          </div>
        </div>
        <div class="mb-3">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="small">Total</span>
            <span class="fw-bold">{{ $stats['total_inquiries'] }}</span>
          </div>
          <div class="progress" style="height: 6px;">
            <div class="progress-bar bg-primary" style="width: 100%"></div>
          </div>
        </div>
        <div class="text-center mt-4">
          <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-outline-primary rounded-3">View All Inquiries</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Employee Status -->
<div class="row g-3 mb-4">
  <div class="col-lg-12">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Employee Status Overview</h5>
        <div class="row g-3">
          <div class="col-md-3">
            <div class="p-3 border rounded-3">
              <div class="d-flex align-items-center gap-2 mb-2">
                <div class="rounded-circle" style="width: 12px; height: 12px; background: var(--clsu-green);"></div>
                <span class="fw-bold">Active</span>
              </div>
              <h3 class="mb-1" style="color: var(--clsu-green);">{{ $stats['active_employees'] }}</h3>
              <div class="progress" style="height: 6px;">
                <div class="progress-bar" style="width: {{ $stats['total_employees'] > 0 ? ($stats['active_employees'] / $stats['total_employees']) * 100 : 0 }}%; background: var(--clsu-green);"></div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="p-3 border rounded-3">
              <div class="d-flex align-items-center gap-2 mb-2">
                <div class="rounded-circle" style="width: 12px; height: 12px; background: var(--clsu-gold);"></div>
                <span class="fw-bold">On Leave</span>
              </div>
              <h3 class="mb-1" style="color: var(--clsu-gold);">{{ $stats['on_leave_employees'] }}</h3>
              <div class="progress" style="height: 6px;">
                <div class="progress-bar" style="width: {{ $stats['total_employees'] > 0 ? ($stats['on_leave_employees'] / $stats['total_employees']) * 100 : 0 }}%; background: var(--clsu-gold);"></div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="p-3 border rounded-3">
              <div class="d-flex align-items-center gap-2 mb-2">
                <div class="rounded-circle" style="width: 12px; height: 12px; background: #6c757d;"></div>
                <span class="fw-bold">Inactive</span>
              </div>
              <h3 class="mb-1 text-secondary">{{ $stats['inactive_employees'] }}</h3>
              <div class="progress" style="height: 6px;">
                <div class="progress-bar bg-secondary" style="width: {{ $stats['total_employees'] > 0 ? ($stats['inactive_employees'] / $stats['total_employees']) * 100 : 0 }}%;"></div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="p-3 border rounded-3">
              <div class="d-flex align-items-center gap-2 mb-2">
                <div class="rounded-circle" style="width: 12px; height: 12px; background: var(--clsu-cobra);"></div>
                <span class="fw-bold">Retired</span>
              </div>
              <h3 class="mb-1" style="color: var(--clsu-cobra);">{{ $stats['retired_employees'] }}</h3>
              <div class="progress" style="height: 6px;">
                <div class="progress-bar" style="width: {{ $stats['total_employees'] > 0 ? ($stats['retired_employees'] / $stats['total_employees']) * 100 : 0 }}%; background: var(--clsu-cobra);"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Quick Actions -->
<div class="card rounded-4 border mb-4">
  <div class="card-body p-4">
    <h5 class="fw-bold mb-3">Quick Actions</h5>
    <div class="row g-3">
      <div class="col-md-3">
        <a href="{{ route('admin.services.create') }}" class="btn btn-outline-secondary w-100 rounded-3 py-3">
          <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          <div class="small fw-bold">Add Service</div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="{{ route('admin.programs.create') }}" class="btn btn-outline-secondary w-100 rounded-3 py-3">
          <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          <div class="small fw-bold">Add Program</div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="{{ route('admin.news.create') }}" class="btn btn-outline-secondary w-100 rounded-3 py-3">
          <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          <div class="small fw-bold">Add News</div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="{{ route('admin.reports') }}" class="btn btn-outline-secondary w-100 rounded-3 py-3">
          <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
          </svg>
          <div class="small fw-bold">View Reports</div>
        </a>
      </div>
    </div>
  </div>
</div>

<div class="card rounded-4 border">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <h2 class="h5 fw-bold mb-0">Recent Activity</h2>
    <button class="btn btn-outline rounded-4 fw-bold">View all</button>
  </div>

  <div class="card-body">
    <div class="row text-muted small border-bottom pb-2 mb-2">
      <div class="col-3">DATE</div>
      <div class="col-7">ACTION</div>
      <div class="col-2 text-end">STATUS</div>
    </div>

    <div class="row py-2 border-bottom">
      <div class="col-3">Feb 04, 2026</div>
      <div class="col-7">Admin logged in</div>
      <div class="col-2 text-end">
        <span class="badge rounded-pill" style="background: var(--clsu-green); color: white;">Success</span>
      </div>
    </div>

    <div class="row py-2 border-bottom">
      <div class="col-3">Feb 03, 2026</div>
      <div class="col-7">Generated monthly report</div>
      <div class="col-2 text-end">
        <span class="badge rounded-pill" style="background: var(--clsu-gold); color: white;">Completed</span>
      </div>
    </div>

    <div class="row py-2">
      <div class="col-3">Feb 02, 2026</div>
      <div class="col-7">Updated settings</div>
      <div class="col-2 text-end">
        <span class="badge rounded-pill" style="background: var(--clsu-green); color: white;">Saved</span>
      </div>
    </div>
  </div>
</div>

@endsection
