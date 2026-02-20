@extends('admin.admin-layout')

@section('title','Create Program')
@section('crumb','Create Program')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <a href="{{ route('admin.programs.index') }}" class="btn btn-outline-secondary rounded-4">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
      </svg>
    </a>
    <div>
      <h1 class="h3 fw-bold mb-1">Create New Program</h1>
      <div class="text-muted">Add a new employee program to ADSO</div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <form action="{{ route('admin.programs.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label for="title" class="form-label fw-bold">Program Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control rounded-3 @error('title') is-invalid @enderror" 
                   id="title" name="title" value="{{ old('title') }}" required>
            @error('title')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="slug" class="form-label fw-bold">Slug <span class="text-danger">*</span></label>
            <input type="text" class="form-control rounded-3 @error('slug') is-invalid @enderror" 
                   id="slug" name="slug" value="{{ old('slug') }}" required>
            <small class="text-muted">URL-friendly identifier (e.g., health-insurance)</small>
            @error('slug')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea class="form-control rounded-3 @error('description') is-invalid @enderror" 
                      id="description" name="description" rows="4">{{ old('description') }}</textarea>
            <small class="text-muted">Brief description of the program</small>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="order" class="form-label fw-bold">Display Order <span class="text-danger">*</span></label>
            <input type="number" class="form-control rounded-3 @error('order') is-invalid @enderror" 
                   id="order" name="order" value="{{ old('order', 0) }}" min="0" required>
            <small class="text-muted">Lower numbers appear first</small>
            @error('order')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                     value="1" {{ old('is_active', true) ? 'checked' : '' }}>
              <label class="form-check-label fw-bold" for="is_active">
                Active
              </label>
              <small class="d-block text-muted">Inactive programs won't be displayed publicly</small>
            </div>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-gold rounded-4 px-4">
              <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              Create Program
            </button>
            <a href="{{ route('admin.programs.index') }}" class="btn btn-outline-secondary rounded-4 px-4">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card rounded-4 border bg-light">
      <div class="card-body">
        <h5 class="fw-bold mb-3">Tips</h5>
        <ul class="small text-muted mb-0">
          <li class="mb-2">Use clear, descriptive titles for programs</li>
          <li class="mb-2">Slugs should be lowercase with hyphens</li>
          <li class="mb-2">The description helps employees understand the program</li>
          <li>Use display order to control how programs appear in lists</li>
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection
