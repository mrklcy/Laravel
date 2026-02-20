@extends('admin.rmo-layout')

@section('title', 'RMO Dashboard')
@section('crumb', 'RMO')

@section('content')
<div class="mb-4">
  <h1 class="h3 fw-bold mb-1">Records Management Office</h1>
  <p class="text-muted">Document archives and request management</p>
</div>

<!-- Quick Stats -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card rounded-4 border-0 shadow-sm h-100" style="background: linear-gradient(135deg, var(--clsu-green) 0%, var(--clsu-cobra) 100%);">
      <div class="card-body p-4 text-white">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div>
            <p class="mb-1 opacity-75 small">Total Documents</p>
            <h2 class="mb-0 fw-bold">{{ $stats['total_documents'] }}</h2>
          </div>
          <div class="rounded-3 p-2" style="background: rgba(255,255,255,0.2);">
            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
               <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
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
            <p class="mb-1 text-muted small">Active Requests</p>
            <h2 class="mb-0 fw-bold" style="color: var(--clsu-green);">{{ $stats['active_requests'] }}</h2>
          </div>
          <div class="rounded-3 p-2" style="background: rgba(0, 150, 57, 0.1);">
            <svg width="24" height="24" fill="var(--clsu-green)" viewBox="0 0 24 24">
               <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
            </svg>
          </div>
        </div>
        <div class="progress" style="height: 4px;">
          <div class="progress-bar" style="width: 65%; background: var(--clsu-green);"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div>
            <p class="mb-1 text-muted small">Pending Approvals</p>
            <h2 class="mb-0 fw-bold" style="color: var(--clsu-gold);">{{ $stats['pending_approvals'] }}</h2>
          </div>
          <div class="rounded-3 p-2" style="background: rgba(224, 167, 13, 0.1);">
            <svg width="24" height="24" fill="var(--clsu-gold)" viewBox="0 0 24 24">
               <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
            </svg>
          </div>
        </div>
        <div class="progress" style="height: 4px;">
           <div class="progress-bar" style="width: 45%; background: var(--clsu-gold);"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div>
            <p class="mb-1 text-muted small">Archived</p>
            <h2 class="mb-0 fw-bold text-primary">{{ $stats['archived_records'] }}</h2>
          </div>
          <div class="rounded-3 p-2 bg-primary bg-opacity-10">
            <svg width="24" height="24" fill="currentColor" class="text-primary" viewBox="0 0 24 24">
               <path d="M20.54 5.23l-1.39-1.68C18.88 3.21 18.47 3 18 3H6c-.47 0-.88.21-1.16.55L3.46 5.23C3.17 5.57 3 6.02 3 6.5V19c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6.5c0-.48-.17-.93-.46-1.27zM12 17.5L6.5 12H10v-2h4v2h3.5L12 17.5zM5.12 5l.81-1h12l.94 1H5.12z"/>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Storage Note & Overview (Reusing Structure) -->
<div class="row g-3 mb-4">
  <div class="col-lg-6">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Storage Overview</h5>
        <div class="row g-3">
          <div class="col-6">
            <div class="p-3 border rounded-3 text-center">
              <div class="fw-bold text-muted small mb-1">Physical</div>
              <h3 class="mb-0 text-secondary">78%</h3>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 border rounded-3 text-center">
              <div class="fw-bold text-muted small mb-1">Digital</div>
              <h3 class="mb-0" style="color: var(--clsu-cobra);">62%</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Archive Status</h5>
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-2">
            <span>Archive Capacity</span>
            <span class="fw-bold">85%</span>
          </div>
          <div class="progress" style="height: 8px;">
            <div class="progress-bar" style="width: 85%; background: var(--clsu-green);"></div>
          </div>
        </div>
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-2">
            <span>Retrieval efficiency</span>
            <span class="fw-bold">High</span>
          </div>
          <div class="progress" style="height: 8px;">
            <div class="progress-bar" style="width: 95%; background: var(--clsu-gold);"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Recent Activities -->
<div class="card rounded-4 border mb-4">
  <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
    <h5 class="fw-bold mb-0">Recent Activities</h5>
    <a href="{{ route('rmo.documents') }}" class="btn btn-sm btn-outline-secondary rounded-3">View All</a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="bg-light">
          <tr>
            <th class="px-4 py-3">Activity</th>
            <th class="py-3">Type</th>
            <th class="py-3">Status</th>
            <th class="py-3">Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="px-4 py-3">
              <div class="fw-bold">Academic Records Request - Student #2024-1234</div>
              <small class="text-muted">Transcript of records request</small>
            </td>
            <td class="py-3"><span class="badge bg-primary">Request</span></td>
            <td class="py-3"><span class="badge bg-warning">Pending</span></td>
            <td class="py-3">{{ now()->subDays(1)->format('M d, Y') }}</td>
          </tr>
          <tr>
            <td class="px-4 py-3">
              <div class="fw-bold">Faculty Service Records Update</div>
              <small class="text-muted">Updated employment records</small>
            </td>
            <td class="py-3"><span class="badge bg-success">Document</span></td>
            <td class="py-3"><span class="badge bg-success">Completed</span></td>
            <td class="py-3">{{ now()->subDays(3)->format('M d, Y') }}</td>
          </tr>
          <tr>
            <td class="px-4 py-3">
              <div class="fw-bold">Archive Migration - 2020 Records</div>
              <small class="text-muted">Moving old records to archive</small>
            </td>
            <td class="py-3"><span class="badge bg-info">Archive</span></td>
            <td class="py-3"><span class="badge bg-info">In Progress</span></td>
            <td class="py-3">{{ now()->subDays(5)->format('M d, Y') }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Quick Actions -->
<div class="card rounded-4 border">
  <div class="card-body p-4">
    <h5 class="fw-bold mb-3">Quick Actions</h5>
    <div class="row g-3">
      <div class="col-md-3">
        <a href="{{ route('rmo.documents') }}" class="btn btn-outline-secondary w-100 rounded-3 py-3">
          <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
          </svg>
          <div class="small fw-bold">New Document</div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="{{ route('rmo.requests') }}" class="btn btn-outline-secondary w-100 rounded-3 py-3">
          <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
          </svg>
          <div class="small fw-bold">New Request</div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="{{ route('rmo.reports') }}" class="btn btn-outline-secondary w-100 rounded-3 py-3">
          <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          <div class="small fw-bold">Generate Report</div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="{{ route('rmo.analytics') }}" class="btn btn-outline-secondary w-100 rounded-3 py-3">
          <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-2">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
          <div class="small fw-bold">Analytics</div>
        </a>
      </div>
    </div>
  </div>
</div>

@endsection
