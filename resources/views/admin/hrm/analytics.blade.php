@extends('admin.hrm-layout')

@section('title','Analytics')
@section('crumb','Analytics')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <img src="/images/clsu-logo-green.png" alt="CLSU Seal" style="width:56px;height:56px;border-radius:14px;background:#fff;border:2px solid var(--clsu-green-500);object-fit:contain;">
    <div>
      <h1 class="h3 fw-bold mb-1">HRM Analytics</h1>
      <div class="text-muted">Human Resources Management insights and trends</div>
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
        </div>
        <h3 class="fw-bold mb-1">{{ $stats['total_employees'] ?? 0 }}</h3>
        <small class="text-muted">Total Users</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-green-700);">{{ $stats['active_employees'] ?? 0 }} Active</span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body text-center p-4">
        <div class="mb-2">
          <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-green-500);">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
          </svg>
        </div>
        <h3 class="fw-bold mb-1">{{ $stats['on_leave_employees'] ?? 0 }}</h3>
        <small class="text-muted">On Leave</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-green-500);">This Month</span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body text-center p-4">
        <div class="mb-2">
          <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-gold);">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        <h3 class="fw-bold mb-1">{{ $stats['inactive_employees'] ?? 0 }}</h3>
        <small class="text-muted">Inactive</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-gold);">Status</span>
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
        <h3 class="fw-bold mb-1">{{ $stats['retired_employees'] ?? 0 }}</h3>
        <small class="text-muted">Retired</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-green-300);">Total</span>
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
        <h5 class="fw-bold mb-4">Employee Status Distribution</h5>
        <canvas id="statusChart" height="100"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Employment Type</h5>
        <canvas id="employmentChart"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- System Overview -->
<div class="card rounded-4 border">
  <div class="card-body p-4">
    <h5 class="fw-bold mb-4">Department Overview</h5>
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
              <h4 class="fw-bold mb-0">{{ $stats['active_employees'] ?? 0 }}</h4>
              <small class="text-muted">Active Users</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="p-3 border rounded-3">
          <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(218,165,32,0.1);">
              <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-gold);">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
              </svg>
            </div>
            <div>
              <h4 class="fw-bold mb-0">{{ $stats['total_employees'] ?? 0 }}</h4>
              <small class="text-muted">Total Users</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="p-3 border rounded-3">
          <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(0,150,57,0.1);">
              <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-green-500);">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
              </svg>
            </div>
            <div>
              <h4 class="fw-bold mb-0">{{ $stats['inactive_employees'] ?? 0 }}</h4>
              <small class="text-muted">Inactive Users</small>
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

// Employee Status Bar Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
  type: 'bar',
  data: {
    labels: ['Active', 'On Leave', 'Inactive', 'Retired'],
    datasets: [{
      label: 'Users',
      data: [{{ $stats['active_employees'] ?? 0 }}, {{ $stats['on_leave_employees'] ?? 0 }}, {{ $stats['inactive_employees'] ?? 0 }}, {{ $stats['retired_employees'] ?? 0 }}],
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

// Employment Type Doughnut Chart
const employmentCtx = document.getElementById('employmentChart').getContext('2d');
new Chart(employmentCtx, {
  type: 'doughnut',
  data: {
    labels: ['Regular', 'Contractual', 'Part-time'],
    datasets: [{
      data: [{{ $stats['active_employees'] ?? 50 }}, {{ $stats['inactive_employees'] ?? 10 }}, {{ $stats['on_leave_employees'] ?? 5 }}],
      backgroundColor: [clsuGreen, clsuGold, clsuGreenDark],
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
