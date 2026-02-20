@extends('admin.rmo-layout')

@section('title', 'Requests')

@section('content')

<div class="mb-4">
  <h1 class="h3 fw-bold mb-1">Document Requests</h1>
  <p class="text-muted mb-0">Manage incoming requests for records and documents</p>
</div>

<!-- Requests Overview -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card rounded-4 border-start border-4" style="border-color: var(--clsu-gold) !important;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <div class="h6 text-muted mb-0">Pending</div>
          <span class="badge rounded-pill text-white" style="background: var(--clsu-gold);">12</span>
        </div>
        <h3 class="fw-bold mb-0">12</h3>
        <small class="text-muted">Requests awaiting action</small>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card rounded-4 border-start border-4 border-info h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <div class="h6 text-muted mb-0">Processing</div>
          <span class="badge bg-info rounded-pill">5</span>
        </div>
        <h3 class="fw-bold mb-0">5</h3>
        <small class="text-muted">Currently being fulfilled</small>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card rounded-4 border-start border-4 h-100" style="border-color: var(--clsu-green) !important;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <div class="h6 text-muted mb-0">Completed</div>
          <span class="badge rounded-pill text-white" style="background: var(--clsu-green);">128</span>
        </div>
        <h3 class="fw-bold mb-0">128</h3>
        <small class="text-muted">Fulfilled this month</small>
      </div>
    </div>
  </div>
</div>

<!-- Requests Table -->
<div class="card rounded-4 border">
  <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
    <h5 class="fw-bold mb-0">Request Queue</h5>
    <div class="d-flex gap-2">
      <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#filterModal">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" class="me-1">
          <path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"/>
        </svg>
        Filter
      </button>
      <button class="btn btn-sm" style="color: var(--clsu-green); border-color: var(--clsu-green);" id="exportBtn">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" class="me-1">
          <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
        </svg>
        Export
      </button>
    </div>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="bg-light">
          <tr>
            <th class="px-4 py-3">Request ID</th>
            <th class="py-3">Requester</th>
            <th class="py-3">Items Requested</th>
            <th class="py-3">Date</th>
            <th class="py-3">Status</th>
            <th class="py-3 text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr data-request-id="REQ-2024-089">
            <td class="px-4 py-3 font-monospace">REQ-2024-089</td>
            <td class="py-3">
              <div class="fw-bold">Juan Dela Cruz</div>
              <small class="text-muted">Student - BSIT</small>
            </td>
            <td class="py-3">Transcript of Records, Diploma</td>
            <td class="py-3">Feb 10, 2024</td>
            <td class="py-3"><span class="badge bg-warning">Pending</span></td>
            <td class="py-3 text-end">
              <button class="btn btn-sm text-white btn-approve-req" style="background: var(--clsu-green);"
                      data-id="REQ-2024-089"
                      data-name="Juan Dela Cruz"
                      data-items="Transcript of Records, Diploma">Approve</button>
              <button class="btn btn-sm btn-details-req" style="color: var(--clsu-green); border-color: var(--clsu-green);"
                      data-id="REQ-2024-089"
                      data-name="Juan Dela Cruz"
                      data-role="Student - BSIT"
                      data-items="Transcript of Records, Diploma"
                      data-date="Feb 10, 2024"
                      data-status="Pending"
                      data-purpose="Graduation requirement and employment application"
                      data-contact="juan.delacruz@clsu.edu.ph"
                      data-phone="0917-123-4567"
                      data-notes="Needs certified true copy. Rush request.">Details</button>
            </td>
          </tr>
          <tr data-request-id="REQ-2024-088">
            <td class="px-4 py-3 font-monospace">REQ-2024-088</td>
            <td class="py-3">
              <div class="fw-bold">Maria Santos</div>
              <small class="text-muted">Faculty - CAS</small>
            </td>
            <td class="py-3">Service Record</td>
            <td class="py-3">Feb 09, 2024</td>
            <td class="py-3"><span class="badge bg-info">Processing</span></td>
            <td class="py-3 text-end">
              <button class="btn btn-sm text-white btn-complete-req" style="background: var(--clsu-gold);"
                      data-id="REQ-2024-088"
                      data-name="Maria Santos"
                      data-items="Service Record">Complete</button>
              <button class="btn btn-sm btn-details-req" style="color: var(--clsu-green); border-color: var(--clsu-green);"
                      data-id="REQ-2024-088"
                      data-name="Maria Santos"
                      data-role="Faculty - CAS"
                      data-items="Service Record"
                      data-date="Feb 09, 2024"
                      data-status="Processing"
                      data-purpose="Application for promotion / reclassification"
                      data-contact="maria.santos@clsu.edu.ph"
                      data-phone="0918-456-7890"
                      data-notes="Requires complete service record from date of appointment.">Details</button>
            </td>
          </tr>
          <tr data-request-id="REQ-2024-087">
            <td class="px-4 py-3 font-monospace">REQ-2024-087</td>
            <td class="py-3">
              <div class="fw-bold">HR Dept.</div>
              <small class="text-muted">Internal Request</small>
            </td>
            <td class="py-3">Employee 201 Files (Batch 2)</td>
            <td class="py-3">Feb 08, 2024</td>
            <td class="py-3"><span class="badge" style="background: var(--clsu-green);">Completed</span></td>
            <td class="py-3 text-end">
              <button class="btn btn-sm btn-details-req" style="color: var(--clsu-green); border-color: var(--clsu-green);"
                      data-id="REQ-2024-087"
                      data-name="HR Dept."
                      data-role="Internal Request"
                      data-items="Employee 201 Files (Batch 2)"
                      data-date="Feb 08, 2024"
                      data-status="Completed"
                      data-purpose="Annual audit and records updating"
                      data-contact="hrmo@clsu.edu.ph"
                      data-phone="(044) 456-0107 loc. 234"
                      data-notes="Batch of 25 files. Completed and returned on Feb 09, 2024.">Details</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Request Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label text-muted small">Request ID</label>
            <div class="fw-bold font-monospace" id="detailReqId"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Status</label>
            <div><span id="detailStatus" class="badge"></span></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Requester</label>
            <div class="fw-semibold" id="detailName"></div>
            <small class="text-muted" id="detailRole"></small>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Date Requested</label>
            <div class="fw-semibold" id="detailDate"></div>
          </div>

          <div class="col-12">
            <hr class="my-1">
          </div>

          <div class="col-12">
            <label class="form-label text-muted small">Items Requested</label>
            <div class="fw-semibold" id="detailItems"></div>
          </div>
          <div class="col-12">
            <label class="form-label text-muted small">Purpose</label>
            <div class="fw-semibold" id="detailPurpose"></div>
          </div>

          <div class="col-12">
            <hr class="my-1">
          </div>

          <div class="col-md-6">
            <label class="form-label text-muted small">Email</label>
            <div class="fw-semibold" id="detailEmail"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Phone</label>
            <div class="fw-semibold" id="detailPhone"></div>
          </div>
          <div class="col-12">
            <label class="form-label text-muted small">Notes</label>
            <div class="p-3 bg-light rounded-3" id="detailNotes"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn rounded-3" style="color: var(--clsu-green); border-color: var(--clsu-green);" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Approve Confirmation Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Approve Request</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="text-center mb-3">
          <svg width="48" height="48" viewBox="0 0 24 24" fill="var(--clsu-green)">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
          </svg>
        </div>
        <p class="text-center mb-1">Approve this request and start processing?</p>
        <p class="text-center fw-bold" id="approveReqName"></p>
        <p class="text-center text-muted small" id="approveReqItems"></p>

        <div class="mb-3 mt-3">
          <label class="form-label fw-bold small">Add Note (Optional)</label>
          <textarea class="form-control rounded-3" id="approveNote" rows="2" placeholder="e.g. Estimated 3 working days..."></textarea>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 justify-content-center">
        <button type="button" class="btn rounded-3 px-4" style="color: var(--clsu-gold); border-color: var(--clsu-gold);" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn rounded-3 px-4 text-white" style="background: var(--clsu-green);" id="confirmApproveBtn">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" class="me-1">
            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
          </svg>
          Approve & Process
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Complete Confirmation Modal -->
<div class="modal fade" id="completeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Mark as Complete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="text-center mb-3">
          <svg width="48" height="48" viewBox="0 0 24 24" fill="var(--clsu-gold)">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
          </svg>
        </div>
        <p class="text-center mb-1">Mark this request as completed?</p>
        <p class="text-center fw-bold" id="completeReqName"></p>
        <p class="text-center text-muted small" id="completeReqItems"></p>

        <div class="mb-3 mt-3">
          <label class="form-label fw-bold small">Completion Note (Optional)</label>
          <textarea class="form-control rounded-3" id="completeNote" rows="2" placeholder="e.g. Documents released to requester..."></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold small">Release Method</label>
          <select class="form-select rounded-3" id="releaseMethod">
            <option value="pickup">Pick-up at RMO Office</option>
            <option value="email">Sent via Email</option>
            <option value="courier">Sent via Courier</option>
            <option value="internal">Internal Delivery</option>
          </select>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 justify-content-center">
        <button type="button" class="btn rounded-3 px-4" style="color: var(--clsu-gold); border-color: var(--clsu-gold);" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn rounded-3 px-4 text-white" style="background: var(--clsu-green);" id="confirmCompleteBtn">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" class="me-1">
            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
          </svg>
          Mark Complete
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Filter Requests</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="mb-3">
          <label class="form-label fw-bold small">Status</label>
          <select class="form-select rounded-3" id="filterStatus">
            <option value="all">All Status</option>
            <option value="pending">Pending</option>
            <option value="processing">Processing</option>
            <option value="completed">Completed</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold small">Date Range</label>
          <div class="row g-2">
            <div class="col-6">
              <input type="date" class="form-control rounded-3" id="filterDateFrom">
            </div>
            <div class="col-6">
              <input type="date" class="form-control rounded-3" id="filterDateTo">
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold small">Requester Type</label>
          <select class="form-select rounded-3" id="filterType">
            <option value="all">All Types</option>
            <option value="student">Student</option>
            <option value="faculty">Faculty</option>
            <option value="internal">Internal</option>
          </select>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn rounded-3" style="color: var(--clsu-gold); border-color: var(--clsu-gold);" id="resetFilterBtn">Reset</button>
        <button type="button" class="btn rounded-3 text-white" style="background: var(--clsu-green);" id="applyFilterBtn">Apply Filter</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
// ==========================================
// Details Modal
// ==========================================
document.querySelectorAll('.btn-details-req').forEach(button => {
  button.addEventListener('click', function() {
    document.getElementById('detailReqId').textContent = this.dataset.id;
    document.getElementById('detailName').textContent = this.dataset.name;
    document.getElementById('detailRole').textContent = this.dataset.role;
    document.getElementById('detailItems').textContent = this.dataset.items;
    document.getElementById('detailDate').textContent = this.dataset.date;
    document.getElementById('detailPurpose').textContent = this.dataset.purpose;
    document.getElementById('detailEmail').textContent = this.dataset.contact;
    document.getElementById('detailPhone').textContent = this.dataset.phone;
    document.getElementById('detailNotes').textContent = this.dataset.notes;

    // Status badge
    const statusBadge = document.getElementById('detailStatus');
    statusBadge.textContent = this.dataset.status;
    statusBadge.className = 'badge';
    if (this.dataset.status === 'Pending') {
      statusBadge.classList.add('bg-warning');
    } else if (this.dataset.status === 'Processing') {
      statusBadge.classList.add('bg-info');
    } else if (this.dataset.status === 'Completed') {
      statusBadge.style.background = 'var(--clsu-green)';
      statusBadge.classList.add('text-white');
    }

    const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
    modal.show();
  });
});

// ==========================================
// Approve Modal
// ==========================================
let approveTargetRow = null;
document.querySelectorAll('.btn-approve-req').forEach(button => {
  button.addEventListener('click', function() {
    approveTargetRow = this.closest('tr');
    document.getElementById('approveReqName').textContent = this.dataset.name + ' (' + this.dataset.id + ')';
    document.getElementById('approveReqItems').textContent = 'Items: ' + this.dataset.items;
    document.getElementById('approveNote').value = '';

    const modal = new bootstrap.Modal(document.getElementById('approveModal'));
    modal.show();
  });
});

document.getElementById('confirmApproveBtn').addEventListener('click', function() {
  if (approveTargetRow) {
    const reqId = approveTargetRow.dataset.requestId;
    
    // Update status badge
    const statusCell = approveTargetRow.querySelectorAll('td')[4];
    statusCell.innerHTML = '<span class="badge bg-info">Processing</span>';
    
    // Replace Approve button with Complete button
    const approveBtn = approveTargetRow.querySelector('.btn-approve-req');
    if (approveBtn) {
      approveBtn.textContent = 'Complete';
      approveBtn.classList.remove('btn-approve-req');
      approveBtn.classList.add('btn-complete-req');
      approveBtn.style.background = 'var(--clsu-gold)';
      
      // Re-bind as Complete button
      approveBtn.addEventListener('click', function() {
        completeTargetRow = this.closest('tr');
        document.getElementById('completeReqName').textContent = this.dataset.name + ' (' + this.dataset.id + ')';
        document.getElementById('completeReqItems').textContent = 'Items: ' + this.dataset.items;
        document.getElementById('completeNote').value = '';
        const modal = new bootstrap.Modal(document.getElementById('completeModal'));
        modal.show();
      });
    }

    // Update details button status
    const detailsBtn = approveTargetRow.querySelector('.btn-details-req');
    if (detailsBtn) detailsBtn.dataset.status = 'Processing';

    // Close modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('approveModal'));
    modal.hide();

    // TODO: Send to backend
    const note = document.getElementById('approveNote').value;
    console.log(`Approved ${reqId}`, { note });
    alert(`Request ${reqId} approved and now processing!`);
    
    approveTargetRow = null;
  }
});

// ==========================================
// Complete Modal
// ==========================================
let completeTargetRow = null;
document.querySelectorAll('.btn-complete-req').forEach(button => {
  button.addEventListener('click', function() {
    completeTargetRow = this.closest('tr');
    document.getElementById('completeReqName').textContent = this.dataset.name + ' (' + this.dataset.id + ')';
    document.getElementById('completeReqItems').textContent = 'Items: ' + this.dataset.items;
    document.getElementById('completeNote').value = '';

    const modal = new bootstrap.Modal(document.getElementById('completeModal'));
    modal.show();
  });
});

document.getElementById('confirmCompleteBtn').addEventListener('click', function() {
  if (completeTargetRow) {
    const reqId = completeTargetRow.dataset.requestId;
    
    // Update status badge
    const statusCell = completeTargetRow.querySelectorAll('td')[4];
    statusCell.innerHTML = '<span class="badge text-white" style="background: var(--clsu-green);">Completed</span>';
    
    // Remove the Complete button (only Details remains)
    const completeBtn = completeTargetRow.querySelector('.btn-complete-req');
    if (completeBtn) completeBtn.remove();

    // Update details button status
    const detailsBtn = completeTargetRow.querySelector('.btn-details-req');
    if (detailsBtn) detailsBtn.dataset.status = 'Completed';

    // Close modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('completeModal'));
    modal.hide();

    // TODO: Send to backend
    const note = document.getElementById('completeNote').value;
    const method = document.getElementById('releaseMethod').value;
    console.log(`Completed ${reqId}`, { note, method });
    alert(`Request ${reqId} marked as completed!`);
    
    completeTargetRow = null;
  }
});

// ==========================================
// Filter & Export
// ==========================================
document.getElementById('applyFilterBtn')?.addEventListener('click', function() {
  const status = document.getElementById('filterStatus').value;
  const type = document.getElementById('filterType').value;

  document.querySelectorAll('tbody tr').forEach(row => {
    const rowStatus = row.querySelector('.badge')?.textContent.toLowerCase() || '';
    const rowType = row.querySelector('small.text-muted')?.textContent.toLowerCase() || '';

    let show = true;
    if (status !== 'all' && !rowStatus.includes(status)) show = false;
    if (type !== 'all' && !rowType.includes(type)) show = false;

    row.style.display = show ? '' : 'none';
  });

  const modal = bootstrap.Modal.getInstance(document.getElementById('filterModal'));
  modal.hide();
});

document.getElementById('resetFilterBtn')?.addEventListener('click', function() {
  document.getElementById('filterStatus').value = 'all';
  document.getElementById('filterType').value = 'all';
  document.getElementById('filterDateFrom').value = '';
  document.getElementById('filterDateTo').value = '';
  document.querySelectorAll('tbody tr').forEach(row => row.style.display = '');
});

document.getElementById('exportBtn')?.addEventListener('click', function() {
  // Build CSV from table data
  const rows = document.querySelectorAll('table tbody tr');
  let csv = 'Request ID,Requester,Items Requested,Date,Status\n';
  
  rows.forEach(row => {
    if (row.style.display === 'none') return;
    const cells = row.querySelectorAll('td');
    const reqId = cells[0]?.textContent.trim();
    const name = cells[1]?.querySelector('.fw-bold')?.textContent.trim();
    const items = cells[2]?.textContent.trim();
    const date = cells[3]?.textContent.trim();
    const status = cells[4]?.querySelector('.badge')?.textContent.trim();
    csv += `"${reqId}","${name}","${items}","${date}","${status}"\n`;
  });

  // Download CSV
  const blob = new Blob([csv], { type: 'text/csv' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = 'rmo_requests_export.csv';
  a.click();
  URL.revokeObjectURL(url);
});
</script>
@endsection
