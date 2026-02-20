@extends('admin.pmo-layout')

@section('title', 'Purchase Requests')
@section('crumb', 'Purchase Requests')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <img src="/images/clsu-logo-green.png" alt="CLSU Seal" style="width:56px;height:56px;border-radius:14px;background:#fff;border:2px solid var(--clsu-green);object-fit:contain;">
    <div>
      <h1 class="h3 fw-bold mb-1">Purchase Requests</h1>
      <div class="text-muted">Manage procurement purchase requests</div>
    </div>
  </div>
  <button class="btn text-white rounded-4" style="background: var(--clsu-green);" data-bs-toggle="modal" data-bs-target="#addBuildingModal">
    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" class="me-2">
      <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
    </svg>
    New Request
  </button>
</div>

<div class="row g-3">
  <div class="col-md-3">
    <div class="card rounded-4">
      <div class="card-body">
        <h6 class="text-muted mb-1">Total Requests</h6>
        <h2 class="mb-0 fw-bold" style="color: var(--clsu-green);">{{ $stats['total'] }}</h2>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4">
      <div class="card-body">
        <h6 class="text-muted mb-1">Approved</h6>
        <h2 class="mb-0 fw-bold text-success">{{ $stats['active'] }}</h2>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4">
      <div class="card-body">
        <h6 class="text-muted mb-1">Pending Review</h6>
        <h2 class="mb-0 fw-bold" style="color: var(--clsu-gold);">{{ $stats['maintenance'] }}</h2>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4">
      <div class="card-body">
        <h6 class="text-muted mb-1">Total Items</h6>
        <h2 class="mb-0 fw-bold">{{ $stats['total_rooms'] }}</h2>
      </div>
    </div>
  </div>
</div>

<div class="card mt-3 rounded-4">
  <div class="card-body">
    <h5 class="card-title mb-3 fw-bold">Purchase Request List</h5>
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="bg-light">
          <tr>
            <th class="py-3">Request Title</th>
            <th class="py-3">PR Number</th>
            <th class="py-3">Items</th>
            <th class="py-3">Amount</th>
            <th class="py-3">Status</th>
            <th class="py-3 text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($buildings as $bldg)
          @php
            $statusLabels = ['active' => 'Active', 'maintenance' => 'Under Maintenance', 'inactive' => 'Inactive'];
            $statusColors = ['active' => 'bg-success', 'maintenance' => 'bg-warning text-dark', 'inactive' => 'bg-secondary'];
          @endphp
          <tr>
            <td class="py-3 fw-semibold">{{ $bldg->name }}</td>
            <td class="py-3 font-monospace">{{ $bldg->code }}</td>
            <td class="py-3">{{ $bldg->rooms }}</td>
            <td class="py-3">{{ $bldg->floors }}</td>
            <td class="py-3"><span class="badge {{ $statusColors[$bldg->status] ?? 'bg-secondary' }}">{{ $statusLabels[$bldg->status] ?? ucfirst($bldg->status) }}</span></td>
            <td class="py-3 text-end">
              <div class="btn-group btn-group-sm">
                <button class="btn btn-sm btn-view-bldg" style="color: var(--clsu-green); border-color: var(--clsu-green);"
                  data-name="{{ $bldg->name }}"
                  data-code="{{ $bldg->code }}"
                  data-rooms="{{ $bldg->rooms }}"
                  data-floors="{{ $bldg->floors }}"
                  data-status="{{ $statusLabels[$bldg->status] ?? ucfirst($bldg->status) }}"
                  data-year="{{ $bldg->year_built ?? 'N/A' }}"
                  data-area="{{ $bldg->total_area ? number_format($bldg->total_area) . ' sqm' : 'N/A' }}"
                  data-manager="{{ $bldg->manager ?? 'N/A' }}"
                  data-notes="{{ $bldg->notes ?? 'No notes.' }}">View</button>
                <button class="btn btn-sm btn-edit-bldg" style="color: var(--clsu-gold); border-color: var(--clsu-gold);"
                  data-db-id="{{ $bldg->id }}"
                  data-name="{{ $bldg->name }}"
                  data-code="{{ $bldg->code }}"
                  data-rooms="{{ $bldg->rooms }}"
                  data-floors="{{ $bldg->floors }}"
                  data-status="{{ $bldg->status }}"
                  data-year="{{ $bldg->year_built }}"
                  data-area="{{ $bldg->total_area }}"
                  data-manager="{{ $bldg->manager }}"
                  data-notes="{{ $bldg->notes }}">Edit</button>
                <button class="btn btn-sm btn-delete-bldg" style="color: #dc3545; border-color: #dc3545;"
                  data-db-id="{{ $bldg->id }}"
                  data-name="{{ $bldg->name }}"
                  data-code="{{ $bldg->code }}">Delete</button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-4 text-muted">No purchase requests found. Click "New Request" to get started.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- View Building Modal -->
<div class="modal fade" id="viewBuildingModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Request Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row g-3">
          <div class="col-12">
            <h4 class="fw-bold mb-0" id="viewName"></h4>
          </div>
          <div class="col-md-4">
            <label class="form-label text-muted small">PR Number</label>
            <div class="fw-semibold font-monospace" id="viewCode"></div>
          </div>
          <div class="col-md-4">
            <label class="form-label text-muted small">Status</label>
            <div><span id="viewStatus" class="badge bg-success"></span></div>
          </div>
          <div class="col-md-4">
            <label class="form-label text-muted small">Year Built</label>
            <div class="fw-semibold" id="viewYear"></div>
          </div>
          <div class="col-md-4">
            <label class="form-label text-muted small">Quantity</label>
            <div class="fw-semibold" id="viewRooms"></div>
          </div>
          <div class="col-md-4">
            <label class="form-label text-muted small">Unit Price</label>
            <div class="fw-semibold" id="viewFloors"></div>
          </div>
          <div class="col-md-4">
            <label class="form-label text-muted small">Total Amount</label>
            <div class="fw-semibold" id="viewArea"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Requested By</label>
            <div class="fw-semibold" id="viewManager"></div>
          </div>
          <div class="col-12">
            <label class="form-label text-muted small">Notes</label>
            <div class="p-3 bg-light rounded-3" id="viewNotes"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn rounded-3" style="color: var(--clsu-green); border-color: var(--clsu-green);" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Building Modal -->
<div class="modal fade" id="addBuildingModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">New Purchase Request</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form id="addBuildingForm">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label fw-bold">Request Title <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3" id="addName" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">PR Number <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3 font-monospace fw-bold" id="addCode" readonly style="background-color: #f0f7f0; cursor: default; letter-spacing: 1px;">
              <small class="text-muted"><em>Auto-generated</em></small>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-bold">Quantity</label>
              <input type="number" class="form-control rounded-3" id="addRooms" min="0" value="0">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-bold">Unit Price</label>
              <input type="number" class="form-control rounded-3" id="addFloors" min="1" value="1">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-bold">Date Needed</label>
              <input type="number" class="form-control rounded-3" id="addYear" min="1900" max="2030">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-bold">Estimated Cost</label>
              <input type="number" class="form-control rounded-3" id="addArea" min="0">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Status</label>
              <select class="form-select rounded-3" id="addStatus">
                <option value="active">Active</option>
                <option value="maintenance">Under Maintenance</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
            <div class="col-md-8">
              <label class="form-label fw-bold">Requested By</label>
              <input type="text" class="form-control rounded-3" id="addManager">
            </div>
            <div class="col-12">
              <label class="form-label fw-bold">Notes</label>
              <textarea class="form-control rounded-3" id="addNotes" rows="2"></textarea>
            </div>
          </div>
          <div class="d-flex gap-2 justify-content-end mt-4">
            <button type="button" class="btn rounded-4 px-4" style="color: var(--clsu-gold); border-color: var(--clsu-gold);" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn rounded-4 px-4 text-white" style="background: var(--clsu-green);">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" class="me-1"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
              Submit Request
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Building Modal -->
<div class="modal fade" id="editBuildingModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Edit Request</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form id="editBuildingForm">
          <input type="hidden" id="editDbId">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label fw-bold">Request Title <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3" id="editName" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">PR Number <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3 font-monospace fw-bold" id="editCode" readonly style="background-color: #f0f7f0; cursor: default; letter-spacing: 1px;">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-bold">Quantity</label>
              <input type="number" class="form-control rounded-3" id="editRooms" min="0">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-bold">Unit Price</label>
              <input type="number" class="form-control rounded-3" id="editFloors" min="1">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-bold">Date Needed</label>
              <input type="number" class="form-control rounded-3" id="editYear" min="1900" max="2030">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-bold">Estimated Cost</label>
              <input type="number" class="form-control rounded-3" id="editArea" min="0">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Status</label>
              <select class="form-select rounded-3" id="editStatus">
                <option value="active">Active</option>
                <option value="maintenance">Under Maintenance</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
            <div class="col-md-8">
              <label class="form-label fw-bold">Requested By</label>
              <input type="text" class="form-control rounded-3" id="editManager">
            </div>
            <div class="col-12">
              <label class="form-label fw-bold">Notes</label>
              <textarea class="form-control rounded-3" id="editNotes" rows="2"></textarea>
            </div>
          </div>
          <div class="d-flex gap-2 justify-content-end mt-4">
            <button type="button" class="btn rounded-4 px-4" style="color: var(--clsu-gold); border-color: var(--clsu-gold);" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn rounded-4 px-4 text-white" style="background: var(--clsu-green);">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" class="me-1"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
              Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteBuildingModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Delete Request</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" id="deleteDbId">
        <div class="text-center mb-3">
          <svg width="48" height="48" fill="#dc3545" viewBox="0 0 24 24">
            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
          </svg>
        </div>
        <p class="text-center mb-1">Are you sure you want to delete this purchase request?</p>
        <p class="text-center fw-bold" id="deleteBldgName"></p>
        <p class="text-center text-muted small font-monospace" id="deleteBldgCode"></p>
        <div class="alert alert-warning rounded-3 small mt-3 mb-0">
          <strong>Warning:</strong> All associated records for this request will also be removed. This action cannot be undone.
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 justify-content-center">
        <button type="button" class="btn rounded-3 px-4" style="color: var(--clsu-green); border-color: var(--clsu-green);" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn rounded-3 px-4 text-white" style="background: #dc3545;" id="confirmDeleteBtn">Delete Request</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// ==========================================
// Auto-Generate Building Code from Name
// ==========================================
function generateBuildingCode(name) {
  if (!name || !name.trim()) return '';

  // Common abbreviation mappings
  const abbrevMap = {
    'administration': 'ADMIN',
    'engineering': 'ENGR',
    'science': 'SCI',
    'technology': 'TECH',
    'agriculture': 'AGRI',
    'education': 'EDUC',
    'library': 'LIB',
    'gymnasium': 'GYM',
    'auditorium': 'AUD',
    'laboratory': 'LAB',
    'building': '',
    'hall': 'HALL',
    'center': 'CTR',
    'college': 'COL',
    'institute': 'INST',
    'multi-purpose': 'MP',
    'multipurpose': 'MP',
    'conference': 'CONF',
    'dormitory': 'DORM',
    'cafeteria': 'CAF',
    'clinic': 'CLIN',
    'annex': 'ANX',
  };

  const words = name.trim().toLowerCase().split(/\s+/);
  let codeParts = [];

  for (const word of words) {
    if (abbrevMap.hasOwnProperty(word)) {
      if (abbrevMap[word]) codeParts.push(abbrevMap[word]);
    } else {
      // Use first 3-4 chars for unknown words
      codeParts.push(word.substring(0, Math.min(4, word.length)).toUpperCase());
    }
  }

  let baseCode = codeParts.join('-') || 'BLDG';

  // Add sequential number — scan existing codes in the table
  const existingCodes = [];
  document.querySelectorAll('table tbody tr td.font-monospace').forEach(cell => {
    existingCodes.push(cell.textContent.trim());
  });

  let counter = 1;
  let fullCode = `${baseCode}-${String(counter).padStart(2, '0')}`;
  while (existingCodes.includes(fullCode)) {
    counter++;
    fullCode = `${baseCode}-${String(counter).padStart(2, '0')}`;
  }

  return fullCode;
}

// Auto-generate code when name changes
document.getElementById('addName').addEventListener('input', function() {
  document.getElementById('addCode').value = generateBuildingCode(this.value);
});

document.getElementById('addBuildingModal').addEventListener('show.bs.modal', function() {
  document.getElementById('addBuildingForm').reset();
  document.getElementById('addCode').value = '';
});

// ==========================================
// View Building
// ==========================================
document.querySelectorAll('.btn-view-bldg').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('viewName').textContent = this.dataset.name;
    document.getElementById('viewCode').textContent = this.dataset.code;
    document.getElementById('viewRooms').textContent = this.dataset.rooms;
    document.getElementById('viewFloors').textContent = this.dataset.floors;
    document.getElementById('viewYear').textContent = this.dataset.year;
    document.getElementById('viewArea').textContent = this.dataset.area;
    document.getElementById('viewManager').textContent = this.dataset.manager;
    document.getElementById('viewNotes').textContent = this.dataset.notes;

    const statusBadge = document.getElementById('viewStatus');
    statusBadge.textContent = this.dataset.status;
    statusBadge.className = 'badge';
    if (this.dataset.status === 'Active') statusBadge.classList.add('bg-success');
    else if (this.dataset.status === 'Under Maintenance') statusBadge.classList.add('bg-warning', 'text-dark');
    else statusBadge.classList.add('bg-secondary');

    new bootstrap.Modal(document.getElementById('viewBuildingModal')).show();
  });
});

// ==========================================
// Add Building (AJAX)
// ==========================================
document.getElementById('addBuildingForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const btn = this.querySelector('[type="submit"]');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Adding...';

  fetch("{{ route('pmo.buildings.store') }}", {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    body: JSON.stringify({
      name: document.getElementById('addName').value,
      code: document.getElementById('addCode').value,
      rooms: document.getElementById('addRooms').value || 0,
      floors: document.getElementById('addFloors').value || 1,
      year_built: document.getElementById('addYear').value || null,
      total_area: document.getElementById('addArea').value || null,
      status: document.getElementById('addStatus').value,
      manager: document.getElementById('addManager').value,
      notes: document.getElementById('addNotes').value,
    })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) { alert(data.message); location.reload(); }
    else { alert('Error: ' + (data.message || 'Something went wrong')); btn.disabled = false; btn.innerHTML = '<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" class="me-1"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg> Add Building'; }
  })
  .catch(err => { console.error(err); alert('An error occurred.'); btn.disabled = false; btn.innerHTML = '<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" class="me-1"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg> Add Building'; });
});

// ==========================================
// Edit Building (AJAX)
// ==========================================
document.querySelectorAll('.btn-edit-bldg').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('editDbId').value = this.dataset.dbId;
    document.getElementById('editName').value = this.dataset.name;
    document.getElementById('editCode').value = this.dataset.code;
    document.getElementById('editRooms').value = this.dataset.rooms;
    document.getElementById('editFloors').value = this.dataset.floors;
    document.getElementById('editYear').value = this.dataset.year;
    document.getElementById('editArea').value = this.dataset.area;
    document.getElementById('editStatus').value = this.dataset.status;
    document.getElementById('editManager').value = this.dataset.manager;
    document.getElementById('editNotes').value = this.dataset.notes;
    new bootstrap.Modal(document.getElementById('editBuildingModal')).show();
  });
});

document.getElementById('editBuildingForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const id = document.getElementById('editDbId').value;
  const btn = this.querySelector('[type="submit"]');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

  fetch(`/pmo/buildings/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    body: JSON.stringify({
      name: document.getElementById('editName').value,
      code: document.getElementById('editCode').value,
      rooms: document.getElementById('editRooms').value || 0,
      floors: document.getElementById('editFloors').value || 1,
      year_built: document.getElementById('editYear').value || null,
      total_area: document.getElementById('editArea').value || null,
      status: document.getElementById('editStatus').value,
      manager: document.getElementById('editManager').value,
      notes: document.getElementById('editNotes').value,
    })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) { alert(data.message); location.reload(); }
    else { alert('Error: ' + (data.message || 'Something went wrong')); btn.disabled = false; btn.innerHTML = 'Save Changes'; }
  })
  .catch(err => { console.error(err); alert('An error occurred.'); btn.disabled = false; btn.innerHTML = 'Save Changes'; });
});

// ==========================================
// Delete Building (AJAX)
// ==========================================
document.querySelectorAll('.btn-delete-bldg').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('deleteDbId').value = this.dataset.dbId;
    document.getElementById('deleteBldgName').textContent = this.dataset.name;
    document.getElementById('deleteBldgCode').textContent = this.dataset.code;
    new bootstrap.Modal(document.getElementById('deleteBuildingModal')).show();
  });
});

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
  const id = document.getElementById('deleteDbId').value;
  this.disabled = true;
  this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Deleting...';

  fetch(`/pmo/buildings/${id}`, {
    method: 'DELETE',
    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) { alert(data.message); location.reload(); }
    else { alert('Error: ' + (data.message || 'Something went wrong')); this.disabled = false; this.innerHTML = 'Delete Building'; }
  })
  .catch(err => { console.error(err); alert('An error occurred.'); this.disabled = false; this.innerHTML = 'Delete Building'; });
});
</script>
@endsection
