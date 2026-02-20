@extends('admin.admin-layout')

@section('title','Edit Service')
@section('crumb','Edit Service')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary rounded-4">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
      </svg>
    </a>
    <div>
      <h1 class="h3 fw-bold mb-1">Edit Service</h1>
      <div class="text-muted">Update {{ $service->title }}</div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <form action="{{ route('admin.services.update', $service) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label for="title" class="form-label fw-bold">Service Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control rounded-3 @error('title') is-invalid @enderror" 
                   id="title" name="title" value="{{ old('title', $service->title) }}" required>
            @error('title')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="slug" class="form-label fw-bold">Slug <span class="text-danger">*</span></label>
            <input type="text" class="form-control rounded-3 @error('slug') is-invalid @enderror" 
                   id="slug" name="slug" value="{{ old('slug', $service->slug) }}" required>
            <small class="text-muted">URL-friendly identifier (e.g., document-request)</small>
            @error('slug')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="office_id" class="form-label fw-bold">Office <span class="text-danger">*</span></label>
            <select class="form-select rounded-3 @error('office_id') is-invalid @enderror" 
                    id="office_id" name="office_id" required>
              <option value="">Select Office</option>
              @foreach($offices as $office)
                <option value="{{ $office->id }}" {{ old('office_id', $service->office_id) == $office->id ? 'selected' : '' }}>
                  {{ $office->name }} ({{ $office->acronym }})
                </option>
              @endforeach
            </select>
            @error('office_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea class="form-control rounded-3 @error('description') is-invalid @enderror" 
                      id="description" name="description" rows="4">{{ old('description', $service->description) }}</textarea>
            <small class="text-muted">Brief description of the service</small>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="order" class="form-label fw-bold">Display Order <span class="text-danger">*</span></label>
            <input type="number" class="form-control rounded-3 @error('order') is-invalid @enderror" 
                   id="order" name="order" value="{{ old('order', $service->order) }}" min="0" required>
            <small class="text-muted">Lower numbers appear first</small>
            @error('order')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                     value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
              <label class="form-check-label fw-bold" for="is_active">
                Active
              </label>
              <small class="d-block text-muted">Inactive services won't be displayed publicly</small>
            </div>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-gold rounded-4 px-4">
              <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              Update Service
            </button>
            <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary rounded-4 px-4">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card rounded-4 border bg-light">
      <div class="card-body">
        <h5 class="fw-bold mb-3">Service Information</h5>
        <div class="small">
          <div class="mb-2">
            <span class="text-muted">Created:</span>
            <span class="fw-bold">{{ $service->created_at->format('M d, Y') }}</span>
          </div>
          <div class="mb-2">
            <span class="text-muted">Last Updated:</span>
            <span class="fw-bold">{{ $service->updated_at->format('M d, Y') }}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="card rounded-4 border bg-light mt-3">
      <div class="card-body">
        <h5 class="fw-bold mb-3">Tips</h5>
        <ul class="small text-muted mb-0">
          <li class="mb-2">Changing the slug may break existing links</li>
          <li class="mb-2">Deactivating a service hides it from public view</li>
          <li>Adjust display order to reorganize service listings</li>
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection
