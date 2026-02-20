@extends('admin.pmo-layout')

@section('title', 'Order Tracking')
@section('crumb', 'Order Tracking')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <img src="/images/clsu-logo-green.png" alt="CLSU Seal" style="width:56px;height:56px;border-radius:14px;background:#fff;border:2px solid var(--clsu-green);object-fit:contain;">
    <div>
      <h1 class="h3 fw-bold mb-1">Order Tracking</h1>
      <div class="text-muted">Track and manage procurement orders</div>
    </div>
  </div>
  <button class="btn text-white rounded-4" style="background: var(--clsu-green);" data-bs-toggle="modal" data-bs-target="#newRequestModal">
    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" class="me-2"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
    New Order
  </button>
</div>

<div class="row g-3">
  <div class="col-md-3">
    <div class="card rounded-4">
      <div class="card-body">
        <h6 class="text-muted mb-1">Total Orders</h6>
        <h2 class="mb-0 fw-bold" style="color: var(--clsu-green);">{{ $stats['total'] }}</h2>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4">
      <div class="card-body">
        <h6 class="text-muted mb-1">Pending</h6>
        <h2 class="mb-0 fw-bold" style="color: var(--clsu-gold);">{{ $stats['pending'] }}</h2>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4">
      <div class="card-body">
        <h6 class="text-muted mb-1">In Progress</h6>
        <h2 class="mb-0 fw-bold text-info">{{ $stats['in_progress'] }}</h2>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4">
      <div class="card-body">
        <h6 class="text-muted mb-1">Delivered</h6>
        <h2 class="mb-0 fw-bold text-success">{{ $stats['completed'] }}</h2>
      </div>
    </div>
  </div>
</div>

<div class="card mt-3 rounded-4">
  <div class="card-body">
    <h5 class="card-title mb-3 fw-bold">Recent Procurement Orders</h5>
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="bg-light">
          <tr>
            <th class="py-3">Order ID</th>
            <th class="py-3">Supplier</th>
            <th class="py-3">Description</th>
            <th class="py-3">Priority</th>
            <th class="py-3">Status</th>
            <th class="py-3 text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($maintenanceRequests as $req)
          @php
            $priorityLabels = ['high' => 'High', 'medium' => 'Medium', 'low' => 'Low'];
            $priorityColors = ['high' => 'bg-danger', 'medium' => '', 'low' => 'bg-success'];
            $statusLabels = ['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed', 'on_hold' => 'On Hold'];
            $statusColors = ['pending' => 'bg-warning text-dark', 'in_progress' => 'bg-info', 'completed' => '', 'on_hold' => 'bg-secondary'];
            $teamLabels = ['plumbing' => 'Plumbing Team', 'electrical' => 'Electrical Team', 'hvac' => 'HVAC Team', 'carpentry' => 'Carpentry Team', 'general' => 'General Maintenance Crew'];
          @endphp
          <tr>
            <td class="py-3 font-monospace">{{ $req->request_id }}</td>
            <td class="py-3">{{ $req->location }}</td>
            <td class="py-3 fw-semibold">{{ $req->issue }}</td>
            <td class="py-3">
              <span class="badge {{ $priorityColors[$req->priority] ?? 'bg-secondary' }}" @if($req->priority === 'medium') style="background: var(--clsu-gold);" @endif>{{ $priorityLabels[$req->priority] ?? ucfirst($req->priority) }}</span>
            </td>
            <td class="py-3">
              <span class="badge {{ $statusColors[$req->status] ?? 'bg-secondary' }}" @if($req->status === 'completed') style="background: var(--clsu-green);" @endif>{{ $statusLabels[$req->status] ?? ucfirst($req->status) }}</span>
            </td>
            <td class="py-3 text-end">
              <div class="btn-group btn-group-sm">
                <button class="btn btn-sm btn-view-mnt" style="color: var(--clsu-green); border-color: var(--clsu-green);"
                  data-id="{{ $req->request_id }}"
                  data-db-id="{{ $req->id }}"
                  data-location="{{ $req->location }}"
                  data-issue="{{ $req->issue }}"
                  data-priority="{{ $priorityLabels[$req->priority] ?? ucfirst($req->priority) }}"
                  data-status="{{ $statusLabels[$req->status] ?? ucfirst($req->status) }}"
                  data-reporter="{{ $req->reporter ?? 'N/A' }}"
                  data-date="{{ $req->created_at->format('M d, Y') }}"
                  data-desc="{{ $req->description ?? 'No description provided.' }}"
                  data-assignee="{{ $req->assigned_to ? ($teamLabels[$req->assigned_to] ?? $req->assigned_to) : 'Not yet assigned' }}">View</button>
                @if($req->status === 'pending')
                <button class="btn btn-sm btn-assign-mnt text-white" style="background: var(--clsu-green);"
                  data-db-id="{{ $req->id }}"
                  data-issue="{{ $req->issue }}"
                  data-location="{{ $req->location }}">Assign</button>
                @elseif($req->status !== 'completed')
                <button class="btn btn-sm btn-update-mnt text-white" style="background: var(--clsu-gold);"
                  data-db-id="{{ $req->id }}"
                  data-issue="{{ $req->issue }}"
                  data-location="{{ $req->location }}">Update</button>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-4 text-muted">No procurement orders found. Click "New Order" to get started.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- View Details Modal -->
<div class="modal fade" id="viewMntModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Order Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label text-muted small">Order ID</label>
            <div class="fw-bold font-monospace" id="viewId"></div>
          </div>
          <div class="col-md-3">
            <label class="form-label text-muted small">Priority</label>
            <div><span id="viewPriority" class="badge"></span></div>
          </div>
          <div class="col-md-3">
            <label class="form-label text-muted small">Status</label>
            <div><span id="viewStatus" class="badge"></span></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Supplier</label>
            <div class="fw-semibold" id="viewLocation"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Order Date</label>
            <div class="fw-semibold" id="viewDate"></div>
          </div>
          <div class="col-12">
            <label class="form-label text-muted small">Item Description</label>
            <div class="fw-bold" id="viewIssue"></div>
          </div>
          <div class="col-12">
            <label class="form-label text-muted small">Description</label>
            <div class="p-3 bg-light rounded-3" id="viewDesc"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Ordered By</label>
            <div class="fw-semibold" id="viewReporter"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Assigned To</label>
            <div class="fw-semibold" id="viewAssignee"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn rounded-3" style="color: var(--clsu-green); border-color: var(--clsu-green);" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Assign Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Assign Procurement Handler</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" id="assignDbId">
        <p class="mb-1 text-muted small">Assigning for:</p>
        <p class="fw-bold mb-0" id="assignIssue"></p>
        <p class="text-muted small" id="assignLocation"></p>
        <div class="mb-3 mt-3">
          <label class="form-label fw-bold">Assign To <span class="text-danger">*</span></label>
          <select class="form-select rounded-3" id="assignTeam" required>
            <option value="">Select team/personnel</option>
            <option value="plumbing">Procurement Team A</option>
            <option value="electrical">Procurement Team B</option>
            <option value="hvac">Logistics Team</option>
            <option value="carpentry">Receiving Team</option>
            <option value="general">General Operations</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Expected Delivery Date</label>
          <input type="date" class="form-control rounded-3" id="assignDate">
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Notes</label>
          <textarea class="form-control rounded-3" id="assignNotes" rows="2" placeholder="Special instructions..."></textarea>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 justify-content-center">
        <button type="button" class="btn rounded-3 px-4" style="color: var(--clsu-gold); border-color: var(--clsu-gold);" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn rounded-3 px-4 text-white" style="background: var(--clsu-green);" id="confirmAssignBtn">Assign Handler</button>
      </div>
    </div>
  </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Update Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" id="updateDbId">
        <p class="mb-1 text-muted small">Updating:</p>
        <p class="fw-bold mb-0" id="updateIssue"></p>
        <p class="text-muted small" id="updateLocation"></p>
        <div class="mb-3 mt-3">
          <label class="form-label fw-bold">New Status <span class="text-danger">*</span></label>
          <select class="form-select rounded-3" id="updateStatus" required>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
            <option value="on_hold">On Hold</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Progress Update</label>
          <textarea class="form-control rounded-3" id="updateNotes" rows="3" placeholder="Describe what was done..."></textarea>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 justify-content-center">
        <button type="button" class="btn rounded-3 px-4" style="color: var(--clsu-gold); border-color: var(--clsu-gold);" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn rounded-3 px-4 text-white" style="background: var(--clsu-green);" id="confirmUpdateBtn">Update Status</button>
      </div>
    </div>
  </div>
</div>

<!-- New Request Modal -->
<div class="modal fade" id="newRequestModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">New Procurement Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form id="newRequestForm">
          <div class="row g-3">
            <div class="col-md-12 mb-2">
              <label class="form-label fw-bold">Order ID</label>
              <input type="text" class="form-control rounded-3 font-monospace fw-bold" id="newRequestId" readonly style="background-color: #f0f7f0; cursor: default; letter-spacing: 1px;">
              <small class="text-muted"><em>Auto-generated</em></small>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Item Description <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3" id="newIssue" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Supplier <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3" id="newLocation" placeholder="Supplier Name" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Priority</label>
              <select class="form-select rounded-3" id="newPriority">
                <option value="low">Low</option>
                <option value="medium" selected>Medium</option>
                <option value="high">High</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Reporter</label>
              <input type="text" class="form-control rounded-3" id="newReporter">
            </div>
            <div class="col-12">
              <label class="form-label fw-bold">Description</label>
              <textarea class="form-control rounded-3" id="newDesc" rows="3"></textarea>
            </div>
          </div>
          <div class="d-flex gap-2 justify-content-end mt-4">
            <button type="button" class="btn rounded-4 px-4" style="color: var(--clsu-gold); border-color: var(--clsu-gold);" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn rounded-4 px-4 text-white" style="background: var(--clsu-green);">Submit Request</button>
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
// Auto-Generate Request ID
// ==========================================
let mntCounter = 1;

(function initMntCounter() {
  document.querySelectorAll('table tbody tr td.font-monospace').forEach(cell => {
    const text = cell.textContent.trim();
    const match = text.match(/^#MNT-(\d{4})-(\d+)$/);
    if (match) {
      const num = parseInt(match[2], 10);
      if (num >= mntCounter) {
        mntCounter = num + 1;
      }
    }
  });
})();

function generateRequestId() {
  const year = new Date().getFullYear();
  const num = String(mntCounter).padStart(3, '0');
  return `#MNT-${year}-${num}`;
}

document.getElementById('newRequestModal').addEventListener('show.bs.modal', function() {
  document.getElementById('newRequestForm').reset();
  document.getElementById('newRequestId').value = generateRequestId();
});

// ==========================================
// View Details
// ==========================================
document.querySelectorAll('.btn-view-mnt').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('viewId').textContent = this.dataset.id;
    document.getElementById('viewLocation').textContent = this.dataset.location;
    document.getElementById('viewIssue').textContent = this.dataset.issue;
    document.getElementById('viewDate').textContent = this.dataset.date;
    document.getElementById('viewDesc').textContent = this.dataset.desc;
    document.getElementById('viewReporter').textContent = this.dataset.reporter;
    document.getElementById('viewAssignee').textContent = this.dataset.assignee;

    const prBadge = document.getElementById('viewPriority');
    prBadge.textContent = this.dataset.priority;
    prBadge.className = 'badge';
    prBadge.removeAttribute('style');
    if (this.dataset.priority === 'High') prBadge.classList.add('bg-danger');
    else if (this.dataset.priority === 'Medium') { prBadge.style.background = 'var(--clsu-gold)'; prBadge.classList.add('text-white'); }
    else prBadge.classList.add('bg-success');

    const stBadge = document.getElementById('viewStatus');
    stBadge.textContent = this.dataset.status;
    stBadge.className = 'badge';
    stBadge.removeAttribute('style');
    if (this.dataset.status === 'Pending') stBadge.classList.add('bg-warning', 'text-dark');
    else if (this.dataset.status === 'In Progress') stBadge.classList.add('bg-info');
    else if (this.dataset.status === 'On Hold') stBadge.classList.add('bg-secondary');
    else { stBadge.style.background = 'var(--clsu-green)'; stBadge.classList.add('text-white'); }

    new bootstrap.Modal(document.getElementById('viewMntModal')).show();
  });
});

