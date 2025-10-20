@extends('layouts.user')

@section('title', 'Confirmación')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-lg border-0">
        <div class="card-header bg-success text-white text-center py-4">
          <i class="fas fa-check-circle fa-3x mb-2"></i>
          <h2 class="fw-bold mb-0">¡Gracias por tu compra!</h2>
        </div>

        <div class="card-body p-4 p-md-5">

          {{-- Mensaje de Éxito General --}}
          @if(Session::has('success'))
          <div class="alert alert-success text-center">
            {{ Session::get('success') }}
          </div>
          @endif

          {{-- Información Clave del Pedido --}}
          <div class="text-center mb-4">
            <p class="text-muted fs-5">Tu pedido ha sido registrado con éxito.</p>
            <h4 class="mb-3 fw-bold text-primary">ID del Pedido: <span class="text-success">{{ $orderId }}</span></h4>
            <h3 class="mb-4">Total Pagado: <span class="fw-bolder">${{ number_format($totalAmount, 2) }}</span></h3>
          </div>

          <hr>

          {{-- Detalle del Pedido --}}
          <h4 class="fw-bold mb-3">Detalle de los Artículos Comprados</h4>
          <ul class="list-group mb-4">
            @foreach ($purchasedItems as $item)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <img src="{{ $item['image_url'] }}"
                  alt="{{ $item['name'] }}"
                  style="width: 40px; height: 40px; object-fit: cover;"
                  class="rounded me-3 border">
                <div>
                  <h6 class="mb-0 fw-semibold">{{ $item['name'] }}</h6>
                  <small class="text-muted">${{ number_format($item['price'], 2) }} c/u</small>
                </div>
              </div>
              <span class="badge bg-secondary rounded-pill me-3">x{{ $item['quantity'] }}</span>
              <span class="fw-bold">${{ number_format($item['subtotal'], 2) }}</span>
            </li>
            @endforeach
          </ul>

          <hr>

          {{-- Botón de Acción --}}
          <div class="text-center mt-4">
            <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg px-5">
              <i class="fas fa-shopping-bag me-2"></i> Seguir Comprando
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection