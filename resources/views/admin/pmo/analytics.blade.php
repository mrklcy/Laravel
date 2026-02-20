@extends('admin.pmo-layout')

@section('title','Analytics')
@section('crumb','Analytics')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <img src="/images/clsu-logo-green.png" alt="CLSU Seal" style="width:56px;height:56px;border-radius:14px;background:#fff;border:2px solid var(--clsu-green-500);object-fit:contain;">
    <div>
      <h1 class="h3 fw-bold mb-1">PMO Analytics</h1>
      <div class="text-muted">Procurement performance insights and trends</div>
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
          </svg>
        </div>
        <h3 class="fw-bold mb-1">{{ $stats['total_buildings'] ?? 0 }}</h3>
        <small class="text-muted">Purchase Orders</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-green-700);">{{ $stats['active_buildings'] ?? 0 }} Approved</span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body text-center p-4">
        <div class="mb-2">
          <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-green-500);">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
          </svg>
        </div>
        <h3 class="fw-bold mb-1">{{ $stats['total_equipment'] ?? 0 }}</h3>
        <small class="text-muted">Active Suppliers</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-green-500);">{{ $stats['functional_equipment'] ?? 0 }} Accredited</span>
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
        <h3 class="fw-bold mb-1">{{ $stats['total_maintenance'] ?? 0 }}</h3>
        <small class="text-muted">Pending Orders</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-gold);">{{ $stats['pending_maintenance'] ?? 0 }} In Transit</span>
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
        <h3 class="fw-bold mb-1">{{ $stats['total_vehicles'] ?? 0 }}</h3>
        <small class="text-muted">Active Bids</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-green-300);">{{ $stats['available_vehicles'] ?? 0 }} Open</span>
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
        <h5 class="fw-bold mb-4">Procurement Distribution</h5>
        <canvas id="assetChart" height="100"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Order Status</h5>
        <canvas id="maintenanceChart"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- System Overview -->
<div class="card rounded-4 border">
  <div class="card-body p-4">
    <h5 class="fw-bold mb-4">Procurement Overview</h5>
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
              <h4 class="fw-bold mb-0">{{ $stats['completed_maintenance'] ?? 0 }}</h4>
              <small class="text-muted">Completed Orders</small>
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
              <h4 class="fw-bold mb-0">{{ $stats['total_buildings'] ?? 0 }}</h4>
              <small class="text-muted">Active Contracts</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="p-3 border rounded-3">
          <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(0,150,57,0.1);">
              <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-green-500);">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
              </svg>
            </div>
            <div>
              <h4 class="fw-bold mb-0">{{ $stats['functional_equipment'] ?? 0 }}</h4>
              <small class="text-muted">Accredited Suppliers</small>
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

// Asset Distribution Bar Chart
const assetCtx = document.getElementById('assetChart').getContext('2d');
new Chart(assetCtx, {
  type: 'bar',
  data: {
    labels: ['Purchase Orders', 'Suppliers', 'Bids'],
    datasets: [{
      label: 'Total',
      data: [{{ $stats['total_buildings'] ?? 0 }}, {{ $stats['total_equipment'] ?? 0 }}, {{ $stats['total_vehicles'] ?? 0 }}],
      backgroundColor: [clsuGreen, clsuGold, clsuGreenDark],
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

// Order Status Doughnut Chart
const maintenanceCtx = document.getElementById('maintenanceChart').getContext('2d');
new Chart(maintenanceCtx, {
  type: 'doughnut',
  data: {
    labels: ['Pending', 'In Transit', 'Delivered'],
    datasets: [{
      data: [{{ $stats['pending_maintenance'] ?? 0 }}, {{ $stats['in_progress_maintenance'] ?? 0 }}, {{ $stats['completed_maintenance'] ?? 0 }}],
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
