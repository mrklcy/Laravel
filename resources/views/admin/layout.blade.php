<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title','Admin') - CLSU</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root{
      --clsu-green:#009639;
      --clsu-cobra:#1E6031;
      --clsu-yellow:#FFD700;
      --clsu-gold:#E0A70D;
    }

    body{ background:#f6f8f7; }

    /* Sidebar - Always visible, clean design */
    .sidebar{
      width: 260px;
      background: #fff;
      border-right: 1px solid #e5e7eb;
      flex: 0 0 auto;
      overflow-y: auto;
      overflow-x: hidden;
    }

    /* Main should fill remaining space */
    .main-area{
      flex: 1 1 auto;
      min-width: 0;
    }

    .nav-link{
      border-radius:12px;
      color:#1f2937;
      font-weight:500;
      display:flex;
      align-items:center;
      gap:10px;
      padding: 10px 12px;
    }

    .nav-link.active{
      background:var(--clsu-green);
      color:#fff !important;
      font-weight:700;
    }

    .btn-gold{
      background:var(--clsu-green);
      border-color:var(--clsu-green);
      color:#fff;
      font-weight:700;
    }

    .btn-gold:hover{
      background:var(--clsu-green);
      border-color:var(--clsu-green);
      opacity:0.85;
      color:#fff;
    }

    .card-accent{
      border-top:5px solid var(--clsu-green);
    }

    /* Mobile: sidebar overlays */
    @media (max-width: 991.98px){
      .sidebar{
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        z-index: 1040;
        transform: translateX(-110%);
        transition: transform .2s ease;
        width: 280px !important; /* always full on mobile */
      }
      .sidebar-open .sidebar{
        transform: translateX(0);
      }
      .mobile-backdrop{
        display:none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.35);
        z-index: 1030;
      }
      .sidebar-open .mobile-backdrop{
        display:block;
      }
    }
  </style>
</head>

