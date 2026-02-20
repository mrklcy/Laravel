@extends('admin.hrm-layout')

@section('title','Settings')
@section('crumb','Settings')

@section('content')

<div class="mb-4">
  <h1 class="h3 fw-bold mb-1">HRM Settings</h1>
  <p class="text-muted mb-0">Manage your profile and system preferences</p>
</div>

<div class="row g-3">
  <div class="col-lg-8">
    <!-- Profile Settings -->
    <div class="card rounded-4 border mb-3">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Profile Information</h5>
        
        <form>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Name</label>
              <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->name }}" readonly>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Email</label>
              <input type="email" class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Role</label>
              <input type="text" class="form-control" value="{{ ucfirst(str_replace('_', ' ', Auth::guard('admin')->user()->role)) }}" readonly>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Department</label>
              <input type="text" class="form-control" value="Human Resources" readonly>
            </div>

            <div class="col-12">
              <div class="alert alert-info rounded-4 mb-0">
                <strong>Note:</strong> To update your profile information, please contact the system administrator.
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Password Change -->
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Change Password</h5>
        
        <form>
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label fw-bold">Current Password</label>
              <input type="password" class="form-control" placeholder="Enter current password">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">New Password</label>
              <input type="password" class="form-control" placeholder="Enter new password">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Confirm New Password</label>
              <input type="password" class="form-control" placeholder="Confirm new password">
            </div>

            <div class="col-12">
              <button type="button" class="btn btn-gold rounded-4" onclick="alert('Password change feature coming soon!')">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" class="me-2">
                  <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                </svg>
                Update Password
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <!-- Account Info -->
    <div class="card rounded-4 border mb-3">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Account Information</h5>
        
        <div class="d-flex flex-column gap-3">
          <div>
            <div class="small text-muted">Account Status</div>
            <div class="fw-bold">
              <span class="badge bg-success">Active</span>
            </div>
          </div>

          <div>
            <div class="small text-muted">Member Since</div>
            <div class="fw-bold">{{ Auth::guard('admin')->user()->created_at->format('M d, Y') }}</div>
          </div>

          <div>
            <div class="small text-muted">Last Login</div>
            <div class="fw-bold">{{ now()->format('M d, Y h:i A') }}</div>
          </div>

          <div>
            <div class="small text-muted">Access Level</div>
            <div class="fw-bold">HRM Administrator</div>
          </div>
        </div>
      </div>
    </div>

    <!-- System Preferences -->
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Preferences</h5>
        
        <div class="d-flex flex-column gap-3">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="emailNotif" checked>
            <label class="form-check-label" for="emailNotif">
              Email Notifications
            </label>
          </div>

          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="darkMode">
            <label class="form-check-label" for="darkMode">
              Dark Mode
            </label>
          </div>

          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="compactView">
            <label class="form-check-label" for="compactView">
              Compact View
            </label>
          </div>

          <div class="mt-2">
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-3 w-100" onclick="alert('Preferences save feature coming soon!')">
              Save Preferences
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 mt-3" role="alert">
    <svg width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
    </svg>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<div class="row g-3 mt-1">
  <div class="col-lg-6">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4 d-flex align-items-center">
          <svg width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l.646-.647z"/>
            <path d="M8 1a2 2 0 0 0-2 2v2H5V3a3 3 0 1 1 6 0v2h-1V3a2 2 0 0 0-2-2z"/>
          </svg>
          Change Appearance
        </h5>
        <form action="{{ route('admin.hrm.settings.appearance') }}" method="POST">
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

<script>
  document.getElementById('theme_color')?.addEventListener('input', function() {
    document.getElementById('colorText').textContent = this.value.toUpperCase();
  });
</script>

@endsection
