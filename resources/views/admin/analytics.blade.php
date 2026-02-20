@extends('admin.admin-layout')

@section('title','Analytics')
@section('crumb','Analytics')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <img src="/images/clsu-logo-green.png" alt="CLSU Seal" style="width:56px;height:56px;border-radius:14px;background:#fff;border:2px solid var(--clsu-green-500);object-fit:contain;">
    <div>
      <h1 class="h3 fw-bold mb-1">Analytics</h1>
      <div class="text-muted">Visual insights and data trends</div>
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
        <h3 class="fw-bold mb-1">{{ $stats['total_offices'] }}</h3>
        <small class="text-muted">Total Offices</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-green-700);">{{ $stats['active_offices'] }} Active</span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body text-center p-4">
        <div class="mb-2">
          <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-green-500);">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
          </svg>
        </div>
        <h3 class="fw-bold mb-1">{{ $stats['total_services'] }}</h3>
        <small class="text-muted">Total Services</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-green-500);">{{ $stats['active_services'] }} Active</span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body text-center p-4">
        <div class="mb-2">
          <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-gold);">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h3 class="fw-bold mb-1">{{ $stats['total_programs'] }}</h3>
        <small class="text-muted">Total Programs</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-gold);">{{ $stats['active_programs'] }} Active</span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body text-center p-4">
        <div class="mb-2">
          <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-green-300);">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
          </svg>
        </div>
        <h3 class="fw-bold mb-1">{{ $stats['total_inquiries'] }}</h3>
        <small class="text-muted">Total Inquiries</small>
        <div class="mt-2">
          <span class="badge" style="background: var(--clsu-green-300);">{{ $stats['pending_inquiries'] }} Pending</span>
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
        <h5 class="fw-bold mb-4">Content Distribution</h5>
        <canvas id="contentChart" height="100"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Inquiry Analytics</h5>
        <canvas id="inquiryChart"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- System Overview -->
<div class="card rounded-4 border">
  <div class="card-body p-4">
    <h5 class="fw-bold mb-4">System Overview</h5>
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
              <h4 class="fw-bold mb-0">{{ $stats['active_offices'] }}</h4>
              <small class="text-muted">Active Offices</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="p-3 border rounded-3">
          <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(218,165,32,0.1);">
              <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--clsu-gold);">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
              </svg>
            </div>
            <div>
              <h4 class="fw-bold mb-0">{{ $stats['total_employees'] }}</h4>
              <small class="text-muted">Admin Users</small>
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
              <h4 class="fw-bold mb-0">{{ $stats['published_news'] }}</h4>
              <small class="text-muted">Published News</small>
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

// Content Distribution Bar Chart
const contentCtx = document.getElementById('contentChart').getContext('2d');
new Chart(contentCtx, {
  type: 'bar',
  data: {
    labels: ['Services', 'Programs', 'News'],
    datasets: [{
      label: 'Total',
      data: [{{ $stats['total_services'] }}, {{ $stats['total_programs'] }}, {{ $stats['total_news'] }}],
      backgroundColor: [clsuGreen, clsuGold, clsuGreenDark],
      borderRadius: 8,
      borderSkipped: false,
    }, {
      label: 'Active/Published',
      data: [{{ $stats['active_services'] }}, {{ $stats['active_programs'] }}, {{ $stats['published_news'] }}],
      backgroundColor: [clsuGreen + '99', clsuGold + '99', clsuGreenDark + '99'],
      borderRadius: 8,
      borderSkipped: false,
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    plugins: {
      legend: {
        display: true,
        position: 'top',
      },
      tooltip: {
        backgroundColor: 'rgba(0, 0, 0, 0.8)',
        padding: 12,
        borderRadius: 8,
        titleFont: { size: 14, weight: 'bold' },
        bodyFont: { size: 13 },
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          precision: 0
        },
        grid: {
          color: 'rgba(0, 0, 0, 0.05)'
        }
      },
      x: {
        grid: {
          display: false
        }
      }
    }
  }
});

// Inquiry Status Doughnut Chart
const inquiryCtx = document.getElementById('inquiryChart').getContext('2d');
new Chart(inquiryCtx, {
  type: 'doughnut',
  data: {
    labels: ['Pending', 'Responded'],
    datasets: [{
      data: [{{ $stats['pending_inquiries'] }}, {{ $stats['total_inquiries'] - $stats['pending_inquiries'] }}],
      backgroundColor: [clsuGold, clsuGreen],
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
        display: true,
        position: 'bottom',
        labels: {
          padding: 20,
          font: {
            size: 13,
            weight: '500'
          },
          usePointStyle: true,
          pointStyle: 'circle'
        }
      },
      tooltip: {
        backgroundColor: 'rgba(0, 0, 0, 0.8)',
        padding: 12,
        borderRadius: 8,
        titleFont: { size: 14, weight: 'bold' },
        bodyFont: { size: 13 },
        callbacks: {
          label: function(context) {
            const label = context.label || '';
            const value = context.parsed || 0;
            const total = context.dataset.data.reduce((a, b) => a + b, 0);
            const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
            return `${label}: ${value} (${percentage}%)`;
          }
        }
      }
    }
  }
});
</script>
@endsection
