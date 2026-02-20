@extends('admin.pso-layout')

@section('title','Analytics')
@section('crumb','Analytics')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <img src="/images/clsu-logo-green.png" alt="CLSU Seal" style="width:56px;height:56px;border-radius:14px;background:#fff;border:2px solid var(--clsu-green-500);object-fit:contain;">
    <div>
      <h1 class="h3 fw-bold mb-1">Property & Supply Analytics</h1>
      <div class="text-muted">Property and supply management insights</div>
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
          </svg>
        </div>
        <h3 class="fw-bold mb-1">{{ $stats['total_scholars'] ?? 0 }}</h3>
        <small class="text-muted">Total Properties</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-green-700);">{{ $stats['active_scholars'] ?? 0 }} Active</span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body text-center p-4">
        <div class="mb-2">
          <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-green-500);">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        <h3 class="fw-bold mb-1">{{ $stats['total_programs'] ?? 0 }}</h3>
        <small class="text-muted">Supply Items</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-green-500);">{{ $stats['active_programs'] ?? 0 }} Active</span>
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
        <h3 class="fw-bold mb-1">{{ $stats['total_applications'] ?? 0 }}</h3>
        <small class="text-muted">Requests</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-gold);">{{ $stats['pending_applications'] ?? 0 }} Pending</span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body text-center p-4">
        <div class="mb-2">
          <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-green-300);">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h3 class="fw-bold mb-1">₱{{ number_format($stats['total_disbursed'] ?? 0) }}</h3>
        <small class="text-muted">Total Issued Value</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-green-300);">This Year</span>
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
        <h5 class="fw-bold mb-4">Property & Supply Distribution</h5>
        <canvas id="programChart" height="100"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Request Status</h5>
        <canvas id="applicationChart"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- System Overview -->
<div class="card rounded-4 border">
  <div class="card-body p-4">
    <h5 class="fw-bold mb-4">Inventory Overview</h5>
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
              <h4 class="fw-bold mb-0">{{ $stats['approved_applications'] ?? 0 }}</h4>
              <small class="text-muted">Approved Requests</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="p-3 border rounded-3">
          <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(218,165,32,0.1);">
              <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-gold);">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
              </svg>
            </div>
            <div>
              <h4 class="fw-bold mb-0">{{ $stats['active_scholars'] ?? 0 }}</h4>
              <small class="text-muted">Active Properties</small>
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
              <h4 class="fw-bold mb-0">{{ $stats['active_programs'] ?? 0 }}</h4>
              <small class="text-muted">Active Supplies</small>
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

// Program Distribution Bar Chart
const programCtx = document.getElementById('programChart').getContext('2d');
new Chart(programCtx, {
  type: 'bar',
  data: {
    labels: ['Office Supplies', 'Equipment', 'Furniture', 'IT Assets'],
    datasets: [{
      label: 'Items',
      data: [{{ $stats['academic_scholars'] ?? 0 }}, {{ $stats['athletic_scholars'] ?? 0 }}, {{ $stats['leadership_scholars'] ?? 0 }}, {{ $stats['need_based_scholars'] ?? 0 }}],
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

// Application Status Doughnut Chart
const applicationCtx = document.getElementById('applicationChart').getContext('2d');
new Chart(applicationCtx, {
  type: 'doughnut',
  data: {
    labels: ['Pending', 'Approved', 'Rejected'],
    datasets: [{
      data: [{{ $stats['pending_applications'] ?? 0 }}, {{ $stats['approved_applications'] ?? 0 }}, {{ $stats['rejected_applications'] ?? 0 }}],
      backgroundColor: [clsuGold, clsuGreen, clsuGreenDark],
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