// ==========================================
// Assign (AJAX)
// ==========================================
document.querySelectorAll('.btn-assign-mnt').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('assignDbId').value = this.dataset.dbId;
    document.getElementById('assignIssue').textContent = this.dataset.issue;
    document.getElementById('assignLocation').textContent = this.dataset.location;
    document.getElementById('assignTeam').value = '';
    document.getElementById('assignNotes').value = '';
    document.getElementById('assignDate').value = '';
    new bootstrap.Modal(document.getElementById('assignModal')).show();
  });
});

document.getElementById('confirmAssignBtn').addEventListener('click', function() {
  const team = document.getElementById('assignTeam').value;
  if (!team) { alert('Please select a team.'); return; }

  const id = document.getElementById('assignDbId').value;
  this.disabled = true;
  this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Assigning...';

  fetch(`/pmo/maintenance/${id}/assign`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    body: JSON.stringify({
      assigned_to: team,
      target_date: document.getElementById('assignDate').value || null,
      assigned_notes: document.getElementById('assignNotes').value,
    })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      location.reload();
    } else {
      alert('Error: ' + (data.message || 'Something went wrong'));
      this.disabled = false;
      this.innerHTML = 'Assign Team';
    }
  })
  .catch(err => {
    console.error(err);
    alert('An error occurred. Please try again.');
    this.disabled = false;
    this.innerHTML = 'Assign Team';
  });
});

// ==========================================
// Update Status (AJAX)
// ==========================================
document.querySelectorAll('.btn-update-mnt').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('updateDbId').value = this.dataset.dbId;
    document.getElementById('updateIssue').textContent = this.dataset.issue;
    document.getElementById('updateLocation').textContent = this.dataset.location;
    document.getElementById('updateNotes').value = '';
    new bootstrap.Modal(document.getElementById('updateModal')).show();
  });
});

document.getElementById('confirmUpdateBtn').addEventListener('click', function() {
  const id = document.getElementById('updateDbId').value;
  this.disabled = true;
  this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Updating...';

  fetch(`/pmo/maintenance/${id}/status`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    body: JSON.stringify({
      status: document.getElementById('updateStatus').value,
      progress_notes: document.getElementById('updateNotes').value,
    })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      location.reload();
    } else {
      alert('Error: ' + (data.message || 'Something went wrong'));
      this.disabled = false;
      this.innerHTML = 'Update Status';
    }
  })
  .catch(err => {
    console.error(err);
    alert('An error occurred. Please try again.');
    this.disabled = false;
    this.innerHTML = 'Update Status';
  });
});

// ==========================================
// New Request (AJAX)
// ==========================================
document.getElementById('newRequestForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const btn = this.querySelector('[type="submit"]');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Submitting...';

  fetch("{{ route('pmo.maintenance.store') }}", {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    body: JSON.stringify({
      request_id: document.getElementById('newRequestId').value,
      issue: document.getElementById('newIssue').value,
      location: document.getElementById('newLocation').value,
      priority: document.getElementById('newPriority').value,
      reporter: document.getElementById('newReporter').value,
      description: document.getElementById('newDesc').value,
    })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      location.reload();
    } else {
      alert('Error: ' + (data.message || 'Something went wrong'));
      btn.disabled = false;
      btn.innerHTML = 'Submit Request';
    }
  })
  .catch(err => {
    console.error(err);
    alert('An error occurred. Please try again.');
    btn.disabled = false;
    btn.innerHTML = 'Submit Request';
  });
});
</script>
@endsection
