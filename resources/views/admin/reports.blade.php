@extends('admin.admin-layout')

@section('title','Reports')
@section('crumb','Reports')

@section('content')

<div class="mb-4">
  <div class="d-flex align-items-center gap-3">
    <img src="{{ asset('images/clsu-logo-green.png') }}" alt="CLSU Logo" class="mb-3" style="width: 80px; height: 80px; object-fit: contain; border-radius:50%;background:#fff;border:2px solid var(--clsu-green);padding:2px;">
    <div>
      <h1 class="h3 fw-bold mb-1">Unified Reports Center</h1>
      <div class="text-muted">Centralized access to all office reports and system-wide analytics</div>
    </div>
  </div>
</div>

<!-- Office Report Hub Cards -->
<div class="row g-4 mb-5">
  
  <!-- HRMO Reports -->
  <div class="col-md-6 col-lg-3">
    <a href="{{ route('admin.hrm.reports') }}" class="card h-100 rounded-4 border card-hover text-decoration-none text-dark">
      <div class="card-body p-4 text-center">
        <div class="mb-3 d-inline-block p-3 rounded-circle" style="background: rgba(0, 150, 57, 0.1);">
          <img src="{{ asset('images/icons/hrmo.svg') }}" alt="HRMO Icon" width="64" height="64">
        </div>
        <h5 class="fw-bold mb-2">Human Resources</h5>
        <span class="badge rounded-pill bg-light text-dark border mb-3">HRMO</span>
        <p class="text-muted small mb-0">Employee demographics, attendance logs, leave summaries, and service record reports.</p>
      </div>
      <div class="card-footer bg-white border-top-0 p-4 pt-0 text-center">
        <div class="d-inline-flex align-items-center text-primary fw-semibold small">
          Access Reports <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" class="ms-1"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
        </div>
      </div>
    </a>
  </div>

  <!-- RMO Reports -->
  <div class="col-md-6 col-lg-3">
    <a href="{{ route('rmo.reports') }}" class="card h-100 rounded-4 border card-hover text-decoration-none text-dark">
      <div class="card-body p-4 text-center">
        <div class="mb-3 d-inline-block p-3 rounded-circle" style="background: rgba(224, 167, 13, 0.1);">
          <img src="{{ asset('images/icons/rmo.svg') }}" alt="RMO Icon" width="64" height="64">
        </div>
        <h5 class="fw-bold mb-2">Records Management</h5>
        <span class="badge rounded-pill bg-light text-dark border mb-3">RMO</span>
        <p class="text-muted small mb-0">Document inventories, request fulfillment status, digitization progress, and archive summaries.</p>
      </div>
      <div class="card-footer bg-white border-top-0 p-4 pt-0 text-center">
        <div class="d-inline-flex align-items-center text-primary fw-semibold small">
          Access Reports <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" class="ms-1"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
        </div>
      </div>
    </a>
  </div>

  <!-- PMO Reports -->
  <div class="col-md-6 col-lg-3">
    <a href="{{ route('pmo.reports') }}" class="card h-100 rounded-4 border card-hover text-decoration-none text-dark">
      <div class="card-body p-4 text-center">
        <div class="mb-3 d-inline-block p-3 rounded-circle" style="background: rgba(13, 110, 253, 0.1);">
          <img src="{{ asset('images/icons/pmo.svg') }}" alt="PMO Icon" width="64" height="64">
        </div>
        <h5 class="fw-bold mb-2">Procurement Management</h5>
        <span class="badge rounded-pill bg-light text-dark border mb-3">PMO</span>
        <p class="text-muted small mb-0">Purchase requests, bid summaries, procurement tracking, and supplier performance reports.</p>
      </div>
      <div class="card-footer bg-white border-top-0 p-4 pt-0 text-center">
        <div class="d-inline-flex align-items-center text-primary fw-semibold small">
          Access Reports <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" class="ms-1"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
        </div>
      </div>
    </a>
  </div>

  <!-- PSO Reports -->
  <div class="col-md-6 col-lg-3">
    <a href="{{ route('pso.reports') }}" class="card h-100 rounded-4 border card-hover text-decoration-none text-dark">
      <div class="card-body p-4 text-center">
        <div class="mb-3 d-inline-block p-3 rounded-circle" style="background: rgba(13, 110, 253, 0.1);">
          <img src="{{ asset('images/icons/pso.svg') }}" alt="PSO Icon" width="64" height="64">
        </div>
        <h5 class="fw-bold mb-2">Project Management</h5>
        <span class="badge rounded-pill bg-light text-dark border mb-3">PSO</span>
        <p class="text-muted small mb-0">Strategic plan progress, project portfolio status, and performance metrics dashboards.</p>
      </div>
      <div class="card-footer bg-white border-top-0 p-4 pt-0 text-center">
        <div class="d-inline-flex align-items-center text-primary fw-semibold small">
          Access Reports <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" class="ms-1"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
        </div>
      </div>
    </a>
  </div>

