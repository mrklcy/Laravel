@extends('admin.pmo-layout')

@section('title', 'Settings')
@section('crumb', 'Settings')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <img src="/images/clsu-logo-green.png" alt="CLSU Seal" style="width:56px;height:56px;border-radius:14px;background:#fff;border:2px solid var(--clsu-green-500);object-fit:contain;">
    <div>
      <h1 class="h3 fw-bold mb-1">PMO Settings</h1>
      <div class="text-muted">Configure Procurement Management Office settings</div>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-3">General Settings</h5>
        <form>
          <div class="mb-3">
            <label class="form-label">Office Name</label>
            <input type="text" class="form-control" value="Procurement Management Office">
          </div>
          <div class="mb-3">
            <label class="form-label">Office Code</label>
            <input type="text" class="form-control" value="PMO">
          </div>
          <div class="mb-3">
            <label class="form-label">Contact Email</label>
            <input type="email" class="form-control" value="pmo@clsu.edu.ph">
          </div>
          <div class="mb-3">
            <label class="form-label">Contact Phone</label>
            <input type="tel" class="form-control" value="(044) 456-0108">
          </div>
          <button type="submit" class="btn btn-gold">Save Changes</button>
        </form>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-body">
        <h5 class="card-title mb-3">Notification Settings</h5>
        <div class="form-check form-switch mb-3">
          <input class="form-check-input" type="checkbox" id="emailNotif" checked>
          <label class="form-check-label" for="emailNotif">
            Email Notifications for New Purchase Requests
          </label>
        </div>
        <div class="form-check form-switch mb-3">
          <input class="form-check-input" type="checkbox" id="maintenanceNotif" checked>
          <label class="form-check-label" for="maintenanceNotif">
            Order Tracking Alerts
          </label>
        </div>
        <div class="form-check form-switch mb-3">
          <input class="form-check-input" type="checkbox" id="reservationNotif" checked>
          <label class="form-check-label" for="reservationNotif">
            Bid Status Notifications
          </label>
        </div>
        <button type="submit" class="btn btn-gold">Save Preferences</button>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-3">Quick Actions</h5>
        <div class="d-grid gap-2">
          <button class="btn btn-outline-primary">
            <i class="bi bi-arrow-clockwise me-2"></i>Refresh Data
          </button>
          <button class="btn btn-outline-info">
            <i class="bi bi-download me-2"></i>Export Settings
          </button>
          <button class="btn btn-outline-warning">
            <i class="bi bi-upload me-2"></i>Import Settings
          </button>
          <button class="btn btn-outline-danger">
            <i class="bi bi-trash me-2"></i>Clear Cache
          </button>
        </div>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-body">
        <h5 class="card-title mb-3">System Info</h5>
        <div class="small">
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Version:</span>
            <span class="fw-bold">1.0.0</span>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Last Updated:</span>
            <span class="fw-bold">Feb 10, 2026</span>
          </div>
          <div class="d-flex justify-content-between">
            <span class="text-muted">Database:</span>
            <span class="fw-bold text-success">Connected</span>
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
  <div class="col-md-8">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4 d-flex align-items-center">
          <svg width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l.646-.647z"/>
            <path d="M8 1a2 2 0 0 0-2 2v2H5V3a3 3 0 1 1 6 0v2h-1V3a2 2 0 0 0-2-2z"/>
          </svg>
          Change Appearance
        </h5>
        <form action="{{ route('pmo.settings.appearance') }}" method="POST">
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
