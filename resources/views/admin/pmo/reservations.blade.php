@extends('admin.pmo-layout')

@section('title', 'Bid Management')
@section('crumb', 'Bid Management')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <img src="/images/clsu-logo-green.png" alt="CLSU Seal" style="width:56px;height:56px;border-radius:14px;background:#fff;border:2px solid var(--clsu-green);object-fit:contain;">
    <div>
      <h1 class="h3 fw-bold mb-1">Bid Management</h1>
      <div class="text-muted">Manage bids, canvassing, and procurement evaluations</div>
    </div>
  </div>
  <button class="btn text-white rounded-4" style="background: var(--clsu-green);" data-bs-toggle="modal" data-bs-target="#newReservationModal">
    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" class="me-2"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
    New Bid
  </button>
</div>

<div class="row g-3">
  <div class="col-md-3">
    <div class="card rounded-4">
      <div class="card-body">
        <h6 class="text-muted mb-1">Total Bids</h6>
        <h2 class="mb-0 fw-bold" style="color: var(--clsu-green);">{{ $stats['total'] }}</h2>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4">
      <div class="card-body">
        <h6 class="text-muted mb-1">Pending Evaluation</h6>
        <h2 class="mb-0 fw-bold" style="color: var(--clsu-gold);">{{ $stats['pending'] }}</h2>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4">
      <div class="card-body">
        <h6 class="text-muted mb-1">Awarded</h6>
        <h2 class="mb-0 fw-bold text-success">{{ $stats['approved'] }}</h2>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4">
      <div class="card-body">
        <h6 class="text-muted mb-1">This Week</h6>
        <h2 class="mb-0 fw-bold text-info">{{ $stats['this_week'] }}</h2>
      </div>
    </div>
  </div>
</div>

