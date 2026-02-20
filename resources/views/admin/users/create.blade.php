@extends('admin.admin-layout')

@section('title','Create User')
@section('crumb','Create User')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-4">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
      </svg>
    </a>
    <div>
      <h1 class="h3 fw-bold mb-1">Create User</h1>
      <div class="text-muted">Add a new admin user</div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <form action="{{ route('admin.users.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label for="name" class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
            <input type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="employee_id" class="form-label fw-bold">Employee ID</label>
              <input type="text" class="form-control rounded-3 @error('employee_id') is-invalid @enderror" 
                     id="employee_id" name="employee_id" value="{{ old('employee_id') }}">
              @error('employee_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6 mb-3">
              <label for="position" class="form-label fw-bold">Position</label>
              <input type="text" class="form-control rounded-3 @error('position') is-invalid @enderror" 
                     id="position" name="position" value="{{ old('position') }}">
              @error('position')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="mb-3">
            <label for="office_id" class="form-label fw-bold">Office</label>
            <select class="form-select rounded-3 @error('office_id') is-invalid @enderror" 
                    id="office_id" name="office_id">
              <option value="">Select Office</option>
              @foreach($offices as $office)
                <option value="{{ $office->id }}" {{ old('office_id') == $office->id ? 'selected' : '' }}>
                  {{ $office->name }} ({{ $office->acronym }})
                </option>
              @endforeach
            </select>
            @error('office_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control rounded-3 @error('password') is-invalid @enderror" 
                   id="password" name="password" required>
            <small class="text-muted">At least 8 characters</small>
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-bold">Confirm Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control rounded-3" 
                   id="password_confirmation" name="password_confirmation" required>
          </div>

          <div class="mb-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                     value="1" {{ old('is_active', true) ? 'checked' : '' }}>
              <label class="form-check-label fw-bold" for="is_active">
                Active
              </label>
              <small class="d-block text-muted">Inactive users cannot log in</small>
            </div>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-gold rounded-4 px-4">
              <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              Create User
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-4 px-4">Cancel</a>
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
          <li class="mb-2">Email addresses must be unique</li>
          <li class="mb-2">Password must be at least 8 characters</li>
          <li class="mb-2">Employee ID is optional but recommended</li>
          <li>Users can update their profile after creation</li>
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection
