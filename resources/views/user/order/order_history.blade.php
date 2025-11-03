@extends('layouts.user')

@section('title', 'Mis Pedidos')

@section('content')
<div class="container py-5">
  <h2 class="mb-5 fw-bold text-primary border-bottom pb-2"><i class="fa-solid fa-bag-shopping"></i> Mi Historial de Pedidos</h2>

  {{-- Verifica si hay pedidos para mostrar --}}
  @if ($orders->isEmpty())
  <div class="alert alert-info text-center py-5 border-0 shadow-sm">
    <h4 class="alert-heading">No tienes pedidos registrados.</h4>
    <p>¡Es momento de explorar nuestros productos y realizar tu primera compra!</p>
    <hr>
    <a href="{{ route('shop.index') }}" class="btn btn-primary mt-2">Ir a la Tienda</a>
  </div>
  @else
  {{-- Itera sobre cada pedido del usuario --}}
  @foreach ($orders as $order)
  <div class="card shadow-sm mb-4 border-0">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
      <div class="fw-bold">
        Pedido N°: <span class="text-primary">{{ $order->order_number }}</span>
      </div>
      <div>
        Fecha: {{ $order->created_at->format('d/m/Y') }}
      </div>
    </div>
    <div class="card-body">
      <div class="row align-items-center">
        <div class="col-md-4 mb-3 mb-md-0">
          <p class="mb-1 text-muted">Estado:</p>
          {{-- Muestra una insignia de color según el estado --}}
          <span class="badge 
                            @if($order->status == 'completed') bg-success 
                            @elseif($order->status == 'pending') bg-warning 
                            @else bg-danger 
                            @endif 
                            text-uppercase py-2 px-3">
            {{ $order->status }}
          </span>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
          <p class="mb-1 text-muted">Total:</p>
          <h4 class="fw-bolder text-success mb-0">${{ number_format($order->total_amount, 2) }}</h4>
        </div>
        <div class="col-md-4 text-md-end">
          {{-- Botón para ver el detalle completo (redirige a la confirmación, que ahora actúa como detalle) --}}
          <a href="{{ route('order.confirmation', $order->order_number) }}" class="btn btn-outline-secondary btn-sm">
            Ver Detalles <i class="fas fa-chevron-right ms-1"></i>
          </a>
        </div>
      </div>

      <hr class="my-3">

      {{-- Muestra una vista previa de los productos comprados --}}
      <p class="fw-semibold mb-2">Productos en este pedido:</p>
      <div class="d-flex flex-wrap gap-2">
        @foreach ($order->items->take(5) as $item) {{-- Solo muestra los primeros 5 ítems --}}
        <div class="d-flex align-items-center border rounded p-2 bg-white">
          <img src="{{ $item->product_image_url ?? 'https://placehold.co/30x30/3498db/FFFFFF?text=P' }}"
            alt="{{ $item->product_name }}"
            style="width: 30px; height: 30px; object-fit: cover;"
            class="rounded me-2">
          <small class="text-truncate" style="max-width: 150px;">{{ $item->product_name }} (x{{ $item->quantity }})</small>
        </div>
        @endforeach
        @if ($order->items->count() > 5)
        <span class="text-muted small align-self-center ms-2">+ {{ $order->items->count() - 5 }} más...</span>
        @endif
      </div>

    </div>
  </div>
  @endforeach
  @endif
</div>
@endsection