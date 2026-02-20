@extends('admin.pso-layout')

@section('title', 'PSO Dashboard')
@section('crumb', 'Property & Supply')

@section('content')
<div class="mb-4">
  <h1 class="h3 fw-bold mb-1">Property and Supply Office</h1>
  <p class="text-muted">Property inventory and supply management statistics</p>
</div>

<!-- Quick Stats -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card rounded-4 border-0 shadow-sm h-100" style="background: linear-gradient(135deg, var(--clsu-green) 0%, var(--clsu-cobra) 100%);">
      <div class="card-body p-4 text-white">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div>
            <p class="mb-1 opacity-75 small">Total Items</p>
            <h2 class="mb-0 fw-bold">{{ $stats['total_strategic_plans'] }}</h2>
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
            <p class="mb-1 text-muted small">Active Supplies</p>
            <h2 class="mb-0 fw-bold" style="color: var(--clsu-green);">{{ $stats['active_projects'] }}</h2>
          </div>
          <div class="rounded-3 p-2" style="background: rgba(0, 150, 57, 0.1);">
            <svg width="24" height="24" fill="var(--clsu-green)" viewBox="0 0 24 24">
               <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
            </svg>
          </div>
        </div>
        <div class="progress" style="height: 4px;">
          <!-- Using arbitrary calculation for demo as we don't have total projects, assuming active/10 is scale or 100% -->
          <div class="progress-bar" style="width: 75%; background: var(--clsu-green);"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div>
            <p class="mb-1 text-muted small">Pending Requests</p>
            <h2 class="mb-0 fw-bold" style="color: var(--clsu-gold);">{{ $stats['pending_reviews'] }}</h2>
          </div>
          <div class="rounded-3 p-2" style="background: rgba(224, 167, 13, 0.1);">
            <svg width="24" height="24" fill="var(--clsu-gold)" viewBox="0 0 24 24">
               <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
            </svg>
          </div>
        </div>
        <div class="progress" style="height: 4px;">
           <div class="progress-bar" style="width: 50%; background: var(--clsu-gold);"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div>
            <p class="mb-1 text-muted small">Issued Items</p>
            <h2 class="mb-0 fw-bold text-primary">{{ $stats['completed_projects'] }}</h2>
          </div>
          <div class="rounded-3 p-2 bg-primary bg-opacity-10">
            <svg width="24" height="24" fill="currentColor" class="text-primary" viewBox="0 0 24 24">
              <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Performance & Overview (Reusing Structure) -->
<div class="row g-3 mb-4">
  <div class="col-lg-6">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Inventory Metrics</h5>
        <div class="row g-3">
          <div class="col-6">
            <div class="p-3 border rounded-3 text-center">
              <div class="fw-bold text-muted small mb-1">Stock Accuracy</div>
              <h3 class="mb-0 text-secondary">85%</h3>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 border rounded-3 text-center">
              <div class="fw-bold text-muted small mb-1">On-Time Delivery</div>
              <h3 class="mb-0" style="color: var(--clsu-cobra);">92%</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Supply Status</h5>
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-2">
            <span>Inventory Utilization</span>
            <span class="fw-bold">78%</span>
          </div>
          <div class="progress" style="height: 8px;">
            <div class="progress-bar" style="width: 78%; background: var(--clsu-green);"></div>
          </div>
        </div>
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-2">
            <span>Satisfaction</span>
            <span class="fw-bold">4.5/5</span>
          </div>
          <div class="progress" style="height: 8px;">
            <div class="progress-bar" style="width: 90%; background: var(--clsu-gold);"></div>
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
    <a href="{{ route('pso.projects') }}" class="btn btn-sm btn-outline-secondary rounded-3">View All</a>
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
              <div class="fw-bold">Annual Property Inventory Report</div>
              <small class="text-muted">Yearly property accountability check</small>
            </td>
            <td class="py-3"><span class="badge bg-primary">Inventory</span></td>
            <td class="py-3"><span class="badge bg-warning">In Progress</span></td>
            <td class="py-3">{{ now()->subDays(2)->format('M d, Y') }}</td>
          </tr>
          <tr>
            <td class="px-4 py-3">
              <div class="fw-bold">Office Supplies Restocking</div>
              <small class="text-muted">Quarterly supply replenishment</small>
            </td>
            <td class="py-3"><span class="badge bg-success">Supply</span></td>
            <td class="py-3"><span class="badge bg-success">Active</span></td>
            <td class="py-3">{{ now()->subDays(5)->format('M d, Y') }}</td>
          </tr>
          <tr>
            <td class="px-4 py-3">
              <div class="fw-bold">Equipment Issuance Q1 2024</div>
              <small class="text-muted">Quarterly property issuance record</small>
            </td>
            <td class="py-3"><span class="badge bg-info">Issuance</span></td>
            <td class="py-3"><span class="badge bg-secondary">Completed</span></td>
            <td class="py-3">{{ now()->subDays(10)->format('M d, Y') }}</td>
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
        <a href="{{ route('pso.strategic-plans') }}" class="btn btn-outline-secondary w-100 rounded-3 py-3">
          <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-2">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
          </svg>
          <div class="small fw-bold">New Property</div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="{{ route('pso.projects') }}" class="btn btn-outline-secondary w-100 rounded-3 py-3">
          <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
          </svg>
          <div class="small fw-bold">Issue Supply</div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="{{ route('pso.reports') }}" class="btn btn-outline-secondary w-100 rounded-3 py-3">
          <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          <div class="small fw-bold">Generate Report</div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="{{ route('pso.analytics') }}" class="btn btn-outline-secondary w-100 rounded-3 py-3">
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