<body>
<div id="appShell" class="d-flex min-vh-100">

  <!-- Mobile backdrop -->
  <div id="mobileBackdrop" class="mobile-backdrop"></div>

  <!-- SIDEBAR -->
  <aside class="sidebar p-3" id="sidebar">
    <div class="d-flex align-items-center gap-3 p-3 border rounded-4 mb-3 brand">
      <img src="/images/clsu-logo-green.png" alt="CLSU Seal" style="width:44px;height:44px;border-radius:12px;background:#fff;border:2px solid var(--clsu-green);object-fit:contain;">
      <div class="label-text">
        <div class="fw-bold">Admin Panel</div>
        <div class="text-muted small brand-sub">@yield('crumb','Dashboard')</div>
      </div>
    </div>

    <nav class="nav flex-column gap-1">
      @if(Auth::guard('admin')->user()->role === 'hrmo_admin')
        <!-- HRMO Admin Navigation -->
        <a class="nav-link {{ request()->routeIs('admin.hrm.dashboard') ? 'active' : '' }}"
           href="{{ route('admin.hrm.dashboard') }}">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
          </svg>
          <span class="label-text">HRMO Dashboard</span>
        </a>

        <!-- HR Management Section -->
        <div class="mt-3 mb-2 px-3">
          <small class="text-muted fw-bold label-text">HR MANAGEMENT</small>
        </div>

        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
           href="{{ route('admin.users.index') }}">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
          </svg>
          <span class="label-text">Users</span>
        </a>

        <!-- Reports Section -->
        <div class="mt-3 mb-2 px-3">
          <small class="text-muted fw-bold label-text">REPORTS</small>
        </div>

        <a class="nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}"
           href="{{ route('admin.analytics') }}">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/>
          </svg>
          <span class="label-text">Analytics</span>
        </a>

        <a class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}"
           href="{{ route('admin.reports') }}">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
          </svg>
          <span class="label-text">Reports</span>
        </a>

      @else
        <!-- Overview (Super Admin Only) -->
        @if(Auth::guard('admin')->user()->role === 'super_admin')
        <a class="nav-link {{ request()->routeIs('admin.overview') ? 'active' : '' }}"
           href="{{ route('admin.overview') }}">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
          </svg>
          <span class="label-text">Overview</span>
        </a>
        @endif

        <!-- Super Admin / Regular Admin Navigation -->
        <!-- Dashboard -->
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           href="{{ route('admin.dashboard') }}">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
          </svg>
          <span class="label-text">Dashboard</span>
        </a>

        <!-- Content Management Section -->
        <div class="mt-3 mb-2 px-3">
          <small class="text-muted fw-bold label-text">CONTENT</small>
        </div>

        <a class="nav-link {{ request()->routeIs('admin.offices.*') ? 'active' : '' }}"
           href="{{ route('admin.offices.index') }}">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/>
          </svg>
          <span class="label-text">Offices</span>
        </a>

        <a class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}"
           href="{{ route('admin.services.index') }}">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3zm-1 14.5l-3.5-3.5L9 11.5l2 2 5-5 1.5 1.5-6.5 6.5z"/>
          </svg>
          <span class="label-text">Services</span>
        </a>

        <a class="nav-link {{ request()->routeIs('admin.programs.*') ? 'active' : '' }}"
           href="{{ route('admin.programs.index') }}">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
          </svg>
          <span class="label-text">Programs</span>
        </a>

        <a class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}"
           href="{{ route('admin.news.index') }}">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M20 2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM8 20H5v-2h3v2zm0-4H5v-2h3v2zm0-4H5V8h3v4zm6 8h-3v-2h3v2zm0-4h-3v-2h3v2zm0-4h-3V8h3v4zm5 8h-3v-6h3v6z"/>
          </svg>
          <span class="label-text">News</span>
        </a>

        <a class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}"
           href="{{ route('admin.events.index') }}">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM9 10H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2z"/>
          </svg>
          <span class="label-text">Events</span>
        </a>

        <!-- Communications Section -->
        <div class="mt-3 mb-2 px-3">
          <small class="text-muted fw-bold label-text">COMMUNICATIONS</small>
        </div>

        <a class="nav-link {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}"
           href="{{ route('admin.inquiries.index') }}">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-7 12h-2v-2h2v2zm0-4h-2V6h2v4z"/>
          </svg>
          <span class="label-text">Inquiries</span>
        </a>

        <!-- System Section -->
        <div class="mt-3 mb-2 px-3">
          <small class="text-muted fw-bold label-text">SYSTEM</small>
        </div>

        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
           href="{{ route('admin.users.index') }}">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
          </svg>
          <span class="label-text">Users</span>
        </a>

        <a class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}"
           href="{{ route('admin.settings') }}">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/>
          </svg>
          <span class="label-text">Settings</span>
        </a>

        <a class="nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}"
           href="{{ route('admin.analytics') }}">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/>
          </svg>
          <span class="label-text">Analytics</span>
        </a>

        <a class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}"
           href="{{ route('admin.reports') }}">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
          </svg>
          <span class="label-text">Reports</span>
        </a>
      @endif
    </nav>


  </aside>

  <!-- MAIN -->
  <main class="main-area">

    <!-- TOPBAR -->
    <nav class="navbar bg-white border-bottom px-4">
      <div class="d-flex align-items-center gap-2">
        <!-- Mobile open button -->
        <button id="mobileOpenBtn"
                class="btn btn-outline-secondary d-lg-none"
                type="button">
          ☰
        </button>

        <span class="text-muted">@yield('crumb','Admin')</span>
      </div>

      <div class="d-flex align-items-center gap-3">
        <span class="badge rounded-pill bg-success">Online</span>

        <div class="dropdown">
          <button class="btn d-flex align-items-center gap-2 border rounded-4 px-3 py-2 bg-white" type="button" data-bs-toggle="dropdown">
            <div class="rounded-4 fw-bold d-flex align-items-center justify-content-center"
                 style="width:36px;height:36px;background:rgba(224,167,13,.3);">
              {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="small text-start">
              <div class="fw-bold">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</div>
              <div class="text-muted">{{ ucfirst(Auth::guard('admin')->user()->role ?? 'Administrator') }}</div>
            </div>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item text-danger">
                  <i class="bi bi-box-arrow-right me-2"></i>Logout
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid p-4">
      @yield('content')
    </div>

    <footer class="bg-white border-top px-4 py-3 small text-muted">
      © {{ date('Y') }} Central Luzon State University
    </footer>

  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const appShell = document.getElementById('appShell');

  // Mobile open/close
  const mobileOpenBtn = document.getElementById('mobileOpenBtn');
  const mobileBackdrop = document.getElementById('mobileBackdrop');

  function openSidebarMobile() {
    appShell.classList.add('sidebar-open');
  }
  function closeSidebarMobile() {
    appShell.classList.remove('sidebar-open');
  }

  mobileOpenBtn?.addEventListener('click', openSidebarMobile);
  mobileBackdrop?.addEventListener('click', closeSidebarMobile);

  // Close sidebar on nav click (mobile)
  document.querySelectorAll('#sidebar a.nav-link').forEach(a => {
    a.addEventListener('click', () => {
      if (window.matchMedia('(max-width: 991.98px)').matches) closeSidebarMobile();
    });
  });
</script>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<!-- Page-specific scripts -->
@yield('scripts')

</body>
</html>
