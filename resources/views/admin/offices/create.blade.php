@extends('admin.admin-layout')

@section('title','Create Office')
@section('crumb','Create Office')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <a href="{{ route('admin.offices.index') }}" class="btn btn-outline-secondary rounded-4">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
      </svg>
    </a>
    <div>
      <h1 class="h3 fw-bold mb-1">Create New Office</h1>
      <div class="text-muted">Add a new office to ADSO</div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <form action="{{ route('admin.offices.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label for="name" class="form-label fw-bold">Office Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="code" class="form-label fw-bold">Office Code <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3 @error('code') is-invalid @enderror" 
                     id="code" name="code" value="{{ old('code') }}" required>
              <small class="text-muted">Unique identifier (e.g., HRMO, PROPERTY)</small>
              @error('code')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6 mb-3">
              <label for="acronym" class="form-label fw-bold">Acronym <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-3 @error('acronym') is-invalid @enderror" 
                     id="acronym" name="acronym" value="{{ old('acronym') }}" required>
              @error('acronym')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="mb-3">
            <label for="overview" class="form-label fw-bold">Overview</label>
            <textarea class="form-control rounded-3 @error('overview') is-invalid @enderror" 
                      id="overview" name="overview" rows="4">{{ old('overview') }}</textarea>
            <small class="text-muted">Brief description of the office</small>
            @error('overview')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="parent_id" class="form-label fw-bold">Parent Office</label>
              <select class="form-select rounded-3 @error('parent_id') is-invalid @enderror" 
                      id="parent_id" name="parent_id">
                <option value="">Select Parent Office</option>
                @foreach($parentOffices as $parent)
                  <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                    {{ $parent->name }} ({{ $parent->acronym }})
                  </option>
                @endforeach
              </select>
              @error('parent_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6 mb-3">
              <label for="order" class="form-label fw-bold">Display Order <span class="text-danger">*</span></label>
              <input type="number" class="form-control rounded-3 @error('order') is-invalid @enderror" 
                     id="order" name="order" value="{{ old('order', 0) }}" min="0" required>
              <small class="text-muted">Lower numbers appear first</small>
              @error('order')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="mb-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                     value="1" {{ old('is_active', true) ? 'checked' : '' }}>
              <label class="form-check-label fw-bold" for="is_active">
                Active
              </label>
              <small class="d-block text-muted">Inactive offices won't be displayed publicly</small>
            </div>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-gold rounded-4 px-4">
              <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              Create Office
            </button>
            <a href="{{ route('admin.offices.index') }}" class="btn btn-outline-secondary rounded-4 px-4">Cancel</a>
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
          <li class="mb-2">Use clear, descriptive names for offices</li>
          <li class="mb-2">Office codes should be uppercase and unique</li>
          <li class="mb-2">The overview helps users understand the office's purpose</li>
          <li class="mb-2">Set parent office to create a hierarchy</li>
          <li>Use display order to control how offices appear in lists</li>
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection
