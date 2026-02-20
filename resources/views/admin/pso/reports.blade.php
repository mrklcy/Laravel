@extends('admin.pso-layout')

@section('title', 'Reports')

@section('content')

<div class="mb-4">
  <h1 class="h3 fw-bold mb-1">Reports</h1>
  <p class="text-muted mb-0">Generate and view Property & Supply reports</p>
</div>

<!-- Report Generation -->
<div class="row g-3 mb-4">
  <div class="col-lg-8">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Generate Report</h5>
        
        <form action="{{ route('pso.reports.generate') }}" method="POST" target="_blank" id="generateReportForm">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Report Type</label>
              <select class="form-select rounded-3" name="report_type" id="reportType">
                <option value="Strategic Plan Progress">Property Inventory Report</option>
                <option value="Project Portfolio">Supply Issuance Report</option>
                <option value="Performance Dashboard">Stock Level Dashboard</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Format</label>
              <select class="form-select rounded-3" name="format">
                <option value="pdf">PDF (Print View)</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Date From</label>
              <input type="date" class="form-control rounded-3" name="date_from" value="{{ now()->startOfYear()->format('Y-m-d') }}">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Date To</label>
              <input type="date" class="form-control rounded-3" name="date_to" value="{{ now()->format('Y-m-d') }}">
            </div>

            <div class="col-12">
              <button type="submit" class="btn text-white rounded-3" style="background: var(--clsu-green);">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" class="me-2">
                  <path d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2z"/>
                </svg>
                Generate Report
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Recent Reports</h5>
        
        <div class="d-flex flex-column gap-3">
          <div class="alert alert-light mb-0">
            <div class="d-flex align-items-start">
              <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" class="me-2 mt-1" style="color: var(--pso-blue);">
                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
              </svg>
              <div class="flex-grow-1">
                <div class="fw-bold small">Property Inventory Report</div>
                <div class="text-muted small">Generated: {{ now()->subDays(2)->format('M d, Y') }}</div>
              </div>
            </div>
          </div>

          <div class="alert alert-light mb-0">
            <div class="d-flex align-items-start">
              <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" class="me-2 mt-1" style="color: var(--pso-blue);">
                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
              </svg>
              <div class="flex-grow-1">
                <div class="fw-bold small">Supply Issuance Report</div>
                <div class="text-muted small">Generated: {{ now()->subDays(7)->format('M d, Y') }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Available Reports -->
<div class="card rounded-4 border">
  <div class="card-header bg-white border-bottom py-3">
    <h5 class="fw-bold mb-0">Report Templates</h5>
  </div>
  <div class="card-body p-4">
    <div class="row g-3">
      <div class="col-md-4">
        <div class="card border h-100">
          <div class="card-body">
            <h6 class="fw-bold mb-2">Property Inventory Report</h6>
            <p class="text-muted small mb-3">Comprehensive overview of all university property records and accountability</p>
            <button class="btn btn-sm btn-outline-primary rounded-3 w-100" onclick="selectReport('Strategic Plan Progress')">Generate</button>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border h-100">
          <div class="card-body">
            <h6 class="fw-bold mb-2">Supply Issuance Report</h6>
            <p class="text-muted small mb-3">Detailed report on all supply issuances and distribution records</p>
            <button class="btn btn-sm btn-outline-primary rounded-3 w-100" onclick="selectReport('Project Portfolio')">Generate</button>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border h-100">
          <div class="card-body">
            <h6 class="fw-bold mb-2">Stock Level Dashboard</h6>
            <p class="text-muted small mb-3">Current stock levels, reorder points, and inventory metrics</p>
            <button class="btn btn-sm btn-outline-primary rounded-3 w-100" onclick="selectReport('Performance Dashboard')">Generate</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
function selectReport(type) {
    document.getElementById('reportType').value = type;
    document.getElementById('generateReportForm').scrollIntoView({ behavior: 'smooth' });
}

document.getElementById('generateReportForm').addEventListener('submit', function() {
    const type = document.getElementById('reportType').value;
    alert(`Generating and downloading "${type}" report...`);
});
</script>
@endsection
