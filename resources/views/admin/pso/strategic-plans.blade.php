@extends('admin.pso-layout')

@section('title', 'Supply Management')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h1 class="h3 fw-bold mb-1">Supply Management</h1>
    <p class="text-muted mb-0">Manage supply inventory and distribution records</p>
  </div>
  <button class="btn rounded-4 text-white" style="background: var(--clsu-green);" data-bs-toggle="modal" data-bs-target="#newPlanModal">
    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" class="me-2">
      <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
    </svg>
    New Supply Record
  </button>
</div>

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body p-4 text-center">
        <div class="h2 fw-bold mb-2" style="color: var(--clsu-green);">{{ $stats['total'] }}</div>
        <div class="text-muted">Total Records</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body p-4 text-center">
        <div class="h2 fw-bold mb-2" style="color: var(--clsu-green);">{{ $stats['active'] }}</div>
        <div class="text-muted">Active</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body p-4 text-center">
        <div class="h2 fw-bold mb-2" style="color: var(--clsu-gold);">{{ $stats['under_review'] }}</div>
        <div class="text-muted">Under Review</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body p-4 text-center">
        <div class="h2 fw-bold mb-2" style="color: var(--clsu-gold);">{{ $stats['archived'] }}</div>
        <div class="text-muted">Archived</div>
      </div>
    </div>
  </div>
</div>

<!-- Strategic Plans List -->
<div class="card rounded-4 border">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="bg-light">
          <tr>
            <th class="px-4 py-3">Supply Name</th>
            <th class="py-3">Period</th>
            <th class="py-3">Focus Area</th>
            <th class="py-3">Status</th>
            <th class="py-3">Progress</th>
            <th class="py-3 text-end pe-4">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($plans as $plan)
          @php
            $statusColors = [
              'active' => 'bg-success',
              'under_review' => 'bg-warning text-dark',
              'draft' => 'bg-secondary',
              'archived' => 'bg-info',
            ];
            $statusLabels = [
              'active' => 'Active',
              'under_review' => 'Under Review',
              'draft' => 'Draft',
              'archived' => 'Archived',
            ];
            $progressColor = $plan->progress >= 50 ? 'var(--clsu-green)' : 'var(--clsu-gold)';
          @endphp
          <tr>
            <td class="px-4 py-3">
              <div class="fw-bold">{{ $plan->name }}</div>
              <small class="text-muted">{{ Str::limit($plan->description, 50) }}</small>
            </td>
            <td class="py-3">{{ $plan->period }}</td>
            <td class="py-3"><span class="badge" style="background: var(--clsu-green);">{{ $plan->focus_area }}</span></td>
            <td class="py-3"><span class="badge {{ $statusColors[$plan->status] ?? 'bg-secondary' }}">{{ $statusLabels[$plan->status] ?? ucfirst($plan->status) }}</span></td>
            <td class="py-3">
              <div class="progress" style="height: 8px;">
                <div class="progress-bar" style="width: {{ $plan->progress }}%; background: {{ $progressColor }};"></div>
              </div>
              <small class="text-muted">{{ $plan->progress }}%</small>
            </td>
            <td class="py-3 text-end pe-4">
              <div class="btn-group btn-group-sm">
                <button class="btn btn-sm btn-view-plan" style="color: var(--clsu-green); border-color: var(--clsu-green);"
                  data-id="{{ $plan->id }}"
                  data-code="{{ $plan->plan_code }}"
                  data-name="{{ $plan->name }}"
                  data-description="{{ $plan->description }}"
                  data-focus="{{ $plan->focus_area }}"
                  data-period="{{ $plan->period }}"
                  data-start="{{ $plan->start_date->format('M d, Y') }}"
                  data-end="{{ $plan->end_date->format('M d, Y') }}"
                  data-status="{{ $statusLabels[$plan->status] ?? ucfirst($plan->status) }}"
                  data-progress="{{ $plan->progress }}">View</button>
                <button class="btn btn-sm btn-edit-plan" style="color: var(--clsu-gold); border-color: var(--clsu-gold);"
                  data-id="{{ $plan->id }}"
                  data-name="{{ $plan->name }}"
                  data-description="{{ $plan->description }}"
                  data-focus="{{ $plan->focus_area }}"
                  data-period="{{ $plan->period }}"
                  data-start="{{ $plan->start_date->format('Y-m-d') }}"
                  data-end="{{ $plan->end_date->format('Y-m-d') }}"
                  data-status="{{ $plan->status }}"
                  data-progress="{{ $plan->progress }}">Edit</button>
                <button class="btn btn-sm btn-delete-plan" style="color: #dc3545; border-color: #dc3545;"
                  data-id="{{ $plan->id }}"
                  data-name="{{ $plan->name }}">Delete</button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-5 text-muted">
              <svg width="48" height="48" fill="currentColor" viewBox="0 0 24 24" class="mb-2 d-block mx-auto opacity-25">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
              </svg>
              No supply records found. Click "New Supply Record" to create one.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- New Plan Modal -->
