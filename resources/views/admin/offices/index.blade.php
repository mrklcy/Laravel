@extends('admin.admin-layout')

@section('title','Offices')
@section('crumb','Offices')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
  <strong>Success!</strong> {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
  <strong>Error!</strong> {{ session('error') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <img src="/images/clsu-logo-green.png" alt="CLSU Seal" style="width:56px;height:56px;border-radius:14px;background:#fff;border:2px solid var(--clsu-green-500);object-fit:contain;">
    <div>
      <h1 class="h3 fw-bold mb-1">Offices</h1>
      <div class="text-muted">Manage ADSO offices and their information.</div>
    </div>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.offices.create') }}" class="btn btn-gold rounded-4">+ Add Office</a>
  </div>
</div>

<div class="row g-3">
  @foreach($offices as $office)
  <div class="col-12 col-md-6 col-xl-4">
    <div class="card card-accent rounded-4 border h-100">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between mb-3">
          <div class="rounded-4 d-flex align-items-center justify-content-center" style="width:48px;height:48px;background:rgba(0,150,57,.1);">
            <svg class="text-success" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
          </div>
          <span class="badge rounded-pill" style="background:var(--clsu-gold);">{{ $office->acronym }}</span>
        </div>
        <h3 class="h5 fw-bold mb-2">{{ $office->name }}</h3>
        @if($office->overview)
        <p class="text-muted small mb-3">{{ Str::limit($office->overview, 100) }}</p>
        @endif
        <div class="d-flex gap-2">
          <a href="{{ route('office.show', $office->code) }}" class="btn btn-sm btn-outline-secondary rounded-3" target="_blank">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
            View
          </a>
          <a href="{{ route('admin.offices.edit', $office) }}" class="btn btn-sm btn-outline-primary rounded-3">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit
          </a>
          <form action="{{ route('admin.offices.destroy', $office) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this office?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3">
              <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="me-1">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
              </svg>
              Delete
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>

@if($offices->isEmpty())
<div class="card rounded-4 border">
  <div class="card-body text-center py-5">
    <div class="text-muted mb-3">
      <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mx-auto">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
      </svg>
    </div>
    <h5 class="fw-bold mb-2">No Offices Found</h5>
    <p class="text-muted">There are no offices configured yet.</p>
  </div>
</div>
@endif

@endsection
