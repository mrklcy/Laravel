@extends('admin.admin-layout')

@section('title','View Inquiry')
@section('crumb','View Inquiry')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary rounded-4">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
      </svg>
    </a>
    <div>
      <h1 class="h3 fw-bold mb-1">Inquiry Details</h1>
      <div class="text-muted">View inquiry information</div>
    </div>
  </div>
  <div>
    @if($inquiry->status === 'pending')
      <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
    @elseif($inquiry->status === 'resolved')
      <span class="badge bg-success px-3 py-2">Resolved</span>
    @else
      <span class="badge bg-secondary px-3 py-2">{{ ucfirst($inquiry->status) }}</span>
    @endif
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-3">{{ $inquiry->subject }}</h5>
        
        <div class="mb-4">
          <h6 class="text-muted small mb-2">MESSAGE</h6>
          <p class="mb-0">{{ $inquiry->message }}</p>
        </div>

        @if($inquiry->response)
        <div class="alert alert-success border-0">
          <h6 class="fw-bold mb-2">Response</h6>
          <p class="mb-0">{{ $inquiry->response }}</p>
        </div>
        @endif

        <form action="{{ route('admin.inquiries.update', $inquiry) }}" method="POST" class="mt-4">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label for="response" class="form-label fw-bold">Response</label>
            <textarea class="form-control rounded-3 @error('response') is-invalid @enderror" 
                      id="response" name="response" rows="4">{{ old('response', $inquiry->response) }}</textarea>
            @error('response')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="status" class="form-label fw-bold">Status</label>
            <select class="form-select rounded-3 @error('status') is-invalid @enderror" 
                    id="status" name="status">
              <option value="pending" {{ old('status', $inquiry->status) === 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="resolved" {{ old('status', $inquiry->status) === 'resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-gold rounded-4 px-4">
              <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              Update Inquiry
            </button>
            <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary rounded-4 px-4">Back to List</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card rounded-4 border bg-light">
      <div class="card-body">
        <h5 class="fw-bold mb-3">Contact Information</h5>
        <div class="small">
          <div class="mb-3">
            <div class="text-muted small">NAME</div>
            <div class="fw-bold">{{ $inquiry->name }}</div>
          </div>
          <div class="mb-3">
            <div class="text-muted small">EMAIL</div>
            <div class="fw-bold">
              <a href="mailto:{{ $inquiry->email }}" class="text-decoration-none">{{ $inquiry->email }}</a>
            </div>
          </div>
          @if($inquiry->phone)
          <div class="mb-3">
            <div class="text-muted small">PHONE</div>
            <div class="fw-bold">{{ $inquiry->phone }}</div>
          </div>
          @endif
          <div class="mb-3">
            <div class="text-muted small">SUBMITTED</div>
            <div class="fw-bold">{{ $inquiry->created_at->format('M d, Y g:i A') }}</div>
          </div>
          @if($inquiry->updated_at != $inquiry->created_at)
          <div class="mb-0">
            <div class="text-muted small">LAST UPDATED</div>
            <div class="fw-bold">{{ $inquiry->updated_at->format('M d, Y g:i A') }}</div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