<div class="modal fade" id="newPlanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Add New Supply Record</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form id="newPlanForm">
          <div class="row g-3">
            <div class="col-12">
              <label for="planName" class="form-label fw-semibold">Plan Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3" id="planName" required>
            </div>
            
            <div class="col-12">
              <label for="planDescription" class="form-label fw-semibold">Description</label>
              <textarea class="form-control rounded-3" id="planDescription" rows="3"></textarea>
            </div>
            
            <div class="col-md-6">
              <label for="planFocusArea" class="form-label fw-semibold">Focus Area <span class="text-danger">*</span></label>
              <select class="form-select rounded-3" id="planFocusArea" required>
                <option value="">Select focus area</option>
                <option value="Institutional">Institutional</option>
                <option value="Research">Research</option>
                <option value="Academic">Academic</option>
                <option value="Community">Community</option>
              </select>
            </div>
            
            <div class="col-md-6">
              <label for="planPeriod" class="form-label fw-semibold">Period <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3" id="planPeriod" placeholder="e.g., 2024-2029" required>
            </div>
            
            <div class="col-md-6">
              <label for="planStartDate" class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
              <input type="date" class="form-control rounded-3" id="planStartDate" required>
            </div>
            
            <div class="col-md-6">
              <label for="planEndDate" class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
              <input type="date" class="form-control rounded-3" id="planEndDate" required>
            </div>
            
            <div class="col-md-6">
              <label for="planStatus" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
              <select class="form-select rounded-3" id="planStatus" required>
                <option value="">Select status</option>
                <option value="active">Active</option>
                <option value="under_review">Under Review</option>
                <option value="archived">Archived</option>
                <option value="draft">Draft</option>
              </select>
            </div>
            
            <div class="col-md-6">
              <label for="planProgress" class="form-label fw-semibold">Initial Progress (%)</label>
              <input type="number" class="form-control rounded-3" id="planProgress" min="0" max="100" value="0">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn rounded-3" style="color: var(--clsu-gold); border-color: var(--clsu-gold);" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="newPlanForm" class="btn text-white rounded-3" style="background: var(--clsu-green);">Add Record</button>
      </div>
    </div>
  </div>
</div>

<!-- View Plan Modal -->
<div class="modal fade" id="viewPlanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Supply Record Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row g-3">
          <div class="col-12">
            <h4 class="fw-bold mb-1" id="viewPlanName"></h4>
            <span class="badge bg-light text-dark font-monospace small" id="viewPlanCode"></span>
          </div>
          <div class="col-12">
            <p class="text-muted" id="viewPlanDescription"></p>
          </div>
          
          <div class="col-md-6">
            <label class="form-label text-muted small">Focus Area</label>
            <div><span id="viewPlanFocusArea" class="badge" style="background: var(--clsu-green);"></span></div>
          </div>
          
          <div class="col-md-6">
            <label class="form-label text-muted small">Status</label>
            <div><span id="viewPlanStatus" class="badge bg-success"></span></div>
          </div>
          
          <div class="col-md-6">
            <label class="form-label text-muted small">Period</label>
            <div class="fw-semibold" id="viewPlanPeriod"></div>
          </div>

          <div class="col-md-6">
             <label class="form-label text-muted small">Timeline</label>
             <div class="fw-semibold"><span id="viewPlanStart"></span> - <span id="viewPlanEnd"></span></div>
          </div>
          
          <div class="col-12">
            <label class="form-label text-muted small">Progress</label>
            <div class="progress" style="height: 12px;">
              <div id="viewPlanProgress" class="progress-bar" style="background: var(--clsu-green);"></div>
            </div>
            <small class="text-muted" id="viewPlanProgressText"></small>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn rounded-3" style="color: var(--clsu-green); border-color: var(--clsu-green);" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Plan Modal -->
<div class="modal fade" id="editPlanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Edit Supply Record</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form id="editPlanForm">
          <input type="hidden" id="editPlanId">
          <div class="row g-3">
            <div class="col-12">
              <label for="editPlanName" class="form-label fw-semibold">Plan Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3" id="editPlanName" required>
            </div>
            
            <div class="col-12">
              <label for="editPlanDescription" class="form-label fw-semibold">Description</label>
              <textarea class="form-control rounded-3" id="editPlanDescription" rows="3"></textarea>
            </div>
            
            <div class="col-md-6">
              <label for="editPlanFocusArea" class="form-label fw-semibold">Focus Area <span class="text-danger">*</span></label>
              <select class="form-select rounded-3" id="editPlanFocusArea" required>
                <option value="">Select focus area</option>
                <option value="Institutional">Institutional</option>
                <option value="Research">Research</option>
                <option value="Academic">Academic</option>
                <option value="Community">Community</option>
              </select>
            </div>
            
            <div class="col-md-6">
              <label for="editPlanPeriod" class="form-label fw-semibold">Period <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3" id="editPlanPeriod" required>
            </div>
            
            <div class="col-md-6">
              <label for="editPlanStartDate" class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
              <input type="date" class="form-control rounded-3" id="editPlanStartDate" required>
            </div>
            
            <div class="col-md-6">
              <label for="editPlanEndDate" class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
              <input type="date" class="form-control rounded-3" id="editPlanEndDate" required>
            </div>
            
            <div class="col-md-6">
              <label for="editPlanStatus" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
              <select class="form-select rounded-3" id="editPlanStatus" required>
                <option value="">Select status</option>
                <option value="active">Active</option>
                <option value="under_review">Under Review</option>
                <option value="archived">Archived</option>
                <option value="draft">Draft</option>
              </select>
            </div>
            
            <div class="col-md-6">
              <label for="editPlanProgress" class="form-label fw-semibold">Progress (%)</label>
              <input type="number" class="form-control rounded-3" id="editPlanProgress" min="0" max="100" required>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn rounded-3" style="color: var(--clsu-gold); border-color: var(--clsu-gold);" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="editPlanForm" class="btn text-white rounded-3" style="background: var(--clsu-green);">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deletePlanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Delete Supply Record</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" id="deletePlanId">
        <div class="text-center mb-3">
          <svg width="48" height="48" fill="#dc3545" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
          </svg>
        </div>
        <p class="text-center mb-1">Are you sure you want to delete this supply record?</p>
        <p class="text-center fw-bold" id="deletePlanName"></p>
        <div class="alert alert-danger rounded-3 small mt-3 mb-0">
          <strong>Warning:</strong> This action cannot be undone.
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 justify-content-center">
        <button type="button" class="btn rounded-3 px-4" style="color: var(--clsu-green); border-color: var(--clsu-green);" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn rounded-3 px-4 text-white bg-danger" id="confirmDeleteBtn">Delete Record</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// ==========================================
// Create Plan (AJAX)
// ==========================================
document.getElementById('newPlanForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const btn = this.closest('.modal-content').querySelector('[type="submit"]');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Creating...';

  const formData = {
    name: document.getElementById('planName').value,
    description: document.getElementById('planDescription').value,
    focus_area: document.getElementById('planFocusArea').value,
    period: document.getElementById('planPeriod').value,
    start_date: document.getElementById('planStartDate').value,
    end_date: document.getElementById('planEndDate').value,
    status: document.getElementById('planStatus').value,
    progress: document.getElementById('planProgress').value || 0,
  };

  fetch('/pso/strategic-plans', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    body: JSON.stringify(formData)
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) { alert(data.message); location.reload(); }
    else { alert('Error: ' + (data.message || 'Something went wrong')); btn.disabled = false; btn.textContent = 'Create Plan'; }
  })
  .catch(err => {
    console.error(err);
    alert('An error occurred. Please check your inputs.');
    btn.disabled = false; btn.textContent = 'Create Plan';
  });
});

// ==========================================
// View Plan
// ==========================================
document.querySelectorAll('.btn-view-plan').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('viewPlanName').textContent = this.dataset.name;
    document.getElementById('viewPlanCode').textContent = this.dataset.code;
    document.getElementById('viewPlanDescription').textContent = this.dataset.description || 'No description';
    document.getElementById('viewPlanFocusArea').textContent = this.dataset.focus;
    document.getElementById('viewPlanStatus').textContent = this.dataset.status;
    document.getElementById('viewPlanPeriod').textContent = this.dataset.period;
    document.getElementById('viewPlanStart').textContent = this.dataset.start;
    document.getElementById('viewPlanEnd').textContent = this.dataset.end;
    document.getElementById('viewPlanProgress').style.width = this.dataset.progress + '%';
    document.getElementById('viewPlanProgressText').textContent = this.dataset.progress + '%';
    new bootstrap.Modal(document.getElementById('viewPlanModal')).show();
  });
});

// ==========================================
// Edit Plan
// ==========================================
document.querySelectorAll('.btn-edit-plan').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('editPlanId').value = this.dataset.id;
    document.getElementById('editPlanName').value = this.dataset.name;
    document.getElementById('editPlanDescription').value = this.dataset.description;
    document.getElementById('editPlanFocusArea').value = this.dataset.focus;
    document.getElementById('editPlanPeriod').value = this.dataset.period;
    document.getElementById('editPlanStartDate').value = this.dataset.start;
    document.getElementById('editPlanEndDate').value = this.dataset.end;
    document.getElementById('editPlanStatus').value = this.dataset.status;
    document.getElementById('editPlanProgress').value = this.dataset.progress;
    new bootstrap.Modal(document.getElementById('editPlanModal')).show();
  });
});

// ==========================================
// Update Plan (AJAX)
// ==========================================
document.getElementById('editPlanForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const id = document.getElementById('editPlanId').value;
  const btn = this.closest('.modal-content').querySelector('[type="submit"]');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

  const formData = {
    name: document.getElementById('editPlanName').value,
    description: document.getElementById('editPlanDescription').value,
    focus_area: document.getElementById('editPlanFocusArea').value,
    period: document.getElementById('editPlanPeriod').value,
    start_date: document.getElementById('editPlanStartDate').value,
    end_date: document.getElementById('editPlanEndDate').value,
    status: document.getElementById('editPlanStatus').value,
    progress: document.getElementById('editPlanProgress').value,
  };

  fetch(`/pso/strategic-plans/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    body: JSON.stringify(formData)
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) { alert(data.message); location.reload(); }
    else { alert('Error: ' + (data.message || 'Something went wrong')); btn.disabled = false; btn.textContent = 'Save Changes'; }
  })
  .catch(err => {
    console.error(err);
    alert('An error occurred.');
    btn.disabled = false; btn.textContent = 'Save Changes';
  });
});

// ==========================================
// Delete Plan (AJAX)
// ==========================================
document.querySelectorAll('.btn-delete-plan').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('deletePlanId').value = this.dataset.id;
    document.getElementById('deletePlanName').textContent = this.dataset.name;
    new bootstrap.Modal(document.getElementById('deletePlanModal')).show();
  });
});

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
  const id = document.getElementById('deletePlanId').value;
  this.disabled = true;
  this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Deleting...';

  fetch(`/pso/strategic-plans/${id}`, {
    method: 'DELETE',
    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) { alert(data.message); location.reload(); }
    else { alert('Error: ' + (data.message || 'Something went wrong')); this.disabled = false; this.textContent = 'Delete Plan'; }
  })
  .catch(err => {
    console.error(err);
    alert('An error occurred.');
    this.disabled = false; this.textContent = 'Delete Plan';
  });
});
</script>
@endsection
