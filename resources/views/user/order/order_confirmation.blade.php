@extends('layouts.user')

@section('title', 'Confirmación')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-success text-white text-center py-4 rounded-top-3">
          <i class="fas fa-check-circle fa-3x mb-2"></i>
          <h2 class="fw-bold mb-0">¡Gracias por tu compra!</h2>
        </div>

        <div class="card-body p-4 p-md-5">

          {{-- Mensaje de Éxito General --}}
          @if(Session::has('success'))
          <div class="alert alert-success text-center border-0 shadow-sm">
            {{ Session::get('success') }}
          </div>
          @endif

          {{-- Información Clave del Pedido --}}
          <div class="text-center mb-4 border-bottom pb-3">
            <p class="text-muted fs-6">Tu pedido ha sido registrado y el inventario ha sido actualizado.</p>
            <h4 class="mb-3 fw-bold text-primary">ID del Pedido: <span class="text-success">{{ $order->order_number }}</span></h4>
            <h3 class="mb-4">Total Pagado: <span class="fw-bolder">${{ number_format($order->total_amount, 2) }}</span></h3>
          </div>

          {{-- Detalle del Pedido --}}
          <h4 class="fw-bold mb-3 border-start border-4 border-primary ps-3">Artículos Comprados</h4>
          <ul class="list-group mb-4 shadow-sm">
            {{-- Iteramos sobre la relación 'items' cargada desde el controlador --}}
            @foreach ($order->items as $item)
            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
              <div class="d-flex align-items-center">
                {{-- Usamos los datos guardados en la tabla order_items --}}
                <img src="{{ $item->product_image_url ?? 'https://placehold.co/40x40/3498db/FFFFFF?text=P' }}"
                  alt="{{ $item->product_name }}"
                  style="width: 40px; height: 40px; object-fit: cover;"
                  class="rounded me-3 border">
                <div>
                  <h6 class="mb-0 fw-semibold">{{ $item->product_name }}</h6>
                  <small class="text-muted">Precio unitario: ${{ number_format($item->price, 2) }}</small>
                </div>
              </div>
              <div class="text-end">
                <span class="badge bg-secondary rounded-pill me-3">x{{ $item->quantity }}</span>
                <span class="fw-bold text-success">${{ number_format($item->price * $item->quantity, 2) }}</span>
              </div>
            </li>
            @endforeach
          </ul>

          {{-- Botón de Acción --}}
          <div class="text-center mt-4 pt-3 border-top">
            <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg px-5 shadow">
              <i class="fas fa-shopping-bag me-2"></i> Seguir Comprando
            </a>
            {{-- Puedes agregar aquí un enlace a la vista de "Mis Pedidos" --}}
            <p class="text-muted mt-3 mb-0">¿Necesitas ayuda? Contáctanos.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection