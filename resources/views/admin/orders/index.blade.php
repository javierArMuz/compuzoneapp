@extends('layouts.admin')

@section('title', 'CompuzoneApp | Admin/Pedidos')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800 font-weight-bold">Gestión de Pedidos</h2>
    <span class="badge bg-primary">{{ $orders->total() }} Pedidos en total</span>
  </div>

  <div class="card shadow mb-4">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="bg-light text-muted uppercase small">
            <tr>
              <th class="ps-4 py-3">ID Pedido</th>
              <th class="py-3">Cliente</th>
              <th class="py-3">Total</th>
              <th class="py-3 text-center">Estado</th>
              <th class="py-3">Fecha</th>
              <th class="py-3 text-center pe-4">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
            <tr>
              <td class="ps-4 font-weight-bold">#{{ $order->id }}</td>
              <td>
                <div class="d-flex flex-column">
                  <span class="font-weight-bold">{{ $order->user->name }}</span>
                  <small class="text-muted">{{ $order->user->email }}</small>
                </div>
              </td>
              <td class="font-weight-bold">${{ number_format($order->total_amount, 2) }}</td>
              <td class="text-center">
                @php
                $badgeClass = match($order->status) {
                'pending' => 'bg-warning text-dark',
                'processing' => 'bg-info text-dark',
                'shipped' => 'bg-primary',
                'delivered' => 'bg-success',
                'cancelled' => 'bg-danger',
                default => 'bg-secondary',
                };
                @endphp
                <span class="badge rounded-pill {{ $badgeClass }} px-3">
                  {{ strtoupper($order->status) }}
                </span>
              </td>
              <td class="text-muted">{{ $order->created_at->format('d/m/Y') }}</td>
              <td class="text-center pe-4">
                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary shadow-sm">
                  <i class="fas fa-eye fa-sm"></i> Ver Detalle
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-center mt-4">
    {{ $orders->links('pagination::bootstrap-5') }}
  </div>
</div>
@endsection