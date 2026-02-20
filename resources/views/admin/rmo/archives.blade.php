@extends('admin.rmo-layout')

@section('title', 'Archives')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="mb-4">
  <h1 class="h3 fw-bold mb-1">Archives</h1>
  <p class="text-muted mb-0">Manage and retrieve archived records</p>
</div>

<!-- Archive Stats -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body p-4 text-center">
        <div class="h2 fw-bold mb-2" style="color: var(--rmo-orange);">{{ $stats['total_archived'] }}</div>
        <div class="text-muted">Total Archived</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body p-4 text-center">
        <div class="h2 fw-bold mb-2 text-info">{{ $stats['digital'] }}</div>
        <div class="text-muted">Digitized</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body p-4 text-center">
        <div class="h2 fw-bold mb-2 text-warning">{{ $stats['physical_only'] }}</div>
        <div class="text-muted">Physical Only</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card rounded-4 border">
      <div class="card-body p-4 text-center">
        <div class="h2 fw-bold mb-2 text-success">{{ $stats['retrieved_this_month'] }}</div>
        <div class="text-muted">Retrieved (This Month)</div>
      </div>
    </div>
  </div>
</div>

<!-- Advanced Search -->
<div class="card rounded-4 border mb-4">
  <div class="card-body p-4">
    <h5 class="fw-bold mb-3">Archive Search</h5>
    <form method="GET" action="{{ route('rmo.archives') }}">
      <div class="row g-3">
        <div class="col-md-4">
          <input type="text" name="search" class="form-control" placeholder="Search by keywords, reference no., or title..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
          <select name="category" class="form-select">
            <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>All Categories</option>
            <option value="administrative" {{ request('category') == 'administrative' ? 'selected' : '' }}>Administrative</option>
            <option value="academic" {{ request('category') == 'academic' ? 'selected' : '' }}>Academic</option>
            <option value="legal" {{ request('category') == 'legal' ? 'selected' : '' }}>Legal</option>
            <option value="financial" {{ request('category') == 'financial' ? 'selected' : '' }}>Financial</option>
            <option value="report" {{ request('category') == 'report' ? 'selected' : '' }}>Report</option>
            <option value="personnel" {{ request('category') == 'personnel' ? 'selected' : '' }}>Personnel</option>
            <option value="infrastructure" {{ request('category') == 'infrastructure' ? 'selected' : '' }}>Infrastructure</option>
          </select>
        </div>
        <div class="col-md-2">
          <select name="year" class="form-select">
            <option value="all" {{ request('year') == 'all' ? 'selected' : '' }}>All Years</option>
            @for($y = date('Y'); $y >= 2018; $y--)
              <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn w-100 text-white" style="background: #009639;">Search Archive</button>
        </div>
        @if(request('search') || (request('category') && request('category') != 'all') || (request('year') && request('year') != 'all'))
        <div class="col-md-2">
          <a href="{{ route('rmo.archives') }}" class="btn btn-outline-secondary w-100">Clear Filters</a>
        </div>
        @endif
      </div>
    </form>
  </div>
</div>

<!-- Archives List -->
<div class="card rounded-4 border">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="bg-light">
          <tr>
            <th class="px-4 py-3">Record Title</th>
            <th class="py-3">Type</th>
            <th class="py-3">Archived Date</th>
            <th class="py-3">Reference No.</th>
            <th class="py-3">Format</th>
            <th class="py-3 text-end pe-4">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($documents as $doc)
          @php
            $categoryColors = [
              'administrative' => 'bg-info',
              'academic' => 'bg-primary',
              'legal' => 'bg-secondary',
              'financial' => 'bg-warning text-dark',
              'report' => 'bg-info',
              'personnel' => 'bg-primary',
              'infrastructure' => 'bg-secondary',
            ];
          @endphp
          <tr>
            <td class="px-4 py-3">
              <div class="fw-bold">{{ $doc->name }}</div>
              <small class="text-muted">{{ Str::limit($doc->description, 60) ?? 'No description' }}</small>
            </td>
            <td class="py-3">
              <span class="badge {{ $categoryColors[$doc->category] ?? 'bg-secondary' }}">{{ ucfirst($doc->category) }}</span>
            </td>
            <td class="py-3">{{ $doc->archived_at ? $doc->archived_at->format('M d, Y') : 'N/A' }}</td>
            <td class="py-3"><span class="font-monospace small">{{ $doc->reference_no }}</span></td>
            <td class="py-3">
              @if($doc->file_path)
                <span class="badge bg-success">Digital & Physical</span>
              @else
                <span class="badge bg-warning text-dark">Physical Only</span>
              @endif
            </td>
            <td class="py-3 text-end pe-4">
              <div class="btn-group btn-group-sm">
                {{-- View Details --}}
                <button class="btn btn-sm btn-outline-info btn-view-archive"
                  data-name="{{ $doc->name }}"
                  data-description="{{ $doc->description }}"
                  data-category="{{ ucfirst($doc->category) }}"
                  data-reference="{{ $doc->reference_no }}"
                  data-archived-at="{{ $doc->archived_at ? $doc->archived_at->format('M d, Y h:i A') : 'N/A' }}"
                  data-file-name="{{ $doc->file_name }}"
                  data-file-size="{{ $doc->file_size ? number_format($doc->file_size / 1024, 1) . ' KB' : 'N/A' }}"
                  data-has-file="{{ $doc->file_path ? '1' : '0' }}">
                  <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24" class="me-1"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                  View
                </button>
                {{-- Download / Retrieve --}}
                @if($doc->file_path)
                <a href="{{ route('rmo.documents.download', $doc) }}" class="btn btn-sm btn-outline-primary">
                  <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24" class="me-1"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                  Retrieve
                </a>
                @else
                <button class="btn btn-sm btn-outline-primary btn-digitize-doc"
                  data-id="{{ $doc->id }}"
                  data-name="{{ $doc->name }}">
                  <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24" class="me-1"><path d="M19.35 10.04A7.49 7.49 0 0 0 12 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 0 0 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/></svg>
                  Digitize
                </button>
                @endif
                {{-- Restore to Active --}}
                <button class="btn btn-sm btn-outline-success btn-restore-archive"
                  data-id="{{ $doc->id }}"
                  data-name="{{ $doc->name }}">
                  <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24" class="me-1"><path d="M13 3a9 9 0 0 0-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42A8.954 8.954 0 0 0 13 21a9 9 0 0 0 0-18zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/></svg>
                  Restore
                </button>
                {{-- Delete Permanently --}}
                <button class="btn btn-sm btn-outline-danger btn-delete-archive"
                  data-id="{{ $doc->id }}"
                  data-name="{{ $doc->name }}">
                  <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24" class="me-1"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                  Delete
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-4 text-muted">
              @if(request('search') || (request('category') && request('category') != 'all') || (request('year') && request('year') != 'all'))
                No archived records found matching your search criteria.
              @else
                No archived records found.
              @endif
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($documents->hasPages())
    <div class="p-3 border-top">
      {{ $documents->appends(request()->query())->links() }}
    </div>
    @endif
  </div>
</div>

<!-- View Archive Details Modal -->
<div class="modal fade" id="viewArchiveModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Archived Record Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row g-3">
          <div class="col-12">
            <h5 class="fw-bold mb-0" id="archViewName"></h5>
          </div>
          <div class="col-12">
            <label class="form-label text-muted small">Description</label>
            <div class="p-3 bg-light rounded-3" id="archViewDesc"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Category</label>
            <div class="fw-semibold" id="archViewCategory"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Reference No.</label>
            <div class="fw-semibold font-monospace" id="archViewRef"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Archived Date</label>
            <div class="fw-semibold" id="archViewDate"></div>
          </div>
          <div class="col-md-6">
            <label class="form-label text-muted small">Format</label>
            <div id="archViewFormat"></div>
          </div>
          <div class="col-md-6" id="archFileNameWrap">
            <label class="form-label text-muted small">File Name</label>
            <div class="fw-semibold" id="archViewFileName"></div>
          </div>
          <div class="col-md-6" id="archFileSizeWrap">
            <label class="form-label text-muted small">File Size</label>
            <div class="fw-semibold" id="archViewFileSize"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Restore Confirmation Modal -->
