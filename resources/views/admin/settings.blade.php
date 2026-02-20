@extends('admin.admin-layout')

@section('title','Settings')
@section('crumb','Settings')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <img src="/images/clsu-logo-green.png" alt="CLSU Seal" style="width:56px;height:56px;border-radius:14px;background:#fff;border:2px solid var(--clsu-green-500);object-fit:contain;">
    <div>
      <h1 class="h3 fw-bold mb-1">Settings</h1>
      <div class="text-muted">System configuration and preferences</div>
    </div>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 mb-4" role="alert">
    <svg width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
    </svg>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<div class="row g-4">
  <!-- Profile Settings -->
  <div class="col-lg-6">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4 d-flex align-items-center">
          <svg width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
          </svg>
          Profile Information
        </h5>
        <form action="{{ route('admin.settings.profile') }}" method="POST">
          @csrf
          @method('PUT')
          
          <div class="mb-3">
            <label for="name" class="form-label fw-bold small">Full Name</label>
            <input type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name', auth('admin')->user()->name) }}" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="email" class="form-label fw-bold small">Email Address</label>
            <input type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email', auth('admin')->user()->email) }}" required>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold small">Role</label>
            <input type="text" class="form-control rounded-3" 
                   value="{{ ucfirst(str_replace('_', ' ', auth('admin')->user()->role)) }}" disabled>
            <small class="text-muted">Contact super admin to change your role</small>
          </div>

          <button type="submit" class="btn btn-gold rounded-4 px-4">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Update Profile
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Change Password -->
  <div class="col-lg-6">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4 d-flex align-items-center">
          <svg width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
          </svg>
          Change Password
        </h5>
        <form action="{{ route('admin.settings.password') }}" method="POST">
          @csrf
          @method('PUT')
          
          <div class="mb-3">
            <label for="current_password" class="form-label fw-bold small">Current Password</label>
            <input type="password" class="form-control rounded-3 @error('current_password') is-invalid @enderror" 
                   id="current_password" name="current_password" required>
            @error('current_password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="password" class="form-label fw-bold small">New Password</label>
            <input type="password" class="form-control rounded-3 @error('password') is-invalid @enderror" 
                   id="password" name="password" required>
            <small class="text-muted">At least 8 characters</small>
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-bold small">Confirm New Password</label>
            <input type="password" class="form-control rounded-3" 
                   id="password_confirmation" name="password_confirmation" required>
          </div>

          <button type="submit" class="btn btn-gold rounded-4 px-4">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Change Password
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- System Information -->
  <div class="col-lg-6">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4 d-flex align-items-center">
          <svg width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
          </svg>
          System Information
        </h5>
        <div class="row g-3">
          <div class="col-6">
            <div class="p-3 bg-light rounded-3">
              <div class="text-muted small mb-1">Laravel Version</div>
              <div class="fw-bold">{{ app()->version() }}</div>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 bg-light rounded-3">
              <div class="text-muted small mb-1">PHP Version</div>
              <div class="fw-bold">{{ PHP_VERSION }}</div>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 bg-light rounded-3">
              <div class="text-muted small mb-1">Environment</div>
              <div class="fw-bold">{{ ucfirst(config('app.env')) }}</div>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 bg-light rounded-3">
              <div class="text-muted small mb-1">Timezone</div>
              <div class="fw-bold">{{ config('app.timezone') }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Preferences -->
  <div class="col-lg-6">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4 d-flex align-items-center">
          <svg width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
          </svg>
          Preferences
        </h5>
        <form action="{{ route('admin.settings.preferences') }}" method="POST">
          @csrf
          @method('PUT')
          
          <div class="mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="email_notifications" 
                     name="email_notifications" value="1" checked>
              <label class="form-check-label fw-bold" for="email_notifications">
                Email Notifications
              </label>
              <small class="d-block text-muted">Receive email alerts for new inquiries and updates</small>
            </div>
          </div>

          <div class="mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="dashboard_stats" 
                     name="dashboard_stats" value="1" checked>
              <label class="form-check-label fw-bold" for="dashboard_stats">
                Dashboard Statistics
              </label>
              <small class="d-block text-muted">Show detailed statistics on dashboard</small>
            </div>
          </div>

          <div class="mb-4">
            <label for="items_per_page" class="form-label fw-bold small">Items Per Page</label>
            <select class="form-select rounded-3" id="items_per_page" name="items_per_page">
              <option value="10">10</option>
              <option value="25" selected>25</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
            <small class="text-muted">Number of items to display in tables</small>
          </div>

          <button type="submit" class="btn btn-gold rounded-4 px-4">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Save Preferences
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Appearance -->
  <div class="col-lg-6">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4 d-flex align-items-center">
          <svg width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
            <path d="M8 1a2 2 0 0 0-2 2v2H5V3a3 3 0 1 1 6 0v2h-1V3a2 2 0 0 0-2-2zM5 5a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5zm1 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0zm5-1.5a.5.5 0 1 1 0 1 .5.5 0 0 1 0-1z"/>
            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l.646-.647z"/>
          </svg>
          Change Appearance
        </h5>
        <form action="{{ route('admin.settings.appearance') }}" method="POST">
          @csrf
          @method('PUT')
          
          <div class="mb-4">
            <label for="theme_color" class="form-label fw-bold small">Theme Color</label>
            <div class="d-flex align-items-center gap-3">
              <input type="color" class="form-control form-control-color rounded-3 p-1" 
                     id="theme_color" name="theme_color" value="{{ $themeColor ?? '#009639' }}" 
                     title="Choose your theme color" style="width: 100px; height: 50px;">
              <div>
                <div class="fw-bold small text-uppercase" id="colorText">{{ $themeColor ?? '#009639' }}</div>
                <small class="text-muted">This will change the primary color of your admin panel</small>
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-gold rounded-4 px-4">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Save Appearance
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