</div>

<!-- System Wide Overview -->
<h5 class="fw-bold mb-3">System Overview</h5>
<div class="row g-3">
  <div class="col-md-4">
    <div class="card rounded-4 border card-hover h-100 position-relative">
      <a href="{{ route('admin.offices.index') }}" class="text-decoration-none text-dark d-block h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-2">
            <h6 class="text-muted mb-0">Total Offices</h6>
            <button class="btn btn-sm btn-link p-0 text-muted download-btn" data-report="Offices Summary" style="z-index: 2;">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
            </button>
          </div>
          <h2 class="fw-bold">{{ $stats['total_offices'] }}</h2>
          <small class="text-success">{{ $stats['active_offices'] }} active</small>
        </div>
      </a>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card rounded-4 border card-hover h-100 position-relative">
      <a href="{{ route('admin.services.index') }}" class="text-decoration-none text-dark d-block h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-2">
            <h6 class="text-muted mb-0">Total Services</h6>
            <button class="btn btn-sm btn-link p-0 text-muted download-btn" data-report="Services Summary" style="z-index: 2;">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
            </button>
          </div>
          <h2 class="fw-bold">{{ $stats['total_services'] }}</h2>
          <small class="text-success">{{ $stats['active_services'] }} active</small>
        </div>
      </a>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card rounded-4 border card-hover h-100 position-relative">
      <a href="{{ route('admin.programs.index') }}" class="text-decoration-none text-dark d-block h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-2">
            <h6 class="text-muted mb-0">Total Programs</h6>
            <button class="btn btn-sm btn-link p-0 text-muted download-btn" data-report="Programs Summary" style="z-index: 2;">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
            </button>
          </div>
          <h2 class="fw-bold">{{ $stats['total_programs'] }}</h2>
          <small class="text-success">{{ $stats['active_programs'] }} active</small>
        </div>
      </a>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card rounded-4 border card-hover h-100 position-relative">
      <a href="{{ route('admin.news.index') }}" class="text-decoration-none text-dark d-block h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-2">
            <h6 class="text-muted mb-0">Total News</h6>
            <button class="btn btn-sm btn-link p-0 text-muted download-btn" data-report="News Summary" style="z-index: 2;">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
            </button>
          </div>
          <h2 class="fw-bold">{{ $stats['total_news'] }}</h2>
          <small class="text-success">{{ $stats['published_news'] }} published</small>
        </div>
      </a>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card rounded-4 border card-hover h-100 position-relative">
      <a href="{{ route('admin.inquiries.index') }}" class="text-decoration-none text-dark d-block h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-2">
            <h6 class="text-muted mb-0">Total Inquiries</h6>
            <button class="btn btn-sm btn-link p-0 text-muted download-btn" data-report="Inquiries Summary" style="z-index: 2;">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
            </button>
          </div>
          <h2 class="fw-bold">{{ $stats['total_inquiries'] }}</h2>
          <small class="text-warning">{{ $stats['pending_inquiries'] }} pending</small>
        </div>
      </a>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card rounded-4 border card-hover h-100 position-relative">
      <a href="{{ route('admin.users.index') }}" class="text-decoration-none text-dark d-block h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-2">
            <h6 class="text-muted mb-0">Total Users</h6>
            <button class="btn btn-sm btn-link p-0 text-muted download-btn" data-report="Users Summary" style="z-index: 2;">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
            </button>
          </div>
          <h2 class="fw-bold">{{ $stats['total_employees'] }}</h2>
          <small class="text-success">{{ $stats['active_employees'] }} active</small>
        </div>
      </a>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const downloadBtns = document.querySelectorAll('.download-btn');
  downloadBtns.forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault(); // Prevent navigating to the card link
      e.stopPropagation(); // Stop event bubbling
      const reportName = this.getAttribute('data-report');
      alert(`Generating and downloading "${reportName}"...`);
      window.location.href = `{{ route('admin.reports.download') }}?type=${encodeURIComponent(reportName)}`;
    });
  });
});
</script>

<style>
.card-hover {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card-hover:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
  border-color: var(--clsu-green) !important;
}
</style>

@endsection
