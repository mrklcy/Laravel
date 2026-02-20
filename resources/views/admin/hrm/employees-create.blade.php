@extends('admin.hrm-layout')

@section('title','Add Employee')
@section('crumb','Add Employee')

@section('content')

<div class="mb-4">
  <h1 class="h3 fw-bold mb-1">Add New Employee</h1>
  <p class="text-muted mb-0">Add a new employee to the Human Resources department</p>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <form action="{{ route('admin.hrm.employees.store') }}" method="POST">
          @csrf

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Employee ID <span class="text-danger">*</span></label>
              <input type="text" name="employee_id" class="form-control @error('employee_id') is-invalid @enderror" value="{{ old('employee_id') }}" required>
              @error('employee_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold">First Name <span class="text-danger">*</span></label>
              <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required>
              @error('first_name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold">Middle Name</label>
              <input type="text" name="middle_name" class="form-control @error('middle_name') is-invalid @enderror" value="{{ old('middle_name') }}">
              @error('middle_name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold">Last Name <span class="text-danger">*</span></label>
              <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required>
              @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Phone</label>
              <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
              @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Position</label>
              <input type="text" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position') }}">
              @error('position')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Date Hired</label>
              <input type="date" name="date_hired" class="form-control @error('date_hired') is-invalid @enderror" value="{{ old('date_hired') }}">
              @error('date_hired')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Office</label>
              <select name="office_id" class="form-select @error('office_id') is-invalid @enderror">
                <option value="">Select Office</option>
                @foreach($offices as $office)
                  <option value="{{ $office->id }}" {{ old('office_id') == $office->id ? 'selected' : '' }}>
                    {{ $office->name }}
                  </option>
                @endforeach
              </select>
              @error('office_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Employment Status <span class="text-danger">*</span></label>
              <select name="employment_status" class="form-select @error('employment_status') is-invalid @enderror" required>
                <option value="">Select Status</option>
                <option value="regular" {{ old('employment_status') == 'regular' ? 'selected' : '' }}>Regular</option>
                <option value="contractual" {{ old('employment_status') == 'contractual' ? 'selected' : '' }}>Contractual</option>
                <option value="casual" {{ old('employment_status') == 'casual' ? 'selected' : '' }}>Casual</option>
                <option value="job_order" {{ old('employment_status') == 'job_order' ? 'selected' : '' }}>Job Order</option>
              </select>
              @error('employment_status')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
              <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="">Select Status</option>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="on_leave" {{ old('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                <option value="retired" {{ old('status') == 'retired' ? 'selected' : '' }}>Retired</option>
              </select>
              @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-12">
              <div class="alert alert-info rounded-4">
                <strong>Note:</strong> This employee will be automatically assigned to the <strong>Human Resources</strong> department.
              </div>
            </div>
          </div>

          <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-gold rounded-4">
              <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" class="me-2">
                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
              </svg>
              Save Employee
            </button>
            <a href="{{ route('admin.hrm.employees') }}" class="btn btn-outline-secondary rounded-4">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-3">Guidelines</h5>
        <ul class="small text-muted">
          <li class="mb-2">Employee ID must be unique</li>
          <li class="mb-2">Email must be valid and unique</li>
          <li class="mb-2">All employees will be in Human Resources department</li>
          <li class="mb-2">Date hired is optional but recommended</li>
          <li>Employment status and status are required</li>
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection
