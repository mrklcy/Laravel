@extends('admin.pso-layout')

@section('title', 'Property Records')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h1 class="h3 fw-bold mb-1">Property Records</h1>
    <p class="text-muted mb-0">Track and manage university property inventory</p>
  </div>
  <button class="btn rounded-4 text-white" style="background: var(--clsu-green);" data-bs-toggle="modal" data-bs-target="#newProjectModal">
    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" class="me-2">
      <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
    </svg>
    New Property
  </button>
</div>

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body p-4 text-center">
        <div class="h2 fw-bold mb-2" style="color: var(--clsu-green);">{{ $stats['total'] }}</div>
        <div class="text-muted">Total Properties</div>
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
        <div class="h2 fw-bold mb-2" style="color: var(--clsu-gold);">{{ $stats['completed'] }}</div>
        <div class="text-muted">Completed</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body p-4 text-center">
        <div class="h2 fw-bold mb-2" style="color: var(--clsu-gold);">{{ $stats['on_hold'] }}</div>
        <div class="text-muted">On Hold</div>
      </div>
    </div>
  </div>
</div>

<!-- Projects List -->
<div class="card rounded-4 border">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="bg-light">
          <tr>
            <th class="px-4 py-3">Property Name</th>
            <th class="py-3">Category</th>
            <th class="py-3">Acquisition Date</th>
            <th class="py-3">Value</th>
            <th class="py-3">Status</th>
            <th class="py-3">Progress</th>
            <th class="py-3 text-end pe-4">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($projects as $project)
          @php
            $statusColors = [
              'active' => 'bg-success',
              'on_hold' => 'bg-warning text-dark',
              'completed' => 'bg-info',
              'cancelled' => 'bg-danger',
            ];
            $statusLabels = [
              'active' => 'Active',
              'on_hold' => 'On Hold',
              'completed' => 'Completed',
              'cancelled' => 'Cancelled',
            ];
            $progressColor = $project->progress >= 50 ? 'var(--clsu-green)' : 'var(--clsu-gold)';
          @endphp
          <tr>
            <td class="px-4 py-3">
              <div class="fw-bold">{{ $project->name }}</div>
              <small class="text-muted">{{ Str::limit($project->description, 50) }}</small>
            </td>
            <td class="py-3"><span class="badge" style="background: var(--clsu-green);">{{ $project->category }}</span></td>
            <td class="py-3">{{ $project->start_date->format('M Y') }} - {{ $project->end_date->format('M Y') }}</td>
            <td class="py-3">₱{{ number_format($project->budget, 0) }}</td>
            <td class="py-3"><span class="badge {{ $statusColors[$project->status] ?? 'bg-secondary' }}">{{ $statusLabels[$project->status] ?? ucfirst($project->status) }}</span></td>
            <td class="py-3">
              <div class="progress" style="height: 8px;">
                <div class="progress-bar" style="width: {{ $project->progress }}%; background: {{ $progressColor }};"></div>
              </div>
              <small class="text-muted">{{ $project->progress }}%</small>
            </td>
            <td class="py-3 text-end pe-4">
              <div class="btn-group btn-group-sm">
                <button class="btn btn-sm btn-view-project" style="color: var(--clsu-green); border-color: var(--clsu-green);"
                  data-id="{{ $project->id }}"
                  data-code="{{ $project->project_code }}"
                  data-name="{{ $project->name }}"
                  data-description="{{ $project->description }}"
                  data-category="{{ $project->category }}"
                  data-budget="{{ number_format($project->budget, 2) }}"
                  data-start="{{ $project->start_date->format('M d, Y') }}"
                  data-end="{{ $project->end_date->format('M d, Y') }}"
                  data-timeline="{{ $project->start_date->format('M Y') }} - {{ $project->end_date->format('M Y') }}"
                  data-status="{{ $statusLabels[$project->status] ?? ucfirst($project->status) }}"
                  data-progress="{{ $project->progress }}">View</button>
                <button class="btn btn-sm btn-edit-project" style="color: var(--clsu-gold); border-color: var(--clsu-gold);"
                  data-id="{{ $project->id }}"
                  data-name="{{ $project->name }}"
                  data-description="{{ $project->description }}"
                  data-category="{{ $project->category }}"
                  data-budget="{{ $project->budget }}"
                  data-start="{{ $project->start_date->format('Y-m-d') }}"
                  data-end="{{ $project->end_date->format('Y-m-d') }}"
                  data-status="{{ $project->status }}"
                  data-progress="{{ $project->progress }}">Edit</button>
                <button class="btn btn-sm btn-delete-project" style="color: #dc3545; border-color: #dc3545;"
                  data-id="{{ $project->id }}"
                  data-name="{{ $project->name }}">Delete</button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-5 text-muted">
              <svg width="48" height="48" fill="currentColor" viewBox="0 0 24 24" class="mb-2 d-block mx-auto opacity-25">
                <path d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-6 10H6v-2h8v2zm4-4H6v-2h12v2z"/>
              </svg>
              No property records found. Click "New Property" to get started.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- New Project Modal -->
<div class="modal fade" id="newProjectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Add New Property</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form id="newProjectForm">
          <div class="row g-3">
            <div class="col-12">
              <label for="projectName" class="form-label fw-semibold">Property Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3" id="projectName" name="name" required>
            </div>

            <div class="col-12">
              <label for="projectDescription" class="form-label fw-semibold">Description</label>
              <textarea class="form-control rounded-3" id="projectDescription" name="description" rows="3"></textarea>
            </div>

            <div class="col-md-6">
              <label for="projectCategory" class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
              <select class="form-select rounded-3" id="projectCategory" name="category" required>
                <option value="">Select category</option>
                <option value="Infrastructure">Infrastructure</option>
                <option value="Technology">Technology</option>
                <option value="Academic">Academic</option>
                <option value="Research">Research</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="projectBudget" class="form-label fw-semibold">Value (₱) <span class="text-danger">*</span></label>
              <input type="number" class="form-control rounded-3" id="projectBudget" name="budget" step="0.01" required>
            </div>

            <div class="col-md-6">
              <label for="projectStartDate" class="form-label fw-semibold">Acquisition Date <span class="text-danger">*</span></label>
              <input type="date" class="form-control rounded-3" id="projectStartDate" name="start_date" required>
            </div>

            <div class="col-md-6">
              <label for="projectEndDate" class="form-label fw-semibold">Warranty End <span class="text-danger">*</span></label>
              <input type="date" class="form-control rounded-3" id="projectEndDate" name="end_date" required>
            </div>

            <div class="col-md-6">
              <label for="projectStatus" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
              <select class="form-select rounded-3" id="projectStatus" name="status" required>
                <option value="">Select status</option>
                <option value="active">Active</option>
                <option value="on_hold">On Hold</option>
                <option value="completed">Completed</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="projectProgress" class="form-label fw-semibold">Initial Progress (%)</label>
              <input type="number" class="form-control rounded-3" id="projectProgress" name="progress" min="0" max="100" value="0">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn rounded-3" style="color: var(--clsu-gold); border-color: var(--clsu-gold);" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="newProjectForm" class="btn text-white rounded-3" style="background: var(--clsu-green);">Add Property</button>
      </div>
    </div>
  </div>
</div>

<!-- View Project Modal -->
<div class="modal fade" id="viewProjectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Property Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row g-3">
          <div class="col-12">
            <h4 class="fw-bold mb-1" id="viewProjectName"></h4>
            <span class="badge bg-light text-dark font-monospace small" id="viewProjectCode"></span>
          </div>
          <div class="col-12">
            <p class="text-muted" id="viewProjectDescription"></p>
          </div>

          <div class="col-md-6">
            <label class="form-label text-muted small">Category</label>
            <div><span id="viewProjectCategory" class="badge" style="background: var(--clsu-green);"></span></div>
          </div>

          <div class="col-md-6">
            <label class="form-label text-muted small">Status</label>
            <div><span id="viewProjectStatus" class="badge bg-success"></span></div>
          </div>

          <div class="col-md-6">
            <label class="form-label text-muted small">Timeline</label>
            <div class="fw-semibold" id="viewProjectTimeline"></div>
          </div>

          <div class="col-md-6">
            <label class="form-label text-muted small">Value</label>
            <div class="fw-semibold" id="viewProjectBudget"></div>
          </div>

          <div class="col-12">
            <label class="form-label text-muted small">Progress</label>
            <div class="progress" style="height: 12px;">
              <div id="viewProjectProgress" class="progress-bar" style="background: var(--clsu-green);"></div>
            </div>
            <small class="text-muted" id="viewProjectProgressText"></small>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn rounded-3" style="color: var(--clsu-green); border-color: var(--clsu-green);" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Project Modal -->
<div class="modal fade" id="editProjectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Edit Property</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form id="editProjectForm">
          <input type="hidden" id="editProjectId">
          <div class="row g-3">
            <div class="col-12">
              <label for="editProjectName" class="form-label fw-semibold">Property Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3" id="editProjectName" required>
            </div>

            <div class="col-12">
              <label for="editProjectDescription" class="form-label fw-semibold">Description</label>
              <textarea class="form-control rounded-3" id="editProjectDescription" rows="3"></textarea>
            </div>

            <div class="col-md-6">
              <label for="editProjectCategory" class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
              <select class="form-select rounded-3" id="editProjectCategory" required>
                <option value="">Select category</option>
                <option value="Infrastructure">Infrastructure</option>
                <option value="Technology">Technology</option>
                <option value="Academic">Academic</option>
                <option value="Research">Research</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="editProjectBudget" class="form-label fw-semibold">Value (₱) <span class="text-danger">*</span></label>
              <input type="number" class="form-control rounded-3" id="editProjectBudget" step="0.01" required>
            </div>

            <div class="col-md-6">
              <label for="editProjectStartDate" class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
              <input type="date" class="form-control rounded-3" id="editProjectStartDate" required>
            </div>

            <div class="col-md-6">
              <label for="editProjectEndDate" class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
              <input type="date" class="form-control rounded-3" id="editProjectEndDate" required>
            </div>

            <div class="col-md-6">
              <label for="editProjectStatus" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
              <select class="form-select rounded-3" id="editProjectStatus" required>
                <option value="">Select status</option>
                <option value="active">Active</option>
                <option value="on_hold">On Hold</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="editProjectProgress" class="form-label fw-semibold">Progress (%)</label>
              <input type="number" class="form-control rounded-3" id="editProjectProgress" min="0" max="100" required>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn rounded-3" style="color: var(--clsu-gold); border-color: var(--clsu-gold);" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="editProjectForm" class="btn text-white rounded-3" style="background: var(--clsu-green);">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteProjectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Delete Property</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" id="deleteProjectId">
        <div class="text-center mb-3">
          <svg width="48" height="48" fill="#dc3545" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
          </svg>
        </div>
        <p class="text-center mb-1">Are you sure you want to delete this property record?</p>
        <p class="text-center fw-bold" id="deleteProjectName"></p>
        <div class="alert alert-danger rounded-3 small mt-3 mb-0">
          <strong>Warning:</strong> This action cannot be undone.
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 justify-content-center">
        <button type="button" class="btn rounded-3 px-4" style="color: var(--clsu-green); border-color: var(--clsu-green);" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn rounded-3 px-4 text-white bg-danger" id="confirmDeleteBtn">Delete Property</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// ==========================================
// Create Project (AJAX)
// ==========================================
document.getElementById('newProjectForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const btn = this.closest('.modal-content').querySelector('[type="submit"]');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Creating...';

  const formData = {
    name: document.getElementById('projectName').value,
    description: document.getElementById('projectDescription').value,
    category: document.getElementById('projectCategory').value,
    budget: document.getElementById('projectBudget').value,
    start_date: document.getElementById('projectStartDate').value,
    end_date: document.getElementById('projectEndDate').value,
    status: document.getElementById('projectStatus').value,
    progress: document.getElementById('projectProgress').value || 0,
  };

  fetch('/pso/projects', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    body: JSON.stringify(formData)
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) { alert(data.message); location.reload(); }
    else { alert('Error: ' + (data.message || 'Something went wrong')); btn.disabled = false; btn.textContent = 'Create Project'; }
  })
  .catch(err => {
    console.error(err);
    alert('An error occurred. Please check your inputs.');
    btn.disabled = false; btn.textContent = 'Create Project';
  });
});

// ==========================================
// View Project
// ==========================================
document.querySelectorAll('.btn-view-project').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('viewProjectName').textContent = this.dataset.name;
    document.getElementById('viewProjectCode').textContent = this.dataset.code;
    document.getElementById('viewProjectDescription').textContent = this.dataset.description || 'No description';
    document.getElementById('viewProjectCategory').textContent = this.dataset.category;
    document.getElementById('viewProjectStatus').textContent = this.dataset.status;
    document.getElementById('viewProjectTimeline').textContent = this.dataset.timeline;
    document.getElementById('viewProjectBudget').textContent = '₱' + this.dataset.budget;
    document.getElementById('viewProjectProgress').style.width = this.dataset.progress + '%';
    document.getElementById('viewProjectProgressText').textContent = this.dataset.progress + '%';
    new bootstrap.Modal(document.getElementById('viewProjectModal')).show();
  });
});

// ==========================================
// Edit Project
// ==========================================
document.querySelectorAll('.btn-edit-project').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('editProjectId').value = this.dataset.id;
    document.getElementById('editProjectName').value = this.dataset.name;
    document.getElementById('editProjectDescription').value = this.dataset.description;
    document.getElementById('editProjectCategory').value = this.dataset.category;
    document.getElementById('editProjectBudget').value = this.dataset.budget;
    document.getElementById('editProjectStartDate').value = this.dataset.start;
    document.getElementById('editProjectEndDate').value = this.dataset.end;
    document.getElementById('editProjectStatus').value = this.dataset.status;
    document.getElementById('editProjectProgress').value = this.dataset.progress;
    new bootstrap.Modal(document.getElementById('editProjectModal')).show();
  });
});

// ==========================================
// Update Project (AJAX)
// ==========================================
document.getElementById('editProjectForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const id = document.getElementById('editProjectId').value;
  const btn = this.closest('.modal-content').querySelector('[type="submit"]');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

  const formData = {
    name: document.getElementById('editProjectName').value,
    description: document.getElementById('editProjectDescription').value,
    category: document.getElementById('editProjectCategory').value,
    budget: document.getElementById('editProjectBudget').value,
    start_date: document.getElementById('editProjectStartDate').value,
    end_date: document.getElementById('editProjectEndDate').value,
    status: document.getElementById('editProjectStatus').value,
    progress: document.getElementById('editProjectProgress').value,
  };

  fetch(`/pso/projects/${id}`, {
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
// Delete Project (AJAX)
// ==========================================
document.querySelectorAll('.btn-delete-project').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('deleteProjectId').value = this.dataset.id;
    document.getElementById('deleteProjectName').textContent = this.dataset.name;
    new bootstrap.Modal(document.getElementById('deleteProjectModal')).show();
  });
});

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
  const id = document.getElementById('deleteProjectId').value;
  this.disabled = true;
  this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Deleting...';

  fetch(`/pso/projects/${id}`, {
    method: 'DELETE',
    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) { alert(data.message); location.reload(); }
    else { alert('Error: ' + (data.message || 'Something went wrong')); this.disabled = false; this.textContent = 'Delete Project'; }
  })
  .catch(err => {
    console.error(err);
    alert('An error occurred.');
    this.disabled = false; this.textContent = 'Delete Project';
  });
});
</script>
@endsection