<div class="modal fade" id="restoreArchiveModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Restore Archived Record</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" id="restoreDocId">
        <div class="text-center mb-3">
          <svg width="48" height="48" fill="#198754" viewBox="0 0 24 24">
            <path d="M13 3a9 9 0 0 0-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42A8.954 8.954 0 0 0 13 21a9 9 0 0 0 0-18zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/>
          </svg>
        </div>
        <p class="text-center mb-1">Are you sure you want to restore this record to active documents?</p>
        <p class="text-center fw-bold" id="restoreDocName"></p>
        <div class="alert alert-info rounded-3 small mt-3 mb-0">
          <strong>Note:</strong> This record will be moved back to the active Documents list and removed from the Archives.
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 justify-content-center">
        <button type="button" class="btn rounded-3 px-4 btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn rounded-3 px-4 text-white btn-success" id="confirmRestoreBtn">Restore Record</button>
      </div>
    </div>
  </div>
</div>

<!-- Digitize Document Modal -->
<div class="modal fade" id="digitizeDocModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Digitize Document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="text-center mb-3">
          <svg width="48" height="48" fill="#009639" viewBox="0 0 24 24">
            <path d="M19.35 10.04A7.49 7.49 0 0 0 12 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 0 0 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/>
          </svg>
        </div>
        <p class="text-center mb-1">Upload a digital copy for this archived record:</p>
        <p class="text-center fw-bold" id="digitizeDocName"></p>
        <input type="hidden" id="digitizeDocId">
        <div class="mb-3">
          <label for="digitizeFile" class="form-label fw-bold">Select File <span class="text-danger">*</span></label>
          <input type="file" class="form-control rounded-3" id="digitizeFile" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
          <small class="text-muted">Accepted: PDF, DOC, DOCX, JPG, PNG (Max 10MB)</small>
        </div>
        <div class="alert alert-info rounded-3 small mt-3 mb-0">
          <strong>Note:</strong> This will attach a digital file to the physical-only record, changing its format to "Digital & Physical".
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 justify-content-center">
        <button type="button" class="btn rounded-3 px-4 btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn rounded-3 px-4 text-white" style="background: #009639;" id="confirmDigitizeBtn">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" class="me-1"><path d="M19.35 10.04A7.49 7.49 0 0 0 12 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 0 0 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/></svg>
          Upload & Digitize
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteArchiveModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold text-danger">Delete Archived Record</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" id="deleteDocId">
        <div class="text-center mb-3">
          <svg width="48" height="48" fill="#dc3545" viewBox="0 0 24 24">
            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
          </svg>
        </div>
        <p class="text-center mb-1">Are you sure you want to permanently delete this record?</p>
        <p class="text-center fw-bold text-danger" id="deleteDocName"></p>
        <div class="alert alert-danger rounded-3 small mt-3 mb-0">
          <strong>Warning:</strong> This action cannot be undone. The record and any associated files will be permanently removed.
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 justify-content-center">
        <button type="button" class="btn rounded-3 px-4 btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn rounded-3 px-4 btn-danger" id="confirmDeleteBtn">Delete Permanently</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// ==========================================
// View Archive Details
// ==========================================
document.querySelectorAll('.btn-view-archive').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('archViewName').textContent = this.dataset.name;
    document.getElementById('archViewDesc').textContent = this.dataset.description || 'No description';
    document.getElementById('archViewCategory').textContent = this.dataset.category;
    document.getElementById('archViewRef').textContent = this.dataset.reference;
    document.getElementById('archViewDate').textContent = this.dataset.archivedAt;

    const hasFile = this.dataset.hasFile === '1';
    document.getElementById('archViewFormat').innerHTML = hasFile
      ? '<span class="badge bg-success">Digital & Physical</span>'
      : '<span class="badge bg-warning text-dark">Physical Only</span>';

    document.getElementById('archFileNameWrap').style.display = hasFile ? '' : 'none';
    document.getElementById('archFileSizeWrap').style.display = hasFile ? '' : 'none';
    document.getElementById('archViewFileName').textContent = this.dataset.fileName || 'N/A';
    document.getElementById('archViewFileSize').textContent = this.dataset.fileSize || 'N/A';

    new bootstrap.Modal(document.getElementById('viewArchiveModal')).show();
  });
});

// ==========================================
// Restore Archive (AJAX)
// ==========================================
document.querySelectorAll('.btn-restore-archive').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('restoreDocId').value = this.dataset.id;
    document.getElementById('restoreDocName').textContent = this.dataset.name;
    new bootstrap.Modal(document.getElementById('restoreArchiveModal')).show();
  });
});

document.getElementById('confirmRestoreBtn').addEventListener('click', function() {
  const id = document.getElementById('restoreDocId').value;
  this.disabled = true;
  this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Restoring...';

  fetch(`/rmo/documents/${id}/restore`, {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) { alert(data.message); location.reload(); }
    else { alert('Error: ' + (data.message || 'Something went wrong')); this.disabled = false; this.innerHTML = 'Restore Record'; }
  })
  .catch(err => { console.error(err); alert('An error occurred.'); this.disabled = false; this.innerHTML = 'Restore Record'; });
});

// ==========================================
// Digitize Document (Upload File)
// ==========================================
document.querySelectorAll('.btn-digitize-doc').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('digitizeDocId').value = this.dataset.id;
    document.getElementById('digitizeDocName').textContent = this.dataset.name;
    document.getElementById('digitizeFile').value = '';
    new bootstrap.Modal(document.getElementById('digitizeDocModal')).show();
  });
});

document.getElementById('confirmDigitizeBtn').addEventListener('click', function() {
  const id = document.getElementById('digitizeDocId').value;
  const fileInput = document.getElementById('digitizeFile');
  if (!fileInput.files.length) { alert('Please select a file.'); return; }

  const formData = new FormData();
  formData.append('document_file', fileInput.files[0]);

  this.disabled = true;
  this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Uploading...';

  fetch(`/rmo/documents/${id}/digitize`, {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) { alert(data.message); location.reload(); }
    else { alert('Error: ' + (data.message || 'Something went wrong')); this.disabled = false; this.innerHTML = 'Upload & Digitize'; }
  })
  .catch(err => { console.error(err); alert('An error occurred.'); this.disabled = false; this.innerHTML = 'Upload & Digitize'; });
});

// ==========================================
// Delete Archive (AJAX)
// ==========================================
document.querySelectorAll('.btn-delete-archive').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('deleteDocId').value = this.dataset.id;
    document.getElementById('deleteDocName').textContent = this.dataset.name;
    new bootstrap.Modal(document.getElementById('deleteArchiveModal')).show();
  });
});

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
  const id = document.getElementById('deleteDocId').value;
  this.disabled = true;
  this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Deleting...';

  fetch(`/rmo/documents/${id}`, {
    method: 'DELETE',
    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) { alert(data.message); location.reload(); }
    else { alert('Error: ' + (data.message || 'Something went wrong')); this.disabled = false; this.innerHTML = 'Delete Permanently'; }
  })
  .catch(err => { console.error(err); alert('An error occurred.'); this.disabled = false; this.innerHTML = 'Delete Permanently'; });
});
</script>
@endsection
