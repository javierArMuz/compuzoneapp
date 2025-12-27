@extends('layouts.admin')

@section('title', 'CompuzoneApp | Admin/Pedidos/Detalle')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Detalle del Pedido #{{ $order->id }}</h2>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary shadow-sm">
      <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver
    </a>
  </div>

  <div class="row">
    <div class="col-md-6 mb-4">
      <div class="card shadow border-left-primary h-100 py-2">
        <div class="card-body">
          <h5 class="card-title font-weight-bold text-primary text-uppercase mb-3">
            Información del Cliente
          </h5>
          <div class="mb-2">
            <strong>Nombre:</strong> <span class="text-muted">{{ $order->user->first_name }}</span>
          </div>
          <div class="mb-2">
            <strong>Email:</strong> <span class="text-muted">{{ $order->user->email }}</span>
          </div>
          <div class="mb-0">
            <strong>Fecha Pedido:</strong> <span class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-4">
      <div class="card shadow h-100 py-2">
        <div class="card-body">
          <h5 class="card-title font-weight-bold text-success text-uppercase mb-3">
            Actualizar Estado del Pedido
          </h5>
          <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="input-group">
              <select name="status" class="form-select form-control bg-light border-0 small">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pendiente</option>
                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Procesando</option>
                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Enviado</option>
                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Entregado</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
              </select>
              <button type="submit" class="btn btn-primary px-4">Actualizar</button>
            </div>
            <small class="text-muted mt-2 d-block italic">Cambiar el estado notificará al cliente.</small>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3 bg-white">
      <h6 class="m-0 font-weight-bold text-primary">Productos Comprados</h6>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="bg-light">
            <tr>
              <th class="ps-4">Producto</th>
              <th class="text-center">Precio Unit.</th>
              <th class="text-center">Cantidad</th>
              <th class="text-end pe-4">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach($order->items as $item)
            <tr>
              <td class="ps-4 align-middle">{{ $item->product->name }}</td>
              <td class="text-center align-middle">${{ number_format($item->price, 2) }}</td>
              <td class="text-center align-middle">
                <span class="badge bg-info text-dark">{{ $item->quantity }}</span>
              </td>
              <td class="text-end pe-4 align-middle font-weight-bold">
                ${{ number_format($item->price * $item->quantity, 2) }}
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot class="bg-light">
            <tr>
              <td colspan="3" class="text-end font-weight-bold py-3">TOTAL DEL PEDIDO:</td>
              <td class="text-end pe-4 py-3">
                <span class="h4 font-weight-bold text-primary">
                  ${{ number_format($order->total_amount, 2) }}
                </span>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection