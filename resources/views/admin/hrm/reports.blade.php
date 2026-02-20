@extends('admin.hrm-layout')

@section('title','Reports')
@section('crumb','Reports')

@section('content')

<div class="mb-4">
  <h1 class="h3 fw-bold mb-1">HR Reports</h1>
  <p class="text-muted mb-0">Generate and view Human Resources department reports</p>
</div>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body p-4 text-center">
        <div class="h1 fw-bold mb-2" style="color: var(--clsu-green);">{{ $stats['total_employees'] }}</div>
        <div class="text-muted">Total Users</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body p-4 text-center">
        <div class="h1 fw-bold mb-2" style="color: var(--clsu-gold);">{{ $stats['active_employees'] }}</div>
        <div class="text-muted">Active</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body p-4 text-center">
        <div class="h1 fw-bold mb-2 text-primary">{{ $stats['on_leave_employees'] }}</div>
        <div class="text-muted">On Leave</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body p-4 text-center">
        <div class="h1 fw-bold mb-2 text-secondary">{{ $stats['inactive_employees'] + $stats['retired_employees'] }}</div>
        <div class="text-muted">Inactive/Retired</div>
      </div>
    </div>
  </div>
</div>

<!-- Report Generation -->
<div class="row g-3">
  <div class="col-lg-8">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Generate Report</h5>
        
        <form action="{{ route('admin.hrm.reports.generate') }}" method="POST" id="reportForm">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Report Type</label>
              <select class="form-select" name="report_type">
                <option value="Employee List">Employee List</option>
                <option value="Status Summary">Status Summary</option>
                <option value="Employment Type Distribution">Employment Type Distribution</option>
                <option value="Department Overview">Department Overview</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Format</label>
              <select class="form-select" name="format">
                <option value="pdf">PDF</option>
                <option value="xlsx" disabled>Excel (XLSX) - Coming Soon</option>
                <option value="csv" disabled>CSV - Coming Soon</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Date From</label>
              <input type="date" class="form-control" name="date_from">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Date To</label>
              <input type="date" class="form-control" name="date_to">
            </div>

            <div class="col-12">
              <label class="form-label fw-bold">Filter by Status</label>
              <div class="d-flex gap-3 flex-wrap">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="status[]" value="active" id="active" checked>
                  <label class="form-check-label" for="active">Active</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="status[]" value="on_leave" id="onleave" checked>
                  <label class="form-check-label" for="onleave">On Leave</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="status[]" value="inactive" id="inactive">
                  <label class="form-check-label" for="inactive">Inactive</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="status[]" value="retired" id="retired">
                  <label class="form-check-label" for="retired">Retired</label>
                </div>
              </div>
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-gold rounded-4" id="generateBtn">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" class="me-2">
                  <path d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2z"/>
                </svg>
                <span id="btnText">Generate Report</span>
                <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Recent Reports</h5>
        
        <div class="d-flex flex-column gap-3">
          <div class="alert alert-light mb-0">
            <div class="d-flex align-items-start">
              <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" class="me-2 mt-1" style="color: var(--clsu-green);">
                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
              </svg>
              <div class="flex-grow-1">
                <div class="fw-bold small">Employee List</div>
                <div class="text-muted small">Generated: Today</div>
              </div>
            </div>
          </div>

          <div class="alert alert-light mb-0">
            <div class="d-flex align-items-start">
              <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" class="me-2 mt-1" style="color: var(--clsu-gold);">
                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
              </svg>
              <div class="flex-grow-1">
                <div class="fw-bold small">Status Summary</div>
                <div class="text-muted small">Generated: Yesterday</div>
              </div>
            </div>
          </div>

          <div class="text-center text-muted small mt-2">
            Report history feature coming soon
          </div>
        </div>
      </div>
    </div>

    <div class="card rounded-4 border mt-3">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-3">Quick Stats</h5>
        <div class="small">
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Department:</span>
            <span class="fw-bold">Human Resources</span>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Active Rate:</span>
            <span class="fw-bold" style="color: var(--clsu-green);">
              {{ $stats['total_employees'] > 0 ? round(($stats['active_employees'] / $stats['total_employees']) * 100, 1) : 0 }}%
            </span>
          </div>
          <div class="d-flex justify-content-between">
            <span class="text-muted">Last Updated:</span>
            <span class="fw-bold">{{ now()->format('M d, Y') }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
  document.getElementById('reportForm').addEventListener('submit', function() {
    const btn = document.getElementById('generateBtn');
    const text = document.getElementById('btnText');
    const spinner = document.getElementById('btnSpinner');
    
    // Disable button and show spinner
    btn.disabled = true;
    text.textContent = 'Generating...';
    spinner.classList.remove('d-none');

    // Re-enable after 5 seconds (simulating download start)
    setTimeout(function() {
      btn.disabled = false;
      text.textContent = 'Generate Report';
      spinner.classList.add('d-none');
    }, 5000);
  });
</script>
@endsection
