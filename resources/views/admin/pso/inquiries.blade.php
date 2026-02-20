@extends('admin.pso-layout')

@section('title','Inquiries')
@section('crumb','Inquiries')

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
      <h1 class="h3 fw-bold mb-1">PSO Inquiries</h1>
      <div class="text-muted">Inquiries directed to the PSO office</div>
    </div>
  </div>
</div>

<div class="card rounded-4 border">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="bg-light">
          <tr>
            <th class="px-4 py-3">Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Date</th>
            <th>Status</th>
            <th class="text-end px-4">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($inquiries as $inquiry)
          <tr>
            <td class="px-4 py-3 fw-bold">{{ $inquiry->name }}</td>
            <td>{{ $inquiry->email }}</td>
            <td>{{ Str::limit($inquiry->subject, 40) }}</td>
            <td>{{ $inquiry->created_at->format('M d, Y') }}</td>
            <td>
              @if($inquiry->status === 'pending')
                <span class="badge bg-warning">Pending</span>
              @else
                <span class="badge bg-success">Responded</span>
              @endif
            </td>
            <td class="px-4 text-end">
              <a href="{{ route('pso.inquiries.show', $inquiry) }}" class="btn btn-sm btn-outline-primary">View</a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-5 text-muted">
              No inquiries found for PSO.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
