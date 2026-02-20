<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title','RMO Panel') - CLSU</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    @php
      $office = \App\Models\Office::where('code', 'RMO')->first();
      $themeColor = $office ? $office->theme_color : '#009639';
    @endphp

    :root{
      --clsu-green: {{ $themeColor }};
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
        <div class="fw-bold">RMO Panel</div>
        <div class="text-muted small brand-sub">@yield('crumb','RMO Dashboard')</div>
      </div>
    </div>

    <nav class="nav flex-column gap-1">
      @if(Auth::guard('admin')->user()->role === 'super_admin')
      <a class="nav-link mb-2" href="{{ route('admin.dashboard') }}" style="background: #f8f9fa; border: 1px dashed #ced4da;">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span class="label-text">Main Admin</span>
      </a>
      @endif

      <!-- RMO Dashboard -->
      <a class="nav-link {{ request()->routeIs('rmo.dashboard') ? 'active' : '' }}"
         href="{{ route('rmo.dashboard') }}">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
        </svg>
        <span class="label-text">Dashboard</span>
      </a>

      <!-- Records Section -->
      <div class="mt-3 mb-2 px-3">
        <small class="text-muted fw-bold label-text">RECORDS</small>
      </div>

      <a class="nav-link {{ request()->routeIs('rmo.documents*') ? 'active' : '' }}"
         href="{{ route('rmo.documents') }}">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
        </svg>
        <span class="label-text">Documents</span>
      </a>

       <a class="nav-link {{ request()->routeIs('rmo.archives*') ? 'active' : '' }}"
         href="{{ route('rmo.archives') }}">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
           <path d="M20.54 5.23l-1.39-1.68C18.88 3.21 18.47 3 18 3H6c-.47 0-.88.21-1.16.55L3.46 5.23C3.17 5.57 3 6.02 3 6.5V19c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6.5c0-.48-.17-.93-.46-1.27zM12 17.5L6.5 12H10v-2h4v2h3.5L12 17.5zM5.12 5l.81-1h12l.94 1H5.12z"/>
        </svg>
        <span class="label-text">Archives</span>
      </a>

      <a class="nav-link {{ request()->routeIs('rmo.requests*') ? 'active' : '' }}"
         href="{{ route('rmo.requests') }}">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
           <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
        </svg>
        <span class="label-text">Requests</span>
      </a>

      <!-- Reports Section -->
      <div class="mt-3 mb-2 px-3">
        <small class="text-muted fw-bold label-text">REPORTS</small>
      </div>

      <a class="nav-link {{ request()->routeIs('rmo.analytics') ? 'active' : '' }}"
         href="{{ route('rmo.analytics') }}">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/>
        </svg>
        <span class="label-text">Analytics</span>
      </a>

      <a class="nav-link {{ request()->routeIs('rmo.reports') ? 'active' : '' }}"
         href="{{ route('rmo.reports') }}">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/>
        </svg>
        <span class="label-text">Reports</span>
      </a>

      <!-- Communications Section -->
      <div class="mt-3 mb-2 px-3">
        <small class="text-muted fw-bold label-text">COMMUNICATIONS</small>
      </div>

      <a class="nav-link {{ request()->routeIs('rmo.inquiries*') ? 'active' : '' }}"
         href="{{ route('rmo.inquiries') }}">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-7 12h-2v-2h2v2zm0-4h-2V6h2v4z"/>
        </svg>
        <span class="label-text">Inquiries</span>
      </a>

      <!-- Settings Section -->
      <div class="mt-3 mb-2 px-3">
        <small class="text-muted fw-bold label-text">SYSTEM</small>
      </div>

      <a class="nav-link {{ request()->routeIs('rmo.settings') ? 'active' : '' }}"
         href="{{ route('rmo.settings') }}">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
           <path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/>
        </svg>
        <span class="label-text">Settings</span>
      </a>
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

        <span class="text-muted">@yield('crumb','RMO')</span>
      </div>

      <div class="d-flex align-items-center gap-3">
        <span class="badge rounded-pill bg-success">Online</span>

        <div class="dropdown">
          <button class="btn d-flex align-items-center gap-2 border rounded-4 px-3 py-2 bg-white" type="button" data-bs-toggle="dropdown">
            <div class="rounded-4 fw-bold d-flex align-items-center justify-content-center"
                 style="width:36px;height:36px;background:rgba(224,167,13,.3);">
              {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'R', 0, 1)) }}
            </div>
            <div class="small text-start">
              <div class="fw-bold">{{ Auth::guard('admin')->user()->name ?? 'RMO Admin' }}</div>
              <div class="text-muted">{{ ucfirst(Auth::guard('admin')->user()->role ?? 'RMO Administrator') }}</div>
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
