@extends('admin.pmo-layout')

@section('title', 'Suppliers & Items')
@section('crumb', 'Suppliers & Items')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <img src="/images/clsu-logo-green.png" alt="CLSU Seal" style="width:56px;height:56px;border-radius:14px;background:#fff;border:2px solid var(--clsu-green);object-fit:contain;">
    <div>
      <h1 class="h3 fw-bold mb-1">Suppliers & Items</h1>
      <div class="text-muted">Manage suppliers and procurable items</div>
    </div>
  </div>
  <button class="btn text-white rounded-4" style="background: var(--clsu-green);" data-bs-toggle="modal" data-bs-target="#addEquipmentModal">
    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" class="me-2">
      <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
    </svg>
    Add Supplier/Item
  </button>
</div>

<div class="row g-3">
  <div class="col-md-3">
    <div class="card rounded-4">
      <div class="card-body">
        <h6 class="text-muted mb-1">Total Suppliers</h6>
        <h2 class="mb-0 fw-bold" style="color: var(--clsu-green);">{{ $stats['total'] }}</h2>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4">
      <div class="card-body">
        <h6 class="text-muted mb-1">Active</h6>
        <h2 class="mb-0 fw-bold text-success">{{ $stats['in_use'] }}</h2>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4">
      <div class="card-body">
        <h6 class="text-muted mb-1">Under Review</h6>
        <h2 class="mb-0 fw-bold" style="color: var(--clsu-gold);">{{ $stats['under_repair'] }}</h2>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4">
      <div class="card-body">
        <h6 class="text-muted mb-1">Blacklisted</h6>
        <h2 class="mb-0 fw-bold text-danger">{{ $stats['decommissioned'] }}</h2>
      </div>
    </div>
  </div>
</div>

<div class="card mt-3 rounded-4">
  <div class="card-body">
    <h5 class="card-title mb-3 fw-bold">Supplier & Item Directory</h5>
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="bg-light">
          <tr>
            <th class="py-3">Supplier/Item Name</th>
            <th class="py-3">Category</th>
            <th class="py-3">Reference No.</th>
            <th class="py-3">Contact/Location</th>
            <th class="py-3">Status</th>
            <th class="py-3 text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($equipment as $item)
          @php
            $statusLabels = ['in_use' => 'In Use', 'under_repair' => 'Under Repair', 'available' => 'Available', 'decommissioned' => 'Decommissioned'];
            $statusColors = ['in_use' => 'bg-success', 'under_repair' => 'bg-warning text-dark', 'available' => 'bg-info', 'decommissioned' => 'bg-danger'];
            $catLabels = ['electronics' => 'Electronics', 'hvac' => 'HVAC', 'furniture' => 'Furniture', 'vehicle' => 'Vehicle', 'tools' => 'Tools', 'office' => 'Office Equipment'];
            $catColors = ['electronics' => 'background: var(--clsu-green)', 'hvac' => 'background: var(--clsu-gold)', 'furniture' => '', 'vehicle' => 'background: #6f42c1', 'tools' => 'background: #0dcaf0', 'office' => 'background: #6c757d'];
            $condLabels = ['excellent' => 'Excellent', 'good' => 'Good', 'fair' => 'Fair', 'needs_repair' => 'Needs Repair'];
          @endphp
          <tr>
            <td class="py-3 fw-semibold">{{ $item->name }}</td>
            <td class="py-3">
              <span class="badge {{ $item->category === 'furniture' ? 'bg-secondary' : '' }}" @if($item->category !== 'furniture') style="{{ $catColors[$item->category] ?? 'background: var(--clsu-green)' }}" @endif>{{ $catLabels[$item->category] ?? ucfirst($item->category) }}</span>
            </td>
            <td class="py-3 font-monospace">{{ $item->serial_number }}</td>
            <td class="py-3">{{ $item->location ?? '—' }}</td>
            <td class="py-3"><span class="badge {{ $statusColors[$item->status] ?? 'bg-secondary' }}">{{ $statusLabels[$item->status] ?? ucfirst($item->status) }}</span></td>
            <td class="py-3 text-end">
              <div class="btn-group btn-group-sm">
                <button class="btn btn-sm btn-view-equip" style="color: var(--clsu-green); border-color: var(--clsu-green);"
                  data-name="{{ $item->name }}"
                  data-category="{{ $catLabels[$item->category] ?? ucfirst($item->category) }}"
                  data-serial="{{ $item->serial_number }}"
                  data-location="{{ $item->location }}"
                  data-status="{{ $statusLabels[$item->status] ?? ucfirst($item->status) }}"
                  data-acquired="{{ $item->created_at->format('M d, Y') }}"
                  data-condition="{{ $condLabels[$item->condition] ?? ucfirst($item->condition) }}"
                  data-assignee="{{ $item->assigned_to ?? 'N/A' }}"
                  data-notes="{{ $item->notes ?? 'N/A' }}">View</button>
                <button class="btn btn-sm btn-edit-equip" style="color: var(--clsu-gold); border-color: var(--clsu-gold);"
                  data-id="{{ $item->id }}"
                  data-name="{{ $item->name }}"
                  data-category="{{ $item->category }}"
                  data-serial="{{ $item->serial_number }}"
                  data-location="{{ $item->location }}"
                  data-status="{{ $item->status }}"
                  data-condition="{{ $item->condition }}"
                  data-assignee="{{ $item->assigned_to }}"
                  data-notes="{{ $item->notes }}">Edit</button>
                <button class="btn btn-sm btn-delete-equip" style="color: #dc3545; border-color: #dc3545;"
                  data-id="{{ $item->id }}"
                  data-name="{{ $item->name }}"
                  data-serial="{{ $item->serial_number }}">Delete</button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-4 text-muted">No supplier or item records found. Click "Add Supplier/Item" to get started.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Add Equipment Modal -->
<div class="modal fade" id="addEquipmentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Add Supplier/Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form id="addEquipmentForm">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label fw-bold">Supplier/Item Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3" id="addName" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
              <select class="form-select rounded-3" id="addCategory" required>
                <option value="">Select</option>
                <option value="electronics">Electronics</option>
                <option value="hvac">HVAC</option>
                <option value="furniture">Furniture</option>
                <option value="vehicle">Vehicle</option>
                <option value="tools">Tools</option>
                <option value="office">Office Equipment</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Reference No. <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3" id="addSerial" required readonly style="background-color: #f0f7f0; cursor: default;">
              <small class="text-muted"><em>Auto-generated based on category</em></small>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Contact/Location</label>
              <input type="text" class="form-control rounded-3" id="addLocation" placeholder="Contact or Location">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Status</label>
              <select class="form-select rounded-3" id="addStatus">
                <option value="in_use">In Use</option>
                <option value="under_repair">Under Repair</option>
                <option value="available">Available</option>
                <option value="decommissioned">Decommissioned</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Condition</label>
              <select class="form-select rounded-3" id="addCondition">
                <option value="excellent">Excellent</option>
                <option value="good">Good</option>
                <option value="fair">Fair</option>
                <option value="needs_repair">Needs Repair</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Assigned To</label>
              <input type="text" class="form-control rounded-3" id="addAssignee">
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
              Add Supplier/Item
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- View Equipment Modal -->
<div class="modal fade" id="viewEquipmentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Supplier/Item Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row g-3">
          <div class="col-12">
            <h4 class="fw-bold mb-0" id="viewName"></h4>
          </div>
          <div class="col-md-4">
            <label class="form-label text-muted small">Category</label>
            <div><span id="viewCategory" class="badge" style="background: var(--clsu-green);"></span></div>
          </div>
          <div class="col-md-4">
            <label class="form-label text-muted small">Status</label>
            <div><span id="viewStatus" class="badge bg-success"></span></div>
          </div>
          <div class="col-md-4">
            <label class="form-label text-muted small">Condition</label>
            <div class="fw-semibold" id="viewCondition"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Reference No.</label>
            <div class="fw-semibold font-monospace" id="viewSerial"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Contact/Location</label>
            <div class="fw-semibold" id="viewLocation"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Date Added</label>
            <div class="fw-semibold" id="viewAcquired"></div>
          </div>
          <div class="col-12">
            <label class="form-label text-muted small">Assigned To</label>
            <div class="fw-semibold" id="viewAssignee"></div>
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

