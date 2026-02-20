@extends('admin.pmo-layout')

@section('title', 'PMO Dashboard')
@section('crumb', 'PMO')

@section('content')
<div class="mb-4">
  <h1 class="h3 fw-bold mb-1">Procurement Management Office</h1>
  <p class="text-muted">Procurement operations and purchasing management statistics</p>
</div>

<!-- Quick Stats -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card rounded-4 border-0 shadow-sm h-100" style="background: linear-gradient(135deg, var(--clsu-green) 0%, var(--clsu-cobra) 100%);">
      <div class="card-body p-4 text-white">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div>
            <p class="mb-1 opacity-75 small">Total Users</p>
            <h2 class="mb-0 fw-bold">{{ $stats['total_employees'] }}</h2>
          </div>
          <div class="rounded-3 p-2" style="background: rgba(255,255,255,0.2);">
            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div>
            <p class="mb-1 text-muted small">Active</p>
            <h2 class="mb-0 fw-bold" style="color: var(--clsu-green);">{{ $stats['active_employees'] }}</h2>
          </div>
          <div class="rounded-3 p-2" style="background: rgba(0, 150, 57, 0.1);">
            <svg width="24" height="24" fill="var(--clsu-green)" viewBox="0 0 24 24">
              <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
        <div class="progress" style="height: 4px;">
          <div class="progress-bar" style="width: {{ $stats['total_employees'] > 0 ? ($stats['active_employees'] / $stats['total_employees']) * 100 : 0 }}%; background: var(--clsu-green);"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div>
            <p class="mb-1 text-muted small">On Leave</p>
            <h2 class="mb-0 fw-bold" style="color: var(--clsu-gold);">{{ $stats['on_leave_employees'] }}</h2>
          </div>
          <div class="rounded-3 p-2" style="background: rgba(224, 167, 13, 0.1);">
            <svg width="24" height="24" fill="var(--clsu-gold)" viewBox="0 0 24 24">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
          </div>
        </div>
        <div class="progress" style="height: 4px;">
          <div class="progress-bar" style="width: {{ $stats['total_employees'] > 0 ? ($stats['on_leave_employees'] / $stats['total_employees']) * 100 : 0 }}%; background: var(--clsu-gold);"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div>
            <p class="mb-1 text-muted small">New Hires (This Month)</p>
            <h2 class="mb-0 fw-bold text-primary">{{ $stats['new_hires_this_month'] }}</h2>
          </div>
          <div class="rounded-3 p-2 bg-primary bg-opacity-10">
            <svg width="24" height="24" fill="currentColor" class="text-primary" viewBox="0 0 24 24">
              <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Employment Status & Type -->
<div class="row g-3 mb-4">
  <div class="col-lg-6">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Employment Status</h5>
        <div class="row g-3">
          <div class="col-6">
            <div class="p-3 border rounded-3 text-center">
              <div class="fw-bold text-muted small mb-1">Inactive</div>
              <h3 class="mb-0 text-secondary">{{ $stats['inactive_employees'] }}</h3>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 border rounded-3 text-center">
              <div class="fw-bold text-muted small mb-1">Retired</div>
              <h3 class="mb-0" style="color: var(--clsu-cobra);">{{ $stats['retired_employees'] }}</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Employment Type</h5>
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-2">
            <span>Regular</span>
            <span class="fw-bold">{{ $stats['regular_employees'] }}</span>
          </div>
          <div class="progress" style="height: 8px;">
            <div class="progress-bar" style="width: {{ $stats['total_employees'] > 0 ? ($stats['regular_employees'] / $stats['total_employees']) * 100 : 0 }}%; background: var(--clsu-green);"></div>
          </div>
        </div>
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-2">
            <span>Contractual</span>
            <span class="fw-bold">{{ $stats['contractual_employees'] }}</span>
          </div>
          <div class="progress" style="height: 8px;">
            <div class="progress-bar" style="width: {{ $stats['total_employees'] > 0 ? ($stats['contractual_employees'] / $stats['total_employees']) * 100 : 0 }}%; background: var(--clsu-gold);"></div>
          </div>
        </div>
        <div>
          <div class="d-flex justify-content-between mb-2">
            <span>Casual</span>
            <span class="fw-bold">{{ $stats['casual_employees'] }}</span>
          </div>
          <div class="progress" style="height: 8px;">
            <div class="progress-bar bg-secondary" style="width: {{ $stats['total_employees'] > 0 ? ($stats['casual_employees'] / $stats['total_employees']) * 100 : 0 }}%;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Recent Users & Department Overview -->
<div class="row g-3 mb-4">
  <div class="col-lg-8">
    <div class="card rounded-4 border">
      <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
        <h5 class="fw-bold mb-0">Recent Users</h5>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary rounded-3">View All</a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="bg-light">
              <tr>
                <th class="px-4 py-3">User</th>
                <th class="py-3">Position</th>
                <th class="py-3">Department</th>
                <th class="py-3">Status</th>
                <th class="py-3">Date Hired</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recent_employees as $employee)
              <tr>
                <td class="px-4 py-3">
                  <div class="fw-bold">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                  <small class="text-muted">{{ $employee->employee_id }}</small>
                </td>
                <td class="py-3">{{ $employee->position }}</td>
                <td class="py-3">{{ $employee->department ?? 'N/A' }}</td>
                <td class="py-3">
                  @if($employee->status === 'active')
                    <span class="badge rounded-pill" style="background: var(--clsu-green); color: white;">Active</span>
                  @elseif($employee->status === 'on_leave')
                    <span class="badge rounded-pill" style="background: var(--clsu-gold); color: white;">On Leave</span>
                  @elseif($employee->status === 'inactive')
                    <span class="badge rounded-pill bg-secondary">Inactive</span>
                  @else
                    <span class="badge rounded-pill" style="background: var(--clsu-cobra); color: white;">Retired</span>
                  @endif
                </td>
                <td class="py-3">{{ $employee->date_hired ? $employee->date_hired->format('M d, Y') : 'N/A' }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-4 text-muted">No users found</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card rounded-4 border h-100">
      <div class="card-header bg-white border-bottom py-3">
        <h5 class="fw-bold mb-0">Department Overview</h5>
      </div>
      <div class="card-body p-4">
        @forelse($departments as $dept)
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-2">
            <span class="small">{{ $dept->department }}</span>
            <span class="fw-bold small">{{ $dept->count }}</span>
          </div>
          <div class="progress" style="height: 6px;">
            <div class="progress-bar" style="width: {{ $stats['total_employees'] > 0 ? ($dept->count / $stats['total_employees']) * 100 : 0 }}%; background: var(--clsu-green);"></div>
          </div>
        </div>
        @empty
        <p class="text-muted text-center mb-0">No department data available</p>
        @endforelse
      </div>
    </div>
  </div>
</div>

<!-- Quick Actions -->
<div class="card rounded-4 border">
  <div class="card-body p-4">
    <h5 class="fw-bold mb-3">Quick Actions</h5>
    <div class="row g-3">
      <div class="col-md-3">
        <a href="#" class="btn btn-outline-secondary w-100 rounded-3 py-3">
          <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          <div class="small fw-bold">New Purchase Request</div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="#" class="btn btn-outline-secondary w-100 rounded-3 py-3">
          <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
          </svg>
          <div class="small fw-bold">Track Procurement</div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="#" class="btn btn-outline-secondary w-100 rounded-3 py-3">
          <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
          <div class="small fw-bold">View Orders</div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="#" class="btn btn-outline-secondary w-100 rounded-3 py-3">
          <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          <div class="small fw-bold">Generate Report</div>
        </a>
      </div>
    </div>
  </div>
</div>

@endsection
