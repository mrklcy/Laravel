@extends('admin.pso-layout')

@section('title', 'Inventory Performance')

@section('content')

<div class="mb-4">
  <h1 class="h3 fw-bold mb-1">Inventory Performance</h1>
  <p class="text-muted mb-0">Monitor property and supply management indicators</p>
</div>

<!-- Key Performance Indicators -->
<div class="row g-3 mb-4">
  <div class="col-md-6 col-xl-3">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <div class="small text-muted mb-1">Stock Accuracy</div>
            <h2 class="fw-bold mb-0" style="color: var(--pso-blue);">85%</h2>
          </div>
          <div class="text-success">
            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path d="M7 14l5-5 5 5z"/>
            </svg>
          </div>
        </div>
        <div class="small text-success">+5% from last quarter</div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-3">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <div class="small text-muted mb-1">On-Time Delivery</div>
            <h2 class="fw-bold mb-0 text-success">92%</h2>
          </div>
          <div class="text-success">
            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path d="M7 14l5-5 5 5z"/>
            </svg>
          </div>
        </div>
        <div class="small text-success">+3% from last quarter</div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-3">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <div class="small text-muted mb-1">Inventory Utilization</div>
            <h2 class="fw-bold mb-0 text-warning">78%</h2>
          </div>
          <div class="text-warning">
            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path d="M7 10l5 5 5-5z"/>
            </svg>
          </div>
        </div>
        <div class="small text-warning">-2% from last quarter</div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-3">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <div class="small text-muted mb-1">Requisition Fulfillment</div>
            <h2 class="fw-bold mb-0 text-info">4.5/5</h2>
          </div>
          <div class="text-success">
            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path d="M7 14l5-5 5 5z"/>
            </svg>
          </div>
        </div>
        <div class="small text-success">+0.3 from last quarter</div>
      </div>
    </div>
  </div>
</div>

<!-- Performance Charts -->
<div class="row g-3 mb-4">
  <div class="col-lg-8">
    <div class="card rounded-4 border">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Inventory Trends</h5>
        <div class="alert alert-info rounded-4">
          <strong>Chart Placeholder:</strong> Inventory trend visualization will be displayed here using Chart.js
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card rounded-4 border h-100">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Target vs Actual</h5>
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-2">
            <span class="small">Property Accountability</span>
            <span class="fw-bold small">85/100</span>
          </div>
          <div class="progress" style="height: 8px;">
            <div class="progress-bar" style="width: 85%; background: var(--pso-blue);"></div>
          </div>
        </div>
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-2">
            <span class="small">Supply Fulfillment</span>
            <span class="fw-bold small">92/100</span>
          </div>
          <div class="progress" style="height: 8px;">
            <div class="progress-bar bg-success" style="width: 92%;"></div>
          </div>
        </div>
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-2">
            <span class="small">Inventory Accuracy</span>
            <span class="fw-bold small">78/100</span>
          </div>
          <div class="progress" style="height: 8px;">
            <div class="progress-bar bg-warning" style="width: 78%;"></div>
          </div>
        </div>
        <div>
          <div class="d-flex justify-content-between mb-2">
            <span class="small">Requisition Response</span>
            <span class="fw-bold small">90/100</span>
          </div>
          <div class="progress" style="height: 8px;">
            <div class="progress-bar bg-info" style="width: 90%;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Detailed Metrics Table -->
<div class="card rounded-4 border">
  <div class="card-header bg-white border-bottom py-3">
    <h5 class="fw-bold mb-0">Detailed Inventory Metrics</h5>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="bg-light">
          <tr>
            <th class="px-4 py-3">Metric</th>
            <th class="py-3">Target</th>
            <th class="py-3">Actual</th>
            <th class="py-3">Achievement</th>
            <th class="py-3">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="px-4 py-3">
              <div class="fw-bold">Property Accountability Rate</div>
              <small class="text-muted">Overall property tracking accuracy</small>
            </td>
            <td class="py-3">80%</td>
            <td class="py-3">85%</td>
            <td class="py-3">
              <div class="progress" style="height: 8px; width: 100px;">
                <div class="progress-bar bg-success" style="width: 106%;"></div>
              </div>
            </td>
            <td class="py-3"><span class="badge bg-success">Exceeds Target</span></td>
          </tr>
          <tr>
            <td class="px-4 py-3">
              <div class="fw-bold">Supply Delivery Rate</div>
              <small class="text-muted">On-time supply distribution</small>
            </td>
            <td class="py-3">85%</td>
            <td class="py-3">92%</td>
            <td class="py-3">
              <div class="progress" style="height: 8px; width: 100px;">
                <div class="progress-bar bg-success" style="width: 108%;"></div>
              </div>
            </td>
            <td class="py-3"><span class="badge bg-success">Exceeds Target</span></td>
          </tr>
          <tr>
            <td class="px-4 py-3">
              <div class="fw-bold">Inventory Efficiency</div>
              <small class="text-muted">Optimal stock level maintenance</small>
            </td>
            <td class="py-3">85%</td>
            <td class="py-3">78%</td>
            <td class="py-3">
              <div class="progress" style="height: 8px; width: 100px;">
                <div class="progress-bar bg-warning" style="width: 92%;"></div>
              </div>
            </td>
            <td class="py-3"><span class="badge bg-warning">Below Target</span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
