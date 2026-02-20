@extends('admin.rmo-layout')

@section('title', 'Reports')

@section('content')

<div class="mb-4">
  <h1 class="h3 fw-bold mb-1">Reports</h1>
  <p class="text-muted mb-0">Generate and view records management reports</p>
</div>

<!-- Success / Error Alerts -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
  {{ session('error') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Toast container for feedback -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;">
  <div id="reportToast" class="toast align-items-center text-white bg-success border-0 rounded-4" role="alert">
    <div class="d-flex">
      <div class="toast-body" id="toastMessage">Report generated successfully!</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<!-- Report Generation -->
<div class="row g-3 mb-4">
  <div class="col-md-8">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Generate Report</h5>
        
        <form action="{{ route('rmo.reports.generate') }}" method="POST" id="reportForm">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Report Type</label>
              <select class="form-select" name="report_type" required>
                <option>Document Inventory</option>
                <option>Request Fulfillment Status</option>
                <option>Archive Summary</option>
                <option>Disposal Log</option>
                <option>Access Log</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Format</label>
              <select class="form-select" name="format">
                <option>PDF</option>
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
              <button type="submit" class="btn text-white rounded-4 px-4 py-2" id="generateBtn" style="background: linear-gradient(135deg, #009639, #1E6031); border: none;">
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

  <div class="col-md-4">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Recent Documents</h5>
        
        <div class="d-flex flex-column gap-3">
          @forelse($recentReports as $doc)
          <div class="alert alert-light mb-0">
            <div class="d-flex align-items-start">
              <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" class="me-2 mt-1" style="color: var(--rmo-orange);">
                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
              </svg>
              <div class="flex-grow-1">
                <div class="fw-bold small">{{ $doc->name }}</div>
                <div class="text-muted small">{{ $doc->reference_no }} &bull; {{ $doc->created_at->format('M d, Y') }}</div>
              </div>
              <span class="badge rounded-pill {{ $doc->status === 'active' ? 'bg-success' : ($doc->status === 'pending' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                {{ ucfirst($doc->status) }}
              </span>
            </div>
          </div>
          @empty
          <div class="text-muted text-center small py-3">No recent documents found</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scheduled Reports -->
<div class="card rounded-4 border">
  <div class="card-header bg-white border-bottom py-3">
    <h5 class="fw-bold mb-0">Scheduled Reports</h5>
  </div>
  <div class="card-body p-4">
    <div class="row g-3">
      <div class="col-md-4">
        <div class="card border h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
              <h6 class="fw-bold">Monthly Inventory</h6>
              <span class="badge bg-success">Active</span>
            </div>
            <p class="text-muted small mb-3">Automated inventory summary sent every 1st of the month</p>
            <div class="d-flex gap-2">
              <button class="btn btn-sm btn-outline-secondary flex-grow-1" onclick="showToast('Edit feature coming soon')">Edit</button>
              <button class="btn btn-sm btn-outline-secondary run-now-btn" data-report="Document Inventory">
                <span class="btn-label">Run Now</span>
                <span class="btn-spinner spinner-border spinner-border-sm d-none" role="status"></span>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
              <h6 class="fw-bold">Quarterly Audit</h6>
              <span class="badge bg-success">Active</span>
            </div>
            <p class="text-muted small mb-3">Compliance audit report generated every quarter</p>
            <div class="d-flex gap-2">
              <button class="btn btn-sm btn-outline-secondary flex-grow-1" onclick="showToast('Edit feature coming soon')">Edit</button>
              <button class="btn btn-sm btn-outline-secondary run-now-btn" data-report="Archive Summary">
                <span class="btn-label">Run Now</span>
                <span class="btn-spinner spinner-border spinner-border-sm d-none" role="status"></span>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border h-100 d-flex align-items-center justify-content-center bg-light" style="border-style: dashed !important;">
          <button class="btn btn-link text-decoration-none text-muted" onclick="showToast('Scheduling feature coming soon')">
            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24" class="d-block mx-auto mb-1">
              <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
            </svg>
            Schedule New Report
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
  // Show loading spinner on form submit
  document.getElementById('reportForm').addEventListener('submit', function() {
    const btn = document.getElementById('generateBtn');
    const text = document.getElementById('btnText');
    const spinner = document.getElementById('btnSpinner');
    const type = document.querySelector('select[name="report_type"]').value;
    
    alert(`Generating and downloading "${type}" report...`);

    btn.disabled = true;
    text.textContent = 'Generating...';
    spinner.classList.remove('d-none');

    // Re-enable after 5 seconds (in case download completes)
    setTimeout(function() {
      btn.disabled = false;
      text.textContent = 'Generate Report';
      spinner.classList.add('d-none');
    }, 5000);
  });

  // Run Now buttons — submits a hidden form for the specified report type
  document.querySelectorAll('.run-now-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
      const reportType = this.getAttribute('data-report');
      const label = this.querySelector('.btn-label');
      const spinner = this.querySelector('.btn-spinner');

      alert(`Generating and downloading "${reportType}" report...`);

      label.textContent = 'Running...';
      spinner.classList.remove('d-none');
      this.disabled = true;

      // Create and submit a temporary form
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '{{ route("rmo.reports.generate") }}';
      form.style.display = 'none';

      const csrf = document.createElement('input');
      csrf.name = '_token';
      csrf.value = '{{ csrf_token() }}';
      form.appendChild(csrf);

      const typeInput = document.createElement('input');
      typeInput.name = 'report_type';
      typeInput.value = reportType;
      form.appendChild(typeInput);

      document.body.appendChild(form);
      form.submit();

      // Re-enable button after 5 seconds
      const that = this;
      setTimeout(function() {
        label.textContent = 'Run Now';
        spinner.classList.add('d-none');
        that.disabled = false;
      }, 5000);
    });
  });

  // Toast helper
  function showToast(message) {
    const toastEl = document.getElementById('reportToast');
    const msgEl = document.getElementById('toastMessage');
    msgEl.textContent = message;
    const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();
  }
</script>
@endsection