<div class="card mt-3 rounded-4">
  <div class="card-body">
    <h5 class="card-title mb-3 fw-bold">Recent Bids</h5>
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="bg-light">
          <tr>
            <th class="py-3">Bid ID</th>
            <th class="py-3">Project/Item</th>
            <th class="py-3">Bidder</th>
            <th class="py-3">Date & Time</th>
            <th class="py-3">Status</th>
            <th class="py-3 text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($reservations as $res)
          @php
            $statusLabels = ['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'cancelled' => 'Cancelled'];
            $statusColors = ['pending' => 'bg-warning text-dark', 'approved' => '', 'rejected' => 'bg-danger', 'cancelled' => 'bg-secondary'];
            $dateTime = $res->reservation_date->format('M d, Y') . ' - ' . \Carbon\Carbon::parse($res->start_time)->format('g:i A');
            $fullDateTime = $res->reservation_date->format('M d, Y') . ' - ' . \Carbon\Carbon::parse($res->start_time)->format('g:i A') . ' to ' . \Carbon\Carbon::parse($res->end_time)->format('g:i A');
          @endphp
          <tr>
            <td class="py-3 font-monospace">{{ $res->reservation_id }}</td>
            <td class="py-3 fw-semibold">{{ $res->facility }}</td>
            <td class="py-3">{{ $res->requester }}</td>
            <td class="py-3">{{ $dateTime }}</td>
            <td class="py-3">
              <span class="badge {{ $statusColors[$res->status] ?? 'bg-secondary' }}" @if($res->status === 'approved') style="background: var(--clsu-green);" @endif>{{ $statusLabels[$res->status] ?? ucfirst($res->status) }}</span>
            </td>
            <td class="py-3 text-end">
              <div class="btn-group btn-group-sm">
                <button class="btn btn-sm btn-view-res" style="color: var(--clsu-green); border-color: var(--clsu-green);"
                  data-id="{{ $res->reservation_id }}"
                  data-db-id="{{ $res->id }}"
                  data-facility="{{ $res->facility }}"
                  data-requester="{{ $res->requester }}"
                  data-dept="{{ $res->department ?? 'N/A' }}"
                  data-datetime="{{ $fullDateTime }}"
                  data-status="{{ $statusLabels[$res->status] ?? ucfirst($res->status) }}"
                  data-purpose="{{ $res->purpose ?? 'N/A' }}"
                  data-attendees="{{ $res->attendees ?? 'N/A' }}"
                  data-equipment="{{ $res->equipment_needed ?? 'N/A' }}"
                  data-notes="{{ $res->notes ?? 'N/A' }}">View</button>
                @if($res->status === 'pending')
                <button class="btn btn-sm btn-approve-res text-white" style="background: var(--clsu-green);"
                  data-db-id="{{ $res->id }}"
                  data-facility="{{ $res->facility }}"
                  data-requester="{{ $res->requester }}"
                  data-datetime="{{ $dateTime }}">Approve</button>
                <button class="btn btn-sm btn-reject-res" style="color: #dc3545; border-color: #dc3545;"
                  data-db-id="{{ $res->id }}"
                  data-facility="{{ $res->facility }}"
                  data-requester="{{ $res->requester }}">Reject</button>
                @elseif($res->status === 'approved')
                <button class="btn btn-sm btn-cancel-res" style="color: #dc3545; border-color: #dc3545;"
                  data-db-id="{{ $res->id }}"
                  data-facility="{{ $res->facility }}"
                  data-requester="{{ $res->requester }}">Cancel</button>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-4 text-muted">No bids found. Click "New Bid" to get started.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- View Details Modal -->
<div class="modal fade" id="viewResModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Bid Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label text-muted small">Bid ID</label>
            <div class="fw-bold font-monospace" id="viewResId"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Status</label>
            <div><span id="viewResStatus" class="badge"></span></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Project/Item</label>
            <div class="fw-bold" id="viewResFacility"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Date & Time</label>
            <div class="fw-semibold" id="viewResDatetime"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Bidder</label>
            <div class="fw-semibold" id="viewResRequester"></div>
            <small class="text-muted" id="viewResDept"></small>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Bid Amount</label>
            <div class="fw-semibold" id="viewResAttendees"></div>
          </div>
          <div class="col-12">
            <label class="form-label text-muted small">Purpose</label>
            <div class="fw-semibold" id="viewResPurpose"></div>
          </div>
          <div class="col-12">
            <label class="form-label text-muted small">Specifications</label>
            <div class="fw-semibold" id="viewResEquipment"></div>
          </div>
          <div class="col-12">
            <label class="form-label text-muted small">Notes</label>
            <div class="p-3 bg-light rounded-3" id="viewResNotes"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn rounded-3" style="color: var(--clsu-green); border-color: var(--clsu-green);" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveResModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Award Bid</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" id="approveDbId">
        <div class="text-center mb-3">
          <svg width="48" height="48" viewBox="0 0 24 24" fill="var(--clsu-green)">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
          </svg>
        </div>
        <p class="text-center mb-1">Award this bid?</p>
        <p class="text-center fw-bold" id="approveResFacility"></p>
        <p class="text-center text-muted small" id="approveResInfo"></p>
        <div class="mb-3">
          <label class="form-label fw-bold small">Note to Requester (Optional)</label>
          <textarea class="form-control rounded-3" id="approveResNote" rows="2" placeholder="e.g. Setup available 30 min before..."></textarea>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 justify-content-center">
        <button type="button" class="btn rounded-3 px-4" style="color: var(--clsu-gold); border-color: var(--clsu-gold);" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn rounded-3 px-4 text-white" style="background: var(--clsu-green);" id="confirmApproveRes">Award</button>
      </div>
    </div>
  </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectResModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Reject Bid</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" id="rejectDbId">
        <div class="text-center mb-3">
          <svg width="48" height="48" fill="#dc3545" viewBox="0 0 24 24">
            <path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/>
          </svg>
        </div>
        <p class="text-center mb-1">Reject this bid?</p>
        <p class="text-center fw-bold" id="rejectResFacility"></p>
        <div class="mb-3">
          <label class="form-label fw-bold small">Reason for Rejection <span class="text-danger">*</span></label>
          <select class="form-select rounded-3" id="rejectReason">
            <option value="">Select reason</option>
            <option value="conflict">Does not meet specifications</option>
            <option value="maintenance">Over budget</option>
            <option value="incomplete">Incomplete request</option>
            <option value="other">Other</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold small">Additional Remarks</label>
          <textarea class="form-control rounded-3" id="rejectResNote" rows="2"></textarea>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 justify-content-center">
        <button type="button" class="btn rounded-3 px-4" style="color: var(--clsu-green); border-color: var(--clsu-green);" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn rounded-3 px-4 text-white" style="background: #dc3545;" id="confirmRejectRes">Reject</button>
      </div>
    </div>
  </div>
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelResModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Cancel Bid</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" id="cancelDbId">
        <div class="text-center mb-3">
          <svg width="48" height="48" fill="#dc3545" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
          </svg>
        </div>
        <p class="text-center mb-1">Cancel this awarded bid?</p>
        <p class="text-center fw-bold" id="cancelResFacility"></p>
        <div class="mb-3">
          <label class="form-label fw-bold small">Reason for Cancellation</label>
          <textarea class="form-control rounded-3" id="cancelResNote" rows="2"></textarea>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 justify-content-center">
        <button type="button" class="btn rounded-3 px-4" style="color: var(--clsu-green); border-color: var(--clsu-green);" data-bs-dismiss="modal">Keep</button>
        <button type="button" class="btn rounded-3 px-4 text-white" style="background: #dc3545;" id="confirmCancelRes">Cancel Bid</button>
      </div>
    </div>
  </div>
</div>

<!-- New Reservation Modal -->
<div class="modal fade" id="newReservationModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">New Bid</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form id="newReservationForm">
          <div class="row g-3">
            <div class="col-md-12 mb-2">
              <label class="form-label fw-bold">Bid ID</label>
              <input type="text" class="form-control rounded-3 font-monospace fw-bold" id="newResId" readonly style="background-color: #f0f7f0; cursor: default; letter-spacing: 1px;">
              <small class="text-muted"><em>Auto-generated</em></small>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Project/Item <span class="text-danger">*</span></label>
              <select class="form-select rounded-3" id="newFacility" required>
                <option value="">Select project</option>
                <option value="Office Supplies">Office Supplies</option>
                <option value="IT Equipment">IT Equipment</option>
                <option value="Laboratory Equipment">Laboratory Equipment</option>
                <option value="Furniture">Furniture</option>
                <option value="Construction Materials">Construction Materials</option>
                <option value="Vehicles">Vehicles</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Bidder <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3" id="newRequester" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Department</label>
              <input type="text" class="form-control rounded-3" id="newDepartment" placeholder="e.g. College of Science">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Date <span class="text-danger">*</span></label>
              <input type="date" class="form-control rounded-3" id="newDate" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Start Time <span class="text-danger">*</span></label>
              <input type="time" class="form-control rounded-3" id="newStartTime" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">End Time <span class="text-danger">*</span></label>
              <input type="time" class="form-control rounded-3" id="newEndTime" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Bid Amount</label>
              <input type="number" class="form-control rounded-3" id="newAttendees" min="1">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Purpose</label>
              <input type="text" class="form-control rounded-3" id="newPurpose">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Specifications</label>
              <input type="text" class="form-control rounded-3" id="newEquipment" placeholder="e.g. Brand, Model, Warranty">
            </div>
            <div class="col-12">
              <label class="form-label fw-bold">Notes</label>
              <textarea class="form-control rounded-3" id="newResNotes" rows="2"></textarea>
            </div>
          </div>
          <div class="d-flex gap-2 justify-content-end mt-4">
            <button type="button" class="btn rounded-4 px-4" style="color: var(--clsu-gold); border-color: var(--clsu-gold);" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn rounded-4 px-4 text-white" style="background: var(--clsu-green);">Submit Reservation</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// ==========================================
// Auto-Generate Reservation ID
// ==========================================
let resCounter = 1;

(function initResCounter() {
  document.querySelectorAll('table tbody tr td.font-monospace').forEach(cell => {
    const text = cell.textContent.trim();
    const match = text.match(/^#RES-(\d{4})-(\d+)$/);
    if (match) {
      const num = parseInt(match[2], 10);
      if (num >= resCounter) {
        resCounter = num + 1;
      }
    }
  });
})();

function generateResId() {
  const year = new Date().getFullYear();
  const num = String(resCounter).padStart(3, '0');
  return `#RES-${year}-${num}`;
}

document.getElementById('newReservationModal').addEventListener('show.bs.modal', function() {
  document.getElementById('newReservationForm').reset();
  document.getElementById('newResId').value = generateResId();
});

// ==========================================
// View Details
// ==========================================
document.querySelectorAll('.btn-view-res').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('viewResId').textContent = this.dataset.id;
    document.getElementById('viewResFacility').textContent = this.dataset.facility;
    document.getElementById('viewResDatetime').textContent = this.dataset.datetime;
    document.getElementById('viewResRequester').textContent = this.dataset.requester;
    document.getElementById('viewResDept').textContent = this.dataset.dept;
    document.getElementById('viewResPurpose').textContent = this.dataset.purpose;
    document.getElementById('viewResAttendees').textContent = (this.dataset.attendees && this.dataset.attendees !== 'N/A') ? this.dataset.attendees + ' people' : 'N/A';
    document.getElementById('viewResEquipment').textContent = this.dataset.equipment;
    document.getElementById('viewResNotes').textContent = this.dataset.notes;

    const stBadge = document.getElementById('viewResStatus');
    stBadge.textContent = this.dataset.status;
    stBadge.className = 'badge';
    stBadge.removeAttribute('style');
    if (this.dataset.status === 'Pending') stBadge.classList.add('bg-warning', 'text-dark');
    else if (this.dataset.status === 'Approved') { stBadge.style.background = 'var(--clsu-green)'; stBadge.classList.add('text-white'); }
    else if (this.dataset.status === 'Rejected') stBadge.classList.add('bg-danger');
    else stBadge.classList.add('bg-secondary');

    new bootstrap.Modal(document.getElementById('viewResModal')).show();
  });
});

// ==========================================
// Approve (AJAX)
// ==========================================
document.querySelectorAll('.btn-approve-res').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('approveDbId').value = this.dataset.dbId;
    document.getElementById('approveResFacility').textContent = this.dataset.facility;
    document.getElementById('approveResInfo').textContent = `${this.dataset.requester} — ${this.dataset.datetime}`;
    document.getElementById('approveResNote').value = '';
    new bootstrap.Modal(document.getElementById('approveResModal')).show();
  });
});

document.getElementById('confirmApproveRes').addEventListener('click', function() {
  const id = document.getElementById('approveDbId').value;
  this.disabled = true;
  this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Approving...';

  fetch(`/pmo/reservations/${id}/approve`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    body: JSON.stringify({ admin_note: document.getElementById('approveResNote').value })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) { alert(data.message); location.reload(); }
    else { alert('Error: ' + (data.message || 'Something went wrong')); this.disabled = false; this.innerHTML = 'Approve'; }
  })
  .catch(err => { console.error(err); alert('An error occurred.'); this.disabled = false; this.innerHTML = 'Approve'; });
});

// ==========================================
// Reject (AJAX)
// ==========================================
document.querySelectorAll('.btn-reject-res').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('rejectDbId').value = this.dataset.dbId;
    document.getElementById('rejectResFacility').textContent = `${this.dataset.facility} — ${this.dataset.requester}`;
    document.getElementById('rejectReason').value = '';
    document.getElementById('rejectResNote').value = '';
    new bootstrap.Modal(document.getElementById('rejectResModal')).show();
  });
});

document.getElementById('confirmRejectRes').addEventListener('click', function() {
  const reason = document.getElementById('rejectReason').value;
  if (!reason) { alert('Please select a rejection reason.'); return; }

  const id = document.getElementById('rejectDbId').value;
  this.disabled = true;
  this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Rejecting...';

  fetch(`/pmo/reservations/${id}/reject`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    body: JSON.stringify({ reject_reason: reason, admin_note: document.getElementById('rejectResNote').value })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) { alert(data.message); location.reload(); }
    else { alert('Error: ' + (data.message || 'Something went wrong')); this.disabled = false; this.innerHTML = 'Reject'; }
  })
  .catch(err => { console.error(err); alert('An error occurred.'); this.disabled = false; this.innerHTML = 'Reject'; });
});

// ==========================================
// Cancel (AJAX)
// ==========================================
document.querySelectorAll('.btn-cancel-res').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('cancelDbId').value = this.dataset.dbId;
    document.getElementById('cancelResFacility').textContent = `${this.dataset.facility} — ${this.dataset.requester}`;
    document.getElementById('cancelResNote').value = '';
    new bootstrap.Modal(document.getElementById('cancelResModal')).show();
  });
});

document.getElementById('confirmCancelRes').addEventListener('click', function() {
  const id = document.getElementById('cancelDbId').value;
  this.disabled = true;
  this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Cancelling...';

  fetch(`/pmo/reservations/${id}/cancel`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    body: JSON.stringify({ admin_note: document.getElementById('cancelResNote').value })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) { alert(data.message); location.reload(); }
    else { alert('Error: ' + (data.message || 'Something went wrong')); this.disabled = false; this.innerHTML = 'Cancel Reservation'; }
  })
  .catch(err => { console.error(err); alert('An error occurred.'); this.disabled = false; this.innerHTML = 'Cancel Reservation'; });
});

// ==========================================
// New Reservation (AJAX)
// ==========================================
document.getElementById('newReservationForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const btn = this.querySelector('[type="submit"]');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Submitting...';

  fetch("{{ route('pmo.reservations.store') }}", {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    body: JSON.stringify({
      reservation_id: document.getElementById('newResId').value,
      facility: document.getElementById('newFacility').value,
      requester: document.getElementById('newRequester').value,
      department: document.getElementById('newDepartment').value,
      reservation_date: document.getElementById('newDate').value,
      start_time: document.getElementById('newStartTime').value,
      end_time: document.getElementById('newEndTime').value,
      purpose: document.getElementById('newPurpose').value,
      attendees: document.getElementById('newAttendees').value || null,
      equipment_needed: document.getElementById('newEquipment').value,
      notes: document.getElementById('newResNotes').value,
    })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) { alert(data.message); location.reload(); }
    else { alert('Error: ' + (data.message || 'Something went wrong')); btn.disabled = false; btn.innerHTML = 'Submit Reservation'; }
  })
  .catch(err => { console.error(err); alert('An error occurred.'); btn.disabled = false; btn.innerHTML = 'Submit Reservation'; });
});
</script>
@endsection
