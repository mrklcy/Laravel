@extends('admin.admin-layout')

@section('title','Create Event')
@section('crumb','Create Event')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary rounded-4">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
      </svg>
    </a>
    <div>
      <h1 class="h3 fw-bold mb-1">Create Event</h1>
      <div class="text-muted">Add a new campus event or activity</div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <form action="{{ route('admin.events.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label for="title" class="form-label fw-bold">Event Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control rounded-3 @error('title') is-invalid @enderror" 
                   id="title" name="title" value="{{ old('title') }}" required>
            @error('title')
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
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea class="form-control rounded-3 @error('description') is-invalid @enderror" 
                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
            <small class="text-muted">Brief summary of the event</small>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="content" class="form-label fw-bold">Full Details</label>
            <textarea class="form-control rounded-3 @error('content') is-invalid @enderror" 
                      id="content" name="content" rows="6">{{ old('content') }}</textarea>
            @error('content')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="location" class="form-label fw-bold">Location</label>
            <input type="text" class="form-control rounded-3 @error('location') is-invalid @enderror" 
                   id="location" name="location" value="{{ old('location') }}" placeholder="e.g., CLSU Auditorium">
            @error('location')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="event_date" class="form-label fw-bold">Start Date & Time</label>
              <input type="datetime-local" class="form-control rounded-3 @error('event_date') is-invalid @enderror" 
                     id="event_date" name="event_date" value="{{ old('event_date') }}">
              @error('event_date')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6">
              <label for="event_end_date" class="form-label fw-bold">End Date & Time</label>
              <input type="datetime-local" class="form-control rounded-3 @error('event_end_date') is-invalid @enderror" 
                     id="event_end_date" name="event_end_date" value="{{ old('event_end_date') }}">
              @error('event_end_date')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="order" class="form-label fw-bold">Display Order</label>
              <input type="number" class="form-control rounded-3 @error('order') is-invalid @enderror" 
                     id="order" name="order" value="{{ old('order', 0) }}" min="0">
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
              <small class="d-block text-muted">Inactive events won't be visible publicly</small>
            </div>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-gold rounded-4 px-4">
              <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              Create Event
            </button>
            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary rounded-4 px-4">Cancel</a>
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
          <li class="mb-2">Use clear, descriptive event titles</li>
          <li class="mb-2">Include the location for attendees</li>
          <li class="mb-2">Set start and end dates for better tracking</li>
          <li>Assign to an office if the event is office-specific</li>
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection
