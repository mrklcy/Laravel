@extends('admin.admin-layout')

@section('title','Create News')
@section('crumb','Create News')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary rounded-4">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
      </svg>
    </a>
    <div>
      <h1 class="h3 fw-bold mb-1">Create News Article</h1>
      <div class="text-muted">Add a new news article or announcement</div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="mb-3">
            <label for="title" class="form-label fw-bold">Article Title <span class="text-danger">*</span></label>
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
            <small class="text-muted">URL-friendly identifier (e.g., new-office-opening)</small>
            @error('slug')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="office_id" class="form-label fw-bold">Related Office</label>
            <select class="form-select rounded-3 @error('office_id') is-invalid @enderror" 
                    id="office_id" name="office_id">
              <option value="">Select Office (Optional)</option>
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
            <label for="content" class="form-label fw-bold">Content <span class="text-danger">*</span></label>
            <textarea class="form-control rounded-3 @error('content') is-invalid @enderror" 
                      id="content" name="content" rows="8" required>{{ old('content') }}</textarea>
            <small class="text-muted">Full article content</small>
            @error('content')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="excerpt" class="form-label fw-bold">Excerpt</label>
            <textarea class="form-control rounded-3 @error('excerpt') is-invalid @enderror" 
                      id="excerpt" name="excerpt" rows="3">{{ old('excerpt') }}</textarea>
            <small class="text-muted">Brief summary for listings</small>
            @error('excerpt')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="image" class="form-label fw-bold">Featured Image</label>
            <input type="file" class="form-control rounded-3 @error('image') is-invalid @enderror" 
                   id="image" name="image" accept="image/*">
            <small class="text-muted">Optional featured image for the article</small>
            @error('image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="is_published" name="is_published" 
                     value="1" {{ old('is_published', true) ? 'checked' : '' }}>
              <label class="form-check-label fw-bold" for="is_published">
                Published
              </label>
              <small class="d-block text-muted">Unpublished articles won't be visible publicly</small>
            </div>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-gold rounded-4 px-4">
              <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              Create Article
            </button>
            <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary rounded-4 px-4">Cancel</a>
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
          <li class="mb-2">Use clear, descriptive titles</li>
          <li class="mb-2">Slugs should be lowercase with hyphens</li>
          <li class="mb-2">Add an excerpt for better preview in listings</li>
          <li>Featured images should be at least 1200x630px</li>
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection
