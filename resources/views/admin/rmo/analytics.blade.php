@extends('admin.rmo-layout')

@section('title','Analytics')
@section('crumb','Analytics')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <img src="/images/clsu-logo-green.png" alt="CLSU Seal" style="width:56px;height:56px;border-radius:14px;background:#fff;border:2px solid var(--clsu-green-500);object-fit:contain;">
    <div>
      <h1 class="h3 fw-bold mb-1">RMO Analytics</h1>
      <div class="text-muted">Records Management Office insights and trends</div>
    </div>
  </div>
</div>

<!-- Key Metrics -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body text-center p-4">
        <div class="mb-2">
          <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-green-700);">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        <h3 class="fw-bold mb-1">{{ $stats['total_documents'] ?? 0 }}</h3>
        <small class="text-muted">Total Documents</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-green-700);">{{ $stats['active_documents'] ?? 0 }} Active</span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body text-center p-4">
        <div class="mb-2">
          <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-green-500);">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
          </svg>
        </div>
        <h3 class="fw-bold mb-1">{{ $stats['archived_records'] ?? 0 }}</h3>
        <small class="text-muted">Archived Records</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-green-500);">Stored Securely</span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body text-center p-4">
        <div class="mb-2">
          <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-gold);">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
          </svg>
        </div>
        <h3 class="fw-bold mb-1">{{ $stats['active_requests'] ?? 0 }}</h3>
        <small class="text-muted">Active Requests</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-gold);">{{ $stats['pending_requests'] ?? 0 }} Pending</span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body text-center p-4">
        <div class="mb-2">
          <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-green-300);">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h3 class="fw-bold mb-1">{{ $stats['pending_approvals'] ?? 0 }}</h3>
        <small class="text-muted">Pending Approval</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-green-300);">Awaiting Review</span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Content Distribution -->
<div class="row g-3 mb-4">
  <div class="col-lg-8">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Document Type Distribution</h5>
        <canvas id="docTypeChart" height="100"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Request Status</h5>
        <canvas id="requestChart"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- System Overview -->
<div class="card rounded-4 border">
  <div class="card-body p-4">
    <h5 class="fw-bold mb-4">Records Overview</h5>
    <div class="row g-3">
      <div class="col-md-4">
        <div class="p-3 border rounded-3">
          <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(0,150,57,0.1);">
              <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-green-700);">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
            </div>
            <div>
              <h4 class="fw-bold mb-0">{{ $stats['active_documents'] ?? 0 }}</h4>
              <small class="text-muted">Active Documents</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="p-3 border rounded-3">
          <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(218,165,32,0.1);">
              <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-gold);">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
              </svg>
            </div>
            <div>
              <h4 class="fw-bold mb-0">{{ $stats['archived_records'] ?? 0 }}</h4>
              <small class="text-muted">Archived Records</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="p-3 border rounded-3">
          <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(0,150,57,0.1);">
              <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-green-500);">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
            </div>
            <div>
              <h4 class="fw-bold mb-0">{{ $stats['completed_requests'] ?? 0 }}</h4>
              <small class="text-muted">Completed Requests</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
// CLSU Brand Colors
const clsuGreen = '#009639';
const clsuGreenDark = '#1E6031';
const clsuGold = '#FFD700';
const clsuGoldDark = '#E0A70D';

// Document Type Bar Chart
const docTypeCtx = document.getElementById('docTypeChart').getContext('2d');
new Chart(docTypeCtx, {
  type: 'bar',
  data: {
    labels: ['Academic', 'Administrative', 'Legal', 'Financial'],
    datasets: [{
      label: 'Documents',
      data: [{{ $stats['academic_docs'] ?? 0 }}, {{ $stats['admin_docs'] ?? 0 }}, {{ $stats['legal_docs'] ?? 0 }}, {{ $stats['financial_docs'] ?? 0 }}],
      backgroundColor: [clsuGreen, clsuGold, clsuGreenDark, clsuGoldDark],
      borderRadius: 8,
      borderSkipped: false,
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    plugins: {
      legend: { display: false },
      tooltip: {
        backgroundColor: 'rgba(0, 0, 0, 0.8)',
        padding: 12,
        borderRadius: 8,
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: { precision: 0 },
        grid: { color: 'rgba(0, 0, 0, 0.05)' }
      },
      x: { grid: { display: false } }
    }
  }
});

// Request Status Doughnut Chart
const requestCtx = document.getElementById('requestChart').getContext('2d');
new Chart(requestCtx, {
  type: 'doughnut',
  data: {
    labels: ['Pending', 'In Progress', 'Completed'],
    datasets: [{
      data: [{{ $stats['pending_requests'] ?? 0 }}, {{ $stats['in_progress_requests'] ?? 0 }}, {{ $stats['completed_requests'] ?? 0 }}],
      backgroundColor: [clsuGold, clsuGreenDark, clsuGreen],
      borderWidth: 0,
      hoverOffset: 10
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    cutout: '70%',
    plugins: {
      legend: {
        position: 'bottom',
        labels: {
          padding: 20,
          font: { size: 13, weight: '500' },
          usePointStyle: true,
          pointStyle: 'circle'
        }
      }
    }
  }
});
</script>
@endsection
