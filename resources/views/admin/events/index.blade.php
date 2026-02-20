@extends('admin.admin-layout')

@section('title','Events')
@section('crumb','Events')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
  <strong>Success!</strong> {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <img src="/images/clsu-logo-green.png" alt="CLSU Seal" style="width:56px;height:56px;border-radius:14px;background:#fff;border:2px solid var(--clsu-green);object-fit:contain;">
    <div>
      <h1 class="h3 fw-bold mb-1">Events</h1>
      <div class="text-muted">Manage campus events and activities</div>
    </div>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.events.create') }}" class="btn btn-gold rounded-4">+ Add Event</a>
  </div>
</div>

<div class="card rounded-4 border">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="bg-light">
          <tr>
            <th class="px-4 py-3">Title</th>
            <th>Office</th>
            <th>Location</th>
            <th>Event Date</th>
            <th>Status</th>
            <th class="text-end px-4">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($events as $event)
          <tr>
            <td class="px-4 py-3 fw-bold">{{ $event->title }}</td>
            <td>{{ $event->office->acronym ?? 'N/A' }}</td>
            <td>{{ $event->location ?? 'N/A' }}</td>
            <td>{{ $event->event_date ? $event->event_date->format('M d, Y h:i A') : 'TBD' }}</td>
            <td>
              @if($event->is_active)
                <span class="badge bg-success">Active</span>
              @else
                <span class="badge bg-secondary">Inactive</span>
              @endif
            </td>
            <td class="px-4 text-end">
              <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-outline-primary">Edit</a>
              <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this event?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-5 text-muted">
              No events found. <a href="{{ route('admin.events.create') }}">Create one</a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
