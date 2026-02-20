@extends('admin.hrm-layout')

@section('title','Users')
@section('crumb','Users')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h1 class="h3 fw-bold mb-1">Employee Management</h1>
    <p class="text-muted mb-0">Manage Human Resources department employees</p>
  </div>
  <a href="{{ route('admin.hrm.employees.create') }}" class="btn btn-gold rounded-4">
    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" class="me-2">
      <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
    </svg>
    Add Employee
  </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card rounded-4 border">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="bg-light">
          <tr>
            <th class="px-4 py-3">Employee ID</th>
            <th class="py-3">Name</th>
            <th class="py-3">Position</th>
            <th class="py-3">Status</th>
            <th class="py-3">Employment Type</th>
            <th class="py-3 text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($employees as $employee)
          <tr>
            <td class="px-4 py-3">
              <span class="fw-bold">{{ $employee->employee_id }}</span>
            </td>
            <td class="py-3">
              <div class="fw-bold">{{ $employee->first_name }} {{ $employee->last_name }}</div>
              <small class="text-muted">{{ $employee->email }}</small>
            </td>
            <td class="py-3">{{ $employee->position ?? 'N/A' }}</td>
            <td class="py-3">
              @if($employee->status === 'active')
                <span class="badge rounded-pill" style="background: var(--clsu-green); color: white;">Active</span>
              @elseif($employee->status === 'on_leave')
                <span class="badge rounded-pill" style="background: var(--clsu-gold); color: white;">On Leave</span>
              @elseif($employee->status === 'inactive')
                <span class="badge rounded-pill bg-secondary">Inactive</span>
              @else
                <span class="badge rounded-pill" style="background: var(--clsu-cobra); color: white;">Retired</span>
              @endif
            </td>
            <td class="py-3">
              <span class="badge bg-light text-dark">{{ ucfirst(str_replace('_', ' ', $employee->employment_status)) }}</span>
            </td>

            <td class="py-3 text-end">
              <div class="btn-group btn-group-sm">
                <a href="{{ route('admin.hrm.employees.edit', $employee->id) }}" class="btn btn-outline-primary">
                  <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                  </svg>
                  Edit
                </a>
                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete({{ $employee->id }})">
                  <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                  </svg>
                  Delete
                </button>
              </div>
              
              <form id="delete-form-{{ $employee->id }}" action="{{ route('admin.hrm.employees.destroy', $employee->id) }}" method="POST" class="d-none">
                @csrf
                @method('DELETE')
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-5 text-muted">
              <svg width="48" height="48" fill="currentColor" viewBox="0 0 24 24" class="mb-3 opacity-50">
                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
              </svg>
              <div>No employees found in Human Resources department</div>
              <a href="{{ route('admin.hrm.employees.create') }}" class="btn btn-sm btn-gold rounded-3 mt-3">Add First Employee</a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
function confirmDelete(id) {
  if (confirm('Are you sure you want to delete this employee? This action cannot be undone.')) {
    document.getElementById('delete-form-' + id).submit();
  }
}
</script>

@endsection
