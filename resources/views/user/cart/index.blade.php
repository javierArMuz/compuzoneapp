@extends('layouts.user')

@section('title', 'Carrito de Compras')

@section('content')
<div class="container py-5">
  <h1 class="mb-4 fw-bold">🛒 Carrito de Compras</h1>

  <!-- Manejo de Mensajes de Sesión (Éxito o Error) -->
  @if(Session::has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ Session::get('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  @if(Session::has('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ Session::get('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  @if (empty($cartItems))
  <!-- Carrito Vacío -->
  <div class="alert alert-info text-center py-4 border-0 shadow-sm">
    <h4 class="alert-heading">Tu carrito está vacío 😔</h4>
    <p>Parece que aún no has agregado productos. ¡Explora nuestra tienda!</p>
    <hr>
    <a href="{{ route('shop.index') }}" class="btn btn-primary mt-2">Ir a la Tienda</a>
  </div>
  @else
  <!-- Carrito con Productos -->
  <div class="row">

    <!-- Columna de Artículos (Tabla) -->
    <div class="col-lg-8">
      <div class="card shadow-sm mb-4">
        <div class="card-body p-0">
          <table class="table table-hover mb-0">
            <thead class="bg-light">
              <tr>
                <th scope="col" class="border-0">Producto</th>
                <th scope="col" class="border-0 text-center">Precio</th>
                <th scope="col" class="border-0 text-center">Cantidad</th>
                <th scope="col" class="border-0 text-center">Total</th>
                <th scope="col" class="border-0 text-center">Acción</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($cartItems as $id => $item)
              <tr>
                <td class="align-middle">
                  <div class="d-flex align-items-center">
                    <img src="{{ $item['image_url'] }}"
                      alt="{{ $item['name'] }}"
                      style="width: 50px; height: 50px; object-fit: cover;"
                      class="rounded me-3">
                    <div>
                      <h6 class="fw-bold mb-0">{{ $item['name'] }}</h6>
                      <small class="text-muted">Marca: {{ $item['brand_name'] }}</small>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-center">${{ number_format($item['price'], 2) }}</td>

                <!-- Formulario de Actualización de Cantidad -->
                <td class="align-middle text-center" style="width: 150px;">
                  <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex justify-content-center" onchange="this.submit()">
                    @csrf
                    @method('PUT')
                    <input type="number"
                      name="quantity"
                      value="{{ $item['quantity'] }}"
                      min="1"
                      class="form-control form-control-sm text-center"
                      style="width: 70px;">
                  </form>
                </td>

                <td class="align-middle text-center fw-bold text-success">
                  ${{ number_format($item['price'] * $item['quantity'], 2) }}
                </td>

                <!-- Formulario de Eliminación -->
                <td class="align-middle text-center">
                  <form action="{{ route('cart.remove', $id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Remover producto">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Columna de Resumen del Carrito -->
    <div class="col-lg-4">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-bold">
          Resumen del Pedido
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between mb-3">
            <span class="text-muted">Subtotal ({{ count($cartItems) }} artículos)</span>
            <span class="fw-semibold">${{ number_format($subtotal, 2) }}</span>
          </div>

          <div class="d-flex justify-content-between mb-4">
            <span class="text-muted">Costo de Envío</span>
            <span class="fw-semibold text-danger">Gratis!</span>
          </div>

          <hr>

          <div class="d-flex justify-content-between mb-4">
            <span class="fs-5 fw-bold">Total a Pagar</span>
            <span class="fs-5 fw-bold text-primary">${{ number_format($subtotal, 2) }}</span>
          </div>

          {{-- FORMULARIO DE PAGO --}}
          <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <button class="btn btn-success btn-lg w-100" type="submit">
              <i class="fas fa-credit-card me-2"></i> Proceder al Pago
            </button>
          </form>
          {{-- FIN DEL FORMULARIO DE PAGO --}}

          <p class="text-center mt-3 mb-0">
            <a href="{{ route('shop.index') }}" class="text-decoration-none">Seguir comprando</a>
          </p>
        </div>
      </div>
    </div>

  </div>
  @endif
</div>
@endsection