<!-- Edit Equipment Modal -->
<div class="modal fade" id="editEquipmentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Edit Supplier/Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form id="editEquipmentForm">
          <input type="hidden" id="editId">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label fw-bold">Supplier/Item Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3" id="editName" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
              <select class="form-select rounded-3" id="editCategory" required>
                <option value="electronics">Electronics</option>
                <option value="hvac">HVAC</option>
                <option value="furniture">Furniture</option>
                <option value="vehicle">Vehicle</option>
                <option value="tools">Tools</option>
                <option value="office">Office Equipment</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Reference No. <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3" id="editSerial" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Contact/Location</label>
              <input type="text" class="form-control rounded-3" id="editLocation">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Status</label>
              <select class="form-select rounded-3" id="editStatus">
                <option value="in_use">In Use</option>
                <option value="under_repair">Under Repair</option>
                <option value="available">Available</option>
                <option value="decommissioned">Decommissioned</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Condition</label>
              <select class="form-select rounded-3" id="editCondition">
                <option value="excellent">Excellent</option>
                <option value="good">Good</option>
                <option value="fair">Fair</option>
                <option value="needs_repair">Needs Repair</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Assigned To</label>
              <input type="text" class="form-control rounded-3" id="editAssignee">
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
<div class="modal fade" id="deleteEquipmentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Delete Equipment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" id="deleteId">
        <div class="text-center mb-3">
          <svg width="48" height="48" fill="#dc3545" viewBox="0 0 24 24">
            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
          </svg>
        </div>
        <p class="text-center mb-1">Are you sure you want to delete this equipment?</p>
        <p class="text-center fw-bold" id="deleteEquipName"></p>
        <p class="text-center text-muted small font-monospace" id="deleteEquipSerial"></p>
        <p class="text-center text-muted small">This action cannot be undone.</p>
      </div>
      <div class="modal-footer border-0 pt-0 justify-content-center">
        <button type="button" class="btn rounded-3 px-4" style="color: var(--clsu-green); border-color: var(--clsu-green);" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn rounded-3 px-4 text-white" style="background: #dc3545;" id="confirmDeleteBtn">Delete Equipment</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// ==========================================
// Auto-Generate Serial Number
// ==========================================
const categoryPrefixes = {
  electronics: 'ELEC',
  hvac: 'HVAC',
  furniture: 'FURN',
  vehicle: 'VEH',
  tools: 'TOOL',
  office: 'OFC'
};

const serialCounters = { ELEC: 1, HVAC: 1, FURN: 1, VEH: 1, TOOL: 1, OFC: 1 };

(function initSerialCounters() {
  document.querySelectorAll('table tbody tr .font-monospace').forEach(cell => {
    const text = cell.textContent.trim();
    const match = text.match(/^([A-Z]+)-(\d{4})-(\d+)$/);
    if (match) {
      const prefix = match[1];
      const num = parseInt(match[3], 10);
      const mappedPrefix = {
        'PROJ': 'ELEC', 'AC': 'HVAC', 'FURN': 'FURN',
        'ELEC': 'ELEC', 'HVAC': 'HVAC', 'VEH': 'VEH',
        'TOOL': 'TOOL', 'OFC': 'OFC'
      }[prefix] || prefix;
      if (serialCounters[mappedPrefix] !== undefined && num >= serialCounters[mappedPrefix]) {
        serialCounters[mappedPrefix] = num + 1;
      }
    }
  });
})();

function generateSerialNumber(category) {
  const prefix = categoryPrefixes[category];
  if (!prefix) return '';
  const year = new Date().getFullYear();
  const num = String(serialCounters[prefix]).padStart(3, '0');
  return `${prefix}-${year}-${num}`;
}

document.getElementById('addCategory').addEventListener('change', function() {
  const serialInput = document.getElementById('addSerial');
  serialInput.value = this.value ? generateSerialNumber(this.value) : '';
});

document.getElementById('addEquipmentModal').addEventListener('show.bs.modal', function() {
  document.getElementById('addEquipmentForm').reset();
  document.getElementById('addSerial').value = '';
});

// ==========================================
// Add Equipment (AJAX)
// ==========================================
document.getElementById('addEquipmentForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const btn = this.querySelector('[type="submit"]');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

  fetch("{{ route('pmo.equipment.store') }}", {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    body: JSON.stringify({
      name: document.getElementById('addName').value,
      category: document.getElementById('addCategory').value,
      serial_number: document.getElementById('addSerial').value,
      location: document.getElementById('addLocation').value,
      status: document.getElementById('addStatus').value,
      condition: document.getElementById('addCondition').value,
      assigned_to: document.getElementById('addAssignee').value,
      notes: document.getElementById('addNotes').value,
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
      btn.innerHTML = '<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" class="me-1"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg> Add Equipment';
    }
  })
  .catch(err => {
    console.error(err);
    alert('An error occurred. Please try again.');
    btn.disabled = false;
    btn.innerHTML = '<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" class="me-1"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg> Add Equipment';
  });
});

// ==========================================
// View Equipment
// ==========================================
document.querySelectorAll('.btn-view-equip').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('viewName').textContent = this.dataset.name;
    document.getElementById('viewCategory').textContent = this.dataset.category;
    document.getElementById('viewSerial').textContent = this.dataset.serial;
    document.getElementById('viewLocation').textContent = this.dataset.location || '—';
    document.getElementById('viewAcquired').textContent = this.dataset.acquired;
    document.getElementById('viewCondition').textContent = this.dataset.condition;
    document.getElementById('viewAssignee').textContent = this.dataset.assignee || 'N/A';
    document.getElementById('viewNotes').textContent = this.dataset.notes || 'N/A';

    const statusBadge = document.getElementById('viewStatus');
    statusBadge.textContent = this.dataset.status;
    statusBadge.className = 'badge';
    if (this.dataset.status === 'In Use') statusBadge.classList.add('bg-success');
    else if (this.dataset.status === 'Under Repair') statusBadge.classList.add('bg-warning', 'text-dark');
    else if (this.dataset.status === 'Decommissioned') statusBadge.classList.add('bg-danger');
    else statusBadge.classList.add('bg-info');

    new bootstrap.Modal(document.getElementById('viewEquipmentModal')).show();
  });
});

// ==========================================
// Edit Equipment (AJAX)
// ==========================================
document.querySelectorAll('.btn-edit-equip').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('editId').value = this.dataset.id;
    document.getElementById('editName').value = this.dataset.name;
    document.getElementById('editCategory').value = this.dataset.category;
    document.getElementById('editSerial').value = this.dataset.serial;
    document.getElementById('editLocation').value = this.dataset.location;
    document.getElementById('editStatus').value = this.dataset.status;
    document.getElementById('editCondition').value = this.dataset.condition;
    document.getElementById('editAssignee').value = this.dataset.assignee;
    document.getElementById('editNotes').value = this.dataset.notes;
    new bootstrap.Modal(document.getElementById('editEquipmentModal')).show();
  });
});

document.getElementById('editEquipmentForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const id = document.getElementById('editId').value;
  const btn = this.querySelector('[type="submit"]');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

  fetch(`/pmo/equipment/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    body: JSON.stringify({
      name: document.getElementById('editName').value,
      category: document.getElementById('editCategory').value,
      serial_number: document.getElementById('editSerial').value,
      location: document.getElementById('editLocation').value,
      status: document.getElementById('editStatus').value,
      condition: document.getElementById('editCondition').value,
      assigned_to: document.getElementById('editAssignee').value,
      notes: document.getElementById('editNotes').value,
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
      btn.innerHTML = 'Save Changes';
    }
  })
  .catch(err => {
    console.error(err);
    alert('An error occurred. Please try again.');
    btn.disabled = false;
    btn.innerHTML = 'Save Changes';
  });
});

// ==========================================
// Delete Equipment (AJAX)
// ==========================================
document.querySelectorAll('.btn-delete-equip').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('deleteId').value = this.dataset.id;
    document.getElementById('deleteEquipName').textContent = this.dataset.name;
    document.getElementById('deleteEquipSerial').textContent = this.dataset.serial;
    new bootstrap.Modal(document.getElementById('deleteEquipmentModal')).show();
  });
});

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
  const id = document.getElementById('deleteId').value;
  this.disabled = true;
  this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Deleting...';

  fetch(`/pmo/equipment/${id}`, {
    method: 'DELETE',
    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      location.reload();
    } else {
      alert('Error: ' + (data.message || 'Something went wrong'));
      this.disabled = false;
      this.innerHTML = 'Delete Equipment';
    }
  })
  .catch(err => {
    console.error(err);
    alert('An error occurred. Please try again.');
    this.disabled = false;
    this.innerHTML = 'Delete Equipment';
  });
});
</script>
@endsection
