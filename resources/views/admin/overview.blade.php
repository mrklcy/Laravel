@extends('admin.admin-layout')

@section('title', 'Overview')
@section('crumb', 'Website Overview')

@section('content')
<style>
  .overview-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    transition: all 0.2s;
  }
  .overview-card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    transform: translateY(-2px);
  }
  .preview-frame {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    background: #f9fafb;
  }
  .preview-toolbar {
    background: #1f2937;
    padding: 10px 16px;
    display: flex;
    align-items: center;
    gap: 10px;
    border-radius: 12px 12px 0 0;
  }
  .preview-toolbar .dot { width:12px; height:12px; border-radius:50%; }
  .preview-toolbar .dot-red { background:#ff5f57; }
  .preview-toolbar .dot-yellow { background:#ffbd2e; }
  .preview-toolbar .dot-green { background:#28ca41; }
  .preview-toolbar .url-bar {
    flex:1;
    background: #374151;
    border-radius: 6px;
    padding: 6px 12px;
    color: #9ca3af;
    font-size: 13px;
    font-family: monospace;
  }
  .preview-toolbar .tb-btn {
    background: transparent;
    border: 1px solid #4b5563;
    color: #9ca3af;
    border-radius: 6px;
    padding: 4px 10px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.15s;
  }
  .preview-toolbar .tb-btn:hover {
    background: #374151;
    color: #fff;
  }
  .slider-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
  }
  .slider-thumb {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid #e5e7eb;
    aspect-ratio: 16/9;
    transition: all 0.2s;
  }
  .slider-thumb:hover {
    border-color: var(--clsu-green);
    box-shadow: 0 4px 15px rgba(0,150,57,0.15);
  }
  .slider-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .slider-thumb .overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    opacity: 0;
    transition: opacity 0.2s;
  }
  .slider-thumb:hover .overlay {
    opacity: 1;
  }
  .slider-thumb .badge-order {
    position: absolute;
    top: 8px;
    left: 8px;
    background: var(--clsu-green);
    color: #fff;
    border-radius: 6px;
    padding: 2px 8px;
    font-size: 11px;
    font-weight: 700;
    z-index: 2;
  }
  .slider-thumb .badge-status {
    position: absolute;
    top: 8px;
    right: 8px;
    border-radius: 6px;
    padding: 2px 8px;
    font-size: 11px;
    font-weight: 700;
    z-index: 2;
  }
  .quick-action-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    padding: 24px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    transition: all 0.2s;
  }
  .quick-action-card:hover {
    border-color: var(--clsu-green);
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
  }
  .qa-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
  }
  .qa-count {
    font-size: 28px;
    font-weight: 800;
    color: #1f2937;
  }
  .qa-label {
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 16px;
  }
  /* Carousel Preview */
  .carousel-preview {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    aspect-ratio: 21/9;
    background: #111827;
    margin-bottom: 20px;
  }
  .carousel-preview .carousel-track {
    display: flex;
    height: 100%;
    transition: transform 0.6s ease-in-out;
  }
  .carousel-preview .carousel-slide {
    min-width: 100%;
    height: 100%;
    flex-shrink: 0;
    position: relative;
  }
  .carousel-preview .carousel-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .carousel-preview .carousel-slide .slide-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.15), transparent 40%, rgba(0,0,0,0.4));
  }
  .carousel-preview .carousel-slide .slide-caption {
    position: absolute;
    bottom: 20px;
    left: 24px;
    right: 24px;
    color: #fff;
    z-index: 2;
  }
  .carousel-preview .carousel-slide .slide-caption h4 { font-weight: 700; margin: 0 0 4px; text-shadow: 0 1px 4px rgba(0,0,0,0.5); }
  .carousel-preview .carousel-slide .slide-caption p { font-size: 14px; margin: 0; opacity: 0.9; text-shadow: 0 1px 3px rgba(0,0,0,0.5); }
  .carousel-preview .carousel-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(4px);
    border: none;
    color: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
    z-index: 3;
  }
  .carousel-preview .carousel-arrow:hover { background: rgba(255,255,255,0.4); }
  .carousel-preview .carousel-arrow.prev { left: 12px; }
  .carousel-preview .carousel-arrow.next { right: 12px; }
  .carousel-preview .carousel-dots {
    position: absolute;
    bottom: 12px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 8px;
    z-index: 3;
  }
  .carousel-preview .carousel-dots button {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: none;
    background: rgba(255,255,255,0.4);
    cursor: pointer;
    transition: all 0.2s;
    padding: 0;
  }
  .carousel-preview .carousel-dots button.active { background: #fff; transform: scale(1.2); }
  .carousel-preview .slide-counter {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(0,0,0,0.5);
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    z-index: 3;
    backdrop-filter: blur(4px);
  }
  .carousel-empty {
    aspect-ratio: 21/9;
    border-radius: 12px;
    background: #f3f4f6;
    border: 2px dashed #d1d5db;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
  }
</style>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<!-- Page Header -->
<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h3 class="fw-bold mb-1">🌐 Website Overview</h3>
    <p class="text-muted mb-0">Preview and manage your public website content</p>
  </div>
</div>

<!-- Website Preview -->
<div class="overview-card mb-4">
  <div class="p-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <h5 class="fw-bold mb-0">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" class="me-2" style="color:var(--clsu-green)">
          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
        </svg>
        Website Preview
      </h5>
      <div class="d-flex gap-2">
        <button class="btn btn-sm btn-outline-secondary rounded-3" onclick="document.getElementById('sitePreview').src = document.getElementById('sitePreview').src;">
          <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/></svg>
          Refresh
        </button>
        <a href="/" target="_blank" class="btn btn-sm btn-gold rounded-3">
          <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/></svg>
          Open Website
        </a>
      </div>
    </div>
    <div class="preview-frame">
      <div class="preview-toolbar">
        <div class="dot dot-red"></div>
        <div class="dot dot-yellow"></div>
        <div class="dot dot-green"></div>
        <div class="url-bar">{{ url('/') }}</div>
      </div>
      <iframe id="sitePreview" src="/" style="width:100%; height:500px; border:none; display:block;"></iframe>
    </div>
  </div>
</div>

<!-- Slider Management -->
<div class="overview-card mb-4">
  <div class="p-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <h5 class="fw-bold mb-0">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" class="me-2" style="color:var(--clsu-green)">
          <path d="M22 16V4c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2zm-11-4l2.03 2.71L16 11l4 5H8l3-4zM2 6v14c0 1.1.9 2 2 2h14v-2H4V6H2z"/>
        </svg>
        Hero Carousel
      </h5>
      <button class="btn btn-sm btn-gold rounded-3" data-bs-toggle="modal" data-bs-target="#addSliderModal">
        <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
        Add Slide
      </button>
    </div>

    <!-- Carousel Preview -->
    @if($sliders->count() > 0)
      <div class="carousel-preview" id="adminCarousel">
        <div class="carousel-track" id="adminCarouselTrack">
          @foreach($sliders as $slider)
            <div class="carousel-slide">
              <img src="{{ asset($slider->image) }}" alt="{{ $slider->title ?? 'Slider' }}">
              <div class="slide-overlay"></div>
              @if($slider->title || $slider->caption)
                <div class="slide-caption">
                  @if($slider->title)<h4>{{ $slider->title }}</h4>@endif
                  @if($slider->caption)<p>{{ $slider->caption }}</p>@endif
                </div>
              @endif
            </div>
          @endforeach
        </div>

        <!-- Arrows -->
        <button class="carousel-arrow prev" onclick="adminCarouselMove(-1)" aria-label="Previous">
          <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button class="carousel-arrow next" onclick="adminCarouselMove(1)" aria-label="Next">
          <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>

        <!-- Counter -->
        <div class="slide-counter" id="adminSlideCounter">1 / {{ $sliders->count() }}</div>

        <!-- Dots -->
        <div class="carousel-dots" id="adminCarouselDots">
          @for($i = 0; $i < $sliders->count(); $i++)
            <button class="{{ $i === 0 ? 'active' : '' }}" onclick="adminCarouselGoTo({{ $i }})" aria-label="Slide {{ $i + 1 }}"></button>
          @endfor
        </div>
      </div>
    @else
      <div class="carousel-empty">
        <svg width="48" height="48" fill="#d1d5db" viewBox="0 0 24 24"><path d="M22 16V4c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2zm-11-4l2.03 2.71L16 11l4 5H8l3-4zM2 6v14c0 1.1.9 2 2 2h14v-2H4V6H2z"/></svg>
        <p class="text-muted mt-3 mb-0">No carousel images yet. Click "Add Slide" to upload your first hero image.</p>
      </div>
    @endif

    <!-- Slide Management Grid -->
    @if($sliders->count() > 0)
      <div class="d-flex align-items-center justify-content-between mb-2 mt-2">
        <small class="text-muted fw-bold text-uppercase">Manage Slides ({{ $sliders->count() }})</small>
      </div>
      <div class="slider-grid">
        @foreach($sliders as $slider)
          <div class="slider-thumb">
            <span class="badge-order">#{{ $slider->order }}</span>
            <span class="badge-status {{ $slider->is_active ? 'bg-success text-white' : 'bg-secondary text-white' }}">
              {{ $slider->is_active ? 'Active' : 'Inactive' }}
            </span>
            <img src="{{ asset($slider->image) }}" alt="{{ $slider->title ?? 'Slider' }}">
            <div class="overlay">
              <button class="btn btn-sm btn-light rounded-3" data-bs-toggle="modal" data-bs-target="#editSliderModal{{ $slider->id }}">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
              </button>
              <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this slider image?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger rounded-3">
                  <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                </button>
              </form>
            </div>
          </div>

          <!-- Edit Slider Modal -->
          <div class="modal fade" id="editSliderModal{{ $slider->id }}" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content rounded-4">
                <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Edit Slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label fw-semibold">Replace Image (optional)</label>
                      <input type="file" name="image" class="form-control rounded-3" accept="image/*">
                    </div>
                    <div class="mb-3">
                      <label class="form-label fw-semibold">Title</label>
                      <input type="text" name="title" class="form-control rounded-3" value="{{ $slider->title }}" placeholder="Optional title">
                    </div>
                    <div class="mb-3">
                      <label class="form-label fw-semibold">Caption</label>
                      <input type="text" name="caption" class="form-control rounded-3" value="{{ $slider->caption }}" placeholder="Optional caption">
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <label class="form-label fw-semibold">Order</label>
                        <input type="number" name="order" class="form-control rounded-3" value="{{ $slider->order }}" min="0">
                      </div>
                      <div class="col-6 d-flex align-items-end">
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" name="is_active" id="active{{ $slider->id }}" {{ $slider->is_active ? 'checked' : '' }}>
                          <label class="form-check-label" for="active{{ $slider->id }}">Active</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gold rounded-3">Update Slider</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</div>

<!-- Add Slider Modal -->
<div class="modal fade" id="addSliderModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content rounded-4">
      <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title fw-bold">Add New Slider Image</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Image <span class="text-danger">*</span></label>
            <input type="file" name="image" class="form-control rounded-3" accept="image/*" required>
            <small class="text-muted">Recommended: 1920×1080px. Max 5MB. JPG, PNG, WebP.</small>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Title</label>
            <input type="text" name="title" class="form-control rounded-3" placeholder="Optional title for this slide">
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Caption</label>
            <input type="text" name="caption" class="form-control rounded-3" placeholder="Optional caption text">
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Display Order</label>
            <input type="number" name="order" class="form-control rounded-3" value="{{ ($sliders->max('order') ?? 0) + 1 }}" min="0">
          </div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-gold rounded-3">Upload Slider</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Change Appearance -->
<div class="overview-card mb-4">
  <div class="p-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <h5 class="fw-bold mb-0">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" class="me-2" style="color:var(--clsu-green)">
          <path d="M12 22C6.49 22 2 17.51 2 12S6.49 2 12 2s10 4.04 10 9c0 3.31-2.69 6-6 6h-1.77c-.28 0-.5.22-.5.5 0 .12.05.23.13.33.41.47.64 1.06.64 1.67A2.5 2.5 0 0112 22zm0-18c-4.41 0-8 3.59-8 8s3.59 8 8 8c.28 0 .5-.22.5-.5a.54.54 0 00-.14-.35c-.41-.46-.63-1.05-.63-1.65a2.5 2.5 0 012.5-2.5H16c2.21 0 4-1.79 4-4 0-3.86-3.59-7-8-7z"/>
          <circle cx="6.5" cy="11.5" r="1.5"/>
          <circle cx="9.5" cy="7.5" r="1.5"/>
          <circle cx="14.5" cy="7.5" r="1.5"/>
          <circle cx="17.5" cy="11.5" r="1.5"/>
        </svg>
        Change Appearance
      </h5>
    </div>

    <form action="{{ route('admin.appearance.update') }}" method="POST" id="appearanceForm">
      @csrf
      @method('PUT')

      <!-- Live Preview Strip -->
      <div class="mb-4" style="border-radius:12px; overflow:hidden; border:1px solid #e5e7eb;">
        <!-- Header Preview -->
        <div id="previewHeader" style="background:{{ $adso->website_theme_color ?? '#009639' }}; padding:16px 24px; display:flex; align-items:center; gap:12px;">
          <img src="{{ asset('images/clsu-logo-green.png') }}" alt="Logo" style="height:40px; width:40px; object-fit:contain; border-radius:50%; background:#fff; padding:2px;">
          <div>
            <div style="color:#fff; font-weight:700; font-size:16px;">CLSU ADSO</div>
            <div style="color:#FFD700; font-size:11px;">Administrative Services Office</div>
          </div>
          <div style="margin-left:auto; display:flex; gap:8px;">
            <span style="color:#fff; font-size:12px; padding:4px 12px; border-radius:6px; background:rgba(255,255,255,0.15);">Home</span>
            <span style="color:#fff; font-size:12px; padding:4px 12px; border-radius:6px; background:rgba(255,255,255,0.15);">Services</span>
            <span style="color:#fff; font-size:12px; padding:4px 12px; border-radius:6px; background:rgba(255,255,255,0.15);">Programs</span>
            <span style="color:#fff; font-size:12px; padding:4px 12px; border-radius:6px; background:rgba(255,255,255,0.15);">News</span>
          </div>
        </div>
        <!-- Content Preview -->
        <div style="background:#fff; padding:16px 24px; display:flex; align-items:center; gap:16px;">
          <div style="flex:1;">
            <div style="font-size:13px; color:#6b7280;">Preview of how your website header and accents will look</div>
          </div>
          <button type="button" id="previewBtn" style="background:{{ $adso->website_theme_color ?? '#009639' }}; color:#fff; border:none; padding:6px 16px; border-radius:8px; font-size:12px; font-weight:600;">
            Sample Button
          </button>
          <div id="previewAccent" style="width:40px; height:6px; border-radius:3px; background:{{ $adso->website_theme_color ?? '#009639' }};"></div>
        </div>
      </div>

      <div class="row g-4">
        <!-- Color Picker Column -->
        <div class="col-md-5">
          <label class="form-label fw-semibold mb-2">Primary Color</label>
          <div class="d-flex align-items-center gap-3 mb-3">
            <div style="position:relative; width:56px; height:56px; border-radius:12px; overflow:hidden; border:2px solid #e5e7eb; cursor:pointer; flex-shrink:0;">
              <input type="color" name="primary_color" id="primaryColorPicker" value="{{ $adso->website_theme_color ?? '#009639' }}" style="position:absolute; inset:-8px; width:calc(100% + 16px); height:calc(100% + 16px); border:none; cursor:pointer; padding:0;">
            </div>
            <div style="flex:1;">
              <input type="text" id="primaryColorHex" value="{{ $adso->website_theme_color ?? '#009639' }}" class="form-control form-control-sm rounded-3 font-monospace" style="text-transform:uppercase;" maxlength="7" pattern="^#[0-9A-Fa-f]{6}$">
              <small class="text-muted">Used for header, buttons, and links</small>
            </div>
          </div>
        </div>

        <!-- Preset Palettes Column -->
        <div class="col-md-7">
          <label class="form-label fw-semibold mb-2">Preset Palettes</label>
          <div class="d-flex flex-wrap gap-2">
            @php
              $presets = [
                ['name' => 'CLSU Green', 'color' => '#009639'],
                ['name' => 'Forest', 'color' => '#1E6031'],
                ['name' => 'Emerald', 'color' => '#047857'],
                ['name' => 'Teal', 'color' => '#0D9488'],
                ['name' => 'Ocean Blue', 'color' => '#1D4ED8'],
                ['name' => 'Royal Blue', 'color' => '#2563EB'],
                ['name' => 'Indigo', 'color' => '#4F46E5'],
                ['name' => 'Purple', 'color' => '#7C3AED'],
                ['name' => 'Burgundy', 'color' => '#991B1B'],
                ['name' => 'Crimson', 'color' => '#DC2626'],
                ['name' => 'Amber', 'color' => '#D97706'],
                ['name' => 'Slate', 'color' => '#475569'],
              ];
            @endphp
            @foreach($presets as $preset)
              <button type="button" class="preset-color-btn {{ ($adso->website_theme_color ?? '#009639') === $preset['color'] ? 'active' : '' }}" data-color="{{ $preset['color'] }}" title="{{ $preset['name'] }}" style="width:42px; height:42px; border-radius:10px; border:2px solid #e5e7eb; background:{{ $preset['color'] }}; cursor:pointer; position:relative; transition: all 0.2s;">
                @if(($adso->website_theme_color ?? '#009639') === $preset['color'])
                  <svg width="16" height="16" fill="#fff" viewBox="0 0 24 24" style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                @endif
              </button>
            @endforeach
          </div>
        </div>
      </div>

      <!-- Save Button -->
      <div class="d-flex justify-content-end mt-4 pt-3" style="border-top:1px solid #f3f4f6;">
        <button type="button" class="btn btn-outline-secondary rounded-3 me-2" onclick="resetAppearance()">
          <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/></svg>
          Reset to Default
        </button>
        <button type="submit" class="btn btn-gold rounded-3">
          <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>
          Save Appearance
        </button>
      </div>
    </form>
  </div>
</div>

<style>
  .preset-color-btn:hover { transform: scale(1.12); box-shadow: 0 2px 8px rgba(0,0,0,0.18); border-color: #9ca3af !important; }
  .preset-color-btn.active { border-color: #111827 !important; box-shadow: 0 0 0 2px #fff, 0 0 0 4px #111827; }
</style>

<!-- Content Quick Actions -->
<h5 class="fw-bold mb-3">
  <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" class="me-2" style="color:var(--clsu-green)">
    <path d="M4 8h4V4H4v4zm6 12h4v-4h-4v4zm-6 0h4v-4H4v4zm0-6h4v-4H4v4zm6 0h4v-4h-4v4zm6-10v4h4V4h-4zm-6 4h4V4h-4v4zm6 6h4v-4h-4v4zm0 6h4v-4h-4v4z"/>
  </svg>
  Content Management
</h5>
<div class="row g-3 mb-4">
  <!-- News -->
  <div class="col-md-4 col-lg">
    <div class="quick-action-card">
      <div class="qa-icon" style="background:rgba(0,150,57,0.1);">
        <svg width="28" height="28" fill="var(--clsu-green)" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM8 20H5v-2h3v2zm0-4H5v-2h3v2zm0-4H5V8h3v4zm6 8h-3v-2h3v2zm0-4h-3v-2h3v2zm0-4h-3V8h3v4zm5 8h-3v-6h3v6z"/></svg>
      </div>
      <div class="qa-count">{{ $stats['total_news'] }}</div>
      <div class="qa-label">News Articles</div>
      <div class="d-flex gap-2 w-100">
        <a href="{{ route('admin.news.create') }}" class="btn btn-sm btn-gold rounded-3 flex-fill">+ Add</a>
        <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 flex-fill">View All</a>
      </div>
    </div>
  </div>

  <!-- Programs -->
  <div class="col-md-4 col-lg">
    <div class="quick-action-card">
      <div class="qa-icon" style="background:rgba(224,167,13,0.1);">
        <svg width="28" height="28" fill="var(--clsu-gold)" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
      </div>
      <div class="qa-count">{{ $stats['total_programs'] }}</div>
      <div class="qa-label">Programs</div>
      <div class="d-flex gap-2 w-100">
        <a href="{{ route('admin.programs.create') }}" class="btn btn-sm btn-gold rounded-3 flex-fill">+ Add</a>
        <a href="{{ route('admin.programs.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 flex-fill">View All</a>
      </div>
    </div>
  </div>

  <!-- Events -->
  <div class="col-md-4 col-lg">
    <div class="quick-action-card">
      <div class="qa-icon" style="background:rgba(30,96,49,0.1);">
        <svg width="28" height="28" fill="var(--clsu-cobra)" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM9 10H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2z"/></svg>
      </div>
      <div class="qa-count">{{ $stats['total_events'] }}</div>
      <div class="qa-label">Events</div>
      <div class="d-flex gap-2 w-100">
        <a href="{{ route('admin.events.create') }}" class="btn btn-sm btn-gold rounded-3 flex-fill">+ Add</a>
        <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 flex-fill">View All</a>
      </div>
    </div>
  </div>

  <!-- Services -->
  <div class="col-md-4 col-lg">
    <div class="quick-action-card">
      <div class="qa-icon" style="background:rgba(0,150,57,0.1);">
        <svg width="28" height="28" fill="var(--clsu-green)" viewBox="0 0 24 24"><path d="M12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3zm-1 14.5l-3.5-3.5L9 11.5l2 2 5-5 1.5 1.5-6.5 6.5z"/></svg>
      </div>
      <div class="qa-count">{{ $stats['total_services'] }}</div>
      <div class="qa-label">Services</div>
      <div class="d-flex gap-2 w-100">
        <a href="{{ route('admin.services.create') }}" class="btn btn-sm btn-gold rounded-3 flex-fill">+ Add</a>
        <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 flex-fill">View All</a>
      </div>
    </div>
  </div>

  <!-- Offices -->
  <div class="col-md-4 col-lg">
    <div class="quick-action-card">
      <div class="qa-icon" style="background:rgba(224,167,13,0.1);">
        <svg width="28" height="28" fill="var(--clsu-gold)" viewBox="0 0 24 24"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
      </div>
      <div class="qa-count">{{ $stats['total_offices'] }}</div>
      <div class="qa-label">Offices</div>
      <div class="d-flex gap-2 w-100">
        <a href="{{ route('admin.offices.create') }}" class="btn btn-sm btn-gold rounded-3 flex-fill">+ Add</a>
        <a href="{{ route('admin.offices.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 flex-fill">View All</a>
      </div>
    </div>
  </div>
</div>

@if($sliders->count() > 1)
<script>
(function() {
  let currentSlide = 0;
  const totalSlides = {{ $sliders->count() }};
  const track = document.getElementById('adminCarouselTrack');
  const counter = document.getElementById('adminSlideCounter');
  const dots = document.querySelectorAll('#adminCarouselDots button');
  let autoplayTimer;

  function updateCarousel() {
    if (!track) return;
    track.style.transform = 'translateX(-' + (currentSlide * 100) + '%)';
    if (counter) counter.textContent = (currentSlide + 1) + ' / ' + totalSlides;
    dots.forEach((dot, i) => {
      dot.classList.toggle('active', i === currentSlide);
    });
  }

  function startAutoplay() {
    autoplayTimer = setInterval(() => {
      currentSlide = (currentSlide + 1) % totalSlides;
      updateCarousel();
    }, 4000);
  }

  function resetAutoplay() {
    clearInterval(autoplayTimer);
    startAutoplay();
  }

  window.adminCarouselMove = function(dir) {
    currentSlide = (currentSlide + dir + totalSlides) % totalSlides;
    updateCarousel();
    resetAutoplay();
  };

  window.adminCarouselGoTo = function(index) {
    currentSlide = index;
    updateCarousel();
    resetAutoplay();
  };

  startAutoplay();
})();
</script>
@endif

<script>
(function() {
  const picker = document.getElementById('primaryColorPicker');
  const hexInput = document.getElementById('primaryColorHex');
  const previewHeader = document.getElementById('previewHeader');
  const previewBtn = document.getElementById('previewBtn');
  const previewAccent = document.getElementById('previewAccent');
  const presetBtns = document.querySelectorAll('.preset-color-btn');

  if (!picker) return;

  function applyColor(color) {
    picker.value = color;
    hexInput.value = color.toUpperCase();
    if (previewHeader) previewHeader.style.background = color;
    if (previewBtn) previewBtn.style.background = color;
    if (previewAccent) previewAccent.style.background = color;

    // Update active preset
    presetBtns.forEach(btn => {
      const isActive = btn.dataset.color.toUpperCase() === color.toUpperCase();
      btn.classList.toggle('active', isActive);
      btn.innerHTML = isActive ? '<svg width="16" height="16" fill="#fff" viewBox="0 0 24 24" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%)"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>' : '';
    });
  }

  picker.addEventListener('input', (e) => applyColor(e.target.value));

  hexInput.addEventListener('input', function() {
    let val = this.value;
    if (!val.startsWith('#')) val = '#' + val;
    if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
      applyColor(val);
    }
  });

  presetBtns.forEach(btn => {
    btn.addEventListener('click', () => applyColor(btn.dataset.color));
  });

  window.resetAppearance = function() {
    applyColor('#009639');
  };
})();
</script>

@endsection
