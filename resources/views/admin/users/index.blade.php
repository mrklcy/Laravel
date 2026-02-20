@extends('admin.admin-layout')

@section('title','Users')
@section('crumb','Users')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
  <strong>Success!</strong> {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="d-flex justify-content-between align-items-start mb-3">
  <div class="d-flex align-items-center gap-3">
    <img src="/images/clsu-logo-green.png" alt="CLSU Seal" style="width:56px;height:56px;border-radius:14px;background:#fff;border:2px solid var(--clsu-green-500);object-fit:contain;">
    <div>
      <h1 class="h3 fw-bold mb-1">Users</h1>
      <div class="text-muted">Manage admin employees</div>
    </div>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.users.create') }}" class="btn btn-gold rounded-4">+ Add Employee</a>
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
            <th>Created</th>
            <th class="text-end px-4">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($employees as $employee)
          <tr>
            <td class="px-4 py-3 fw-bold">{{ $employee->full_name }}</td>
            <td>{{ $employee->email }}</td>
            <td>{{ $employee->created_at->format('M d, Y') }}</td>
            <td class="px-4 text-end">
              <a href="{{ route('admin.users.edit', $employee) }}" class="btn btn-sm btn-outline-primary">Edit</a>
              <form action="{{ route('admin.users.destroy', $employee) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this employee?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="text-center py-5 text-muted">
              No employees found. <a href="{{ route('admin.users.create') }}">Create one</a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
