@extends('admin.rmo-layout')

@section('title', 'Documents')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h1 class="h3 fw-bold mb-1">Documents</h1>
    <p class="text-muted mb-0">Manage university records and documents</p>
  </div>
  <button class="btn rounded-4 text-white" style="background: var(--clsu-green);" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" class="me-2">
      <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
    </svg>
    Add New Document
  </button>
</div>

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

<!-- Filters -->
<div class="card rounded-4 border mb-4">
  <div class="card-body p-4">
    <form method="GET" action="{{ route('rmo.documents') }}">
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label fw-bold small text-muted">Search</label>
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
              <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" class="text-muted">
                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
              </svg>
            </span>
            <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search documents..." value="{{ request('search') }}">
          </div>
        </div>
        <div class="col-md-3">
          <label class="form-label fw-bold small text-muted">Category</label>
          <select class="form-select" name="category">
            <option value="all">All Categories</option>
            <option value="academic" {{ request('category') == 'academic' ? 'selected' : '' }}>Academic Records</option>
            <option value="administrative" {{ request('category') == 'administrative' ? 'selected' : '' }}>Administrative</option>
            <option value="legal" {{ request('category') == 'legal' ? 'selected' : '' }}>Legal</option>
            <option value="financial" {{ request('category') == 'financial' ? 'selected' : '' }}>Financial</option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label fw-bold small text-muted">Status</label>
          <select class="form-select" name="status">
            <option value="all">All Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="restricted" {{ request('status') == 'restricted' ? 'selected' : '' }}>Restricted</option>
          </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button type="submit" class="btn btn-outline-secondary w-100">Filter</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Documents List -->
<div class="card rounded-4 border">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="bg-light">
          <tr>
            <th class="px-4 py-3">Document Name</th>
            <th class="py-3">Category</th>
            <th class="py-3">Reference No.</th>
            <th class="py-3">Date Added</th>
            <th class="py-3">Status</th>
            <th class="py-3 text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($documents as $document)
          <tr>
            <td class="px-4 py-3">
              <div class="fw-bold">{{ $document->name }}</div>
              <small class="text-muted">{{ $document->description ?? 'No description' }}</small>
            </td>
            <td class="py-3">
              @php
                $catColors = [
                  'administrative' => 'var(--clsu-green)',
                  'academic' => 'var(--clsu-green)',
                  'financial' => 'var(--clsu-gold)',
                  'legal' => '#dc3545',
                ];
                $catColor = $catColors[$document->category] ?? 'var(--clsu-green)';
              @endphp
              <span class="badge" style="background: {{ $catColor }};">{{ ucfirst($document->category) }}</span>
            </td>
            <td class="py-3">{{ $document->reference_no }}</td>
            <td class="py-3">{{ $document->created_at->format('M d, Y') }}</td>
            <td class="py-3">
              @if($document->status === 'active')
                <span class="badge bg-success">Active</span>
              @elseif($document->status === 'restricted')
                <span class="badge bg-secondary">Restricted</span>
              @elseif($document->status === 'pending')
                <span class="badge bg-warning text-dark">Pending</span>
              @else
                <span class="badge bg-secondary">{{ ucfirst($document->status) }}</span>
              @endif
            </td>
            <td class="py-3 text-end">
              <div class="btn-group btn-group-sm">
                <button class="btn btn-sm btn-view-doc" style="color: var(--clsu-green); border-color: var(--clsu-green);"
                        data-id="{{ $document->id }}"
                        data-name="{{ $document->name }}"
                        data-description="{{ $document->description }}"
                        data-category="{{ ucfirst($document->category) }}"
                        data-refno="{{ $document->reference_no }}"
                        data-date="{{ $document->created_at->format('M d, Y') }}"
                        data-status="{{ ucfirst($document->status) }}"
                        data-filename="{{ $document->file_name ?? 'No file' }}">View</button>
                @if($document->file_path)
                <a href="{{ route('rmo.documents.download', $document->id) }}" class="btn btn-sm" style="color: var(--clsu-gold); border-color: var(--clsu-gold);">Download</a>
                @else
                <button class="btn btn-sm" style="color: var(--clsu-gold); border-color: var(--clsu-gold);" disabled>Download</button>
                @endif
                <button class="btn btn-sm btn-archive-doc" style="color: #dc3545; border-color: #dc3545;"
                        data-id="{{ $document->id }}"
                        data-name="{{ $document->name }}">Archive</button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-5 text-muted">
              <svg width="48" height="48" fill="currentColor" viewBox="0 0 24 24" class="mb-2 d-block mx-auto opacity-25">
                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
              </svg>
              No documents found. Click "Add New Document" to get started.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($documents->hasPages())
    <div class="p-3 border-top">
      {{ $documents->appends(request()->query())->links() }}
    </div>
    @endif
  </div>
</div>

<!-- Add Document Modal -->
<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold" id="addDocumentModalLabel">Add New Document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <form action="{{ route('rmo.documents.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="mb-3">
            <label for="document_name" class="form-label fw-bold">Document Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control rounded-3" id="document_name" name="document_name" required>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea class="form-control rounded-3" id="description" name="description" rows="3"></textarea>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="category" class="form-label fw-bold">Category <span class="text-danger">*</span></label>
              <select class="form-select rounded-3" id="category" name="category" required>
                <option value="">Select Category</option>
                <option value="academic">Academic Records</option>
                <option value="administrative">Administrative</option>
                <option value="legal">Legal</option>
                <option value="financial">Financial</option>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label for="reference_no" class="form-label fw-bold">Reference Number <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3 bg-light" id="reference_no" name="reference_no" readonly required placeholder="Select a category first">
              <small class="text-muted">Auto-generated based on category</small>
            </div>
          </div>

          <div class="mb-3">
            <label for="document_file" class="form-label fw-bold">Upload Document <span class="text-danger">*</span></label>
            <input type="file" class="form-control rounded-3" id="document_file" name="document_file" accept=".pdf,.doc,.docx" required>
            <small class="text-muted">Accepted formats: PDF, DOC, DOCX (Max 10MB)</small>
          </div>

          <div class="mb-3">
            <label for="status" class="form-label fw-bold">Status</label>
            <select class="form-select rounded-3" id="status" name="status">
              <option value="active" selected>Active</option>
              <option value="pending">Pending</option>
              <option value="restricted">Restricted</option>
            </select>
          </div>

          <div class="d-flex gap-2 justify-content-end mt-4">
            <button type="button" class="btn rounded-4 px-4" style="color: var(--clsu-gold); border-color: var(--clsu-gold);" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn rounded-4 px-4 text-white" style="background: var(--clsu-green);">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" class="me-1">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
              </svg>
              Add Document
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- View Document Modal -->
<div class="modal fade" id="viewDocumentModal" tabindex="-1" aria-labelledby="viewDocumentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold" id="viewDocumentModalLabel">Document Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row g-3">
          <div class="col-12">
            <h4 class="fw-bold mb-1" id="viewDocName"></h4>
            <p class="text-muted" id="viewDocDescription"></p>
          </div>
          
          <div class="col-md-6">
            <label class="form-label text-muted small">Category</label>
            <div><span id="viewDocCategory" class="badge" style="background: var(--clsu-green);"></span></div>
          </div>
          
          <div class="col-md-6">
            <label class="form-label text-muted small">Status</label>
            <div><span id="viewDocStatus" class="badge bg-success"></span></div>
          </div>
          
          <div class="col-md-6">
            <label class="form-label text-muted small">Reference Number</label>
            <div class="fw-semibold" id="viewDocRefNo"></div>
          </div>
          
          <div class="col-md-6">
            <label class="form-label text-muted small">Date Added</label>
            <div class="fw-semibold" id="viewDocDate"></div>
          </div>

          <div class="col-12 mt-3">
            <div class="border rounded-3 p-4 text-center bg-light">
              <svg width="48" height="48" fill="var(--clsu-green)" viewBox="0 0 24 24" class="mb-2">
                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
              </svg>
              <div class="fw-semibold" id="viewDocFileName">Document File</div>
              <small class="text-muted">PDF Document</small>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn rounded-3" style="color: var(--clsu-green); border-color: var(--clsu-green);" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Archive Confirmation Modal -->
<div class="modal fade" id="archiveDocumentModal" tabindex="-1" aria-labelledby="archiveDocumentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold" id="archiveDocumentModalLabel">Archive Document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="text-center mb-3">
          <svg width="48" height="48" fill="#dc3545" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
          </svg>
        </div>
        <p class="text-center mb-1">Are you sure you want to archive this document?</p>
        <p class="text-center fw-bold" id="archiveDocName"></p>
        <p class="text-center text-muted small">This action will move the document to the Archives section. You can restore it later.</p>
      </div>
      <div class="modal-footer border-0 pt-0 justify-content-center">
        <button type="button" class="btn rounded-3 px-4" style="color: var(--clsu-green); border-color: var(--clsu-green);" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn rounded-3 px-4 text-white" style="background: #dc3545;" id="confirmArchiveBtn">Archive Document</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
// Handle View Button Clicks
document.querySelectorAll('.btn-view-doc').forEach(button => {
  button.addEventListener('click', function() {
    document.getElementById('viewDocName').textContent = this.dataset.name;
    document.getElementById('viewDocDescription').textContent = this.dataset.description || 'No description';
    document.getElementById('viewDocCategory').textContent = this.dataset.category;
    document.getElementById('viewDocRefNo').textContent = this.dataset.refno;
    document.getElementById('viewDocDate').textContent = this.dataset.date;
    document.getElementById('viewDocFileName').textContent = this.dataset.filename;
    
    // Update status badge
    const statusBadge = document.getElementById('viewDocStatus');
    statusBadge.textContent = this.dataset.status;
    statusBadge.className = 'badge';
    if (this.dataset.status === 'Active') statusBadge.classList.add('bg-success');
    else if (this.dataset.status === 'Restricted') statusBadge.classList.add('bg-secondary');
    else statusBadge.classList.add('bg-warning', 'text-dark');
    
    const modal = new bootstrap.Modal(document.getElementById('viewDocumentModal'));
    modal.show();
  });
});

// Handle Archive Button Clicks
let archiveDocId = null;
document.querySelectorAll('.btn-archive-doc').forEach(button => {
  button.addEventListener('click', function() {
    archiveDocId = this.dataset.id;
    document.getElementById('archiveDocName').textContent = this.dataset.name;
    
    const modal = new bootstrap.Modal(document.getElementById('archiveDocumentModal'));
    modal.show();
  });
});

// Confirm Archive
document.getElementById('confirmArchiveBtn').addEventListener('click', function() {
  if (archiveDocId) {
    fetch(`/rmo/documents/${archiveDocId}/archive`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Close modal and reload page
        const modal = bootstrap.Modal.getInstance(document.getElementById('archiveDocumentModal'));
        modal.hide();
        window.location.reload();
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Failed to archive document. Please try again.');
    });
  }
});
// ==========================================
// Auto-Generate Reference Number
// ==========================================
const categoryPrefixes = {
  'academic': 'ACAD',
  'administrative': 'ADMN',
  'legal': 'LEGL',
  'financial': 'FINC',
  'report': 'RPT',
  'personnel': 'PER',
  'infrastructure': 'INF'
};

document.getElementById('category').addEventListener('change', function() {
  const refInput = document.getElementById('reference_no');
  const cat = this.value;
  if (!cat) { refInput.value = ''; return; }

  const prefix = categoryPrefixes[cat] || cat.substring(0, 4).toUpperCase();
  const year = new Date().getFullYear();

  // Count existing documents with the same prefix-year to determine next number
  const existingRefs = [];
  document.querySelectorAll('td .font-monospace, td').forEach(td => {
    const text = td.textContent.trim();
    if (text.startsWith(prefix + '-' + year + '-')) {
      const num = parseInt(text.split('-').pop());
      if (!isNaN(num)) existingRefs.push(num);
    }
  });

  // Also check from the server for accuracy
  fetch(`/rmo/documents/next-ref?prefix=${prefix}&year=${year}`, {
    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
  })
  .then(r => r.json())
  .then(data => { refInput.value = data.reference_no; })
  .catch(() => {
    // Fallback: use client-side count
    const maxNum = existingRefs.length > 0 ? Math.max(...existingRefs) : 0;
    refInput.value = `${prefix}-${year}-${String(maxNum + 1).padStart(3, '0')}`;
  });
});

// Reset reference when modal opens
document.getElementById('addDocumentModal').addEventListener('show.bs.modal', function() {
  document.getElementById('reference_no').value = '';
  document.getElementById('category').value = '';
});
</script>
@endsection
