<!-- Asume que extiendes de un layout base, por ejemplo, 'layouts.app' -->
@extends('layouts.user')

@section('title', $product->name)

@section('content')
<div class="container py-5">

  <!-- Enlace de regreso a la tienda -->
  <div class="mb-4">
    <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center">
      <i class="fas fa-arrow-left me-2"></i> Volver a la Tienda
    </a>
  </div>

  <!-- Contenedor principal del detalle (equivalente a flex y shadow-xl) -->
  <div class="card shadow-lg border-0">
    <div class="card-body p-0">
      <div class="row g-0">

        <!-- Columna de Imagen (w-full lg:w-1/2) -->
        <div class="col-lg-6 p-4 bg-light d-flex align-items-center justify-content-center">
          <!-- Contenedor de la Imagen -->
          <div class="text-center w-100 p-3">
            <img src="{{ $product->image_url ?? 'https://placehold.co/600x400/cccccc/333333?text=Sin+Imagen' }}"
              class="img-fluid rounded-3 shadow-sm"
              alt="Producto: {{ $product->name }}"
              style="max-height: 400px; object-fit: contain;">
          </div>
        </div>

        <!-- Columna de Información (w-full lg:w-1/2) -->
        <div class="col-lg-6 p-4 p-md-5">
          <h1 class="h2 card-title fw-bold text-dark mb-3">{{ $product->name }}</h1>

          <!-- Precio y Stock (equivalente a flex items-baseline) -->
          <div class="d-flex align-items-baseline mb-4">
            <span class="fs-3 fw-bolder text-success me-3">
              ${{ number_format($product->price, 2) }}
            </span>
            <span class="fs-6 text-muted">
              @if ($product->stock > 0)
              ({{ $product->stock }} disponibles)
              @else
              <span class="badge bg-danger fw-semibold">Agotado</span>
              @endif
            </span>
          </div>

          <!-- Descripción -->
          <div class="mb-4">
            <h2 class="h5 fw-bold text-dark mb-2">Descripción</h2>
            <p class="text-secondary">{{ $product->description }}</p>
          </div>

          <!-- Detalles Adicionales (Marca y Categoría) -->
          <div class="mb-4 p-3 bg-light rounded border">
            <p class="small text-muted mb-1">
              <span class="fw-semibold text-dark">Marca:</span>
              {{ $product->brand->name ?? 'N/A' }}
            </p>
            <p class="small text-muted mb-0">
              <span class="fw-semibold text-dark">Categoría:</span>
              {{ $product->category->name ?? 'N/A' }}
            </p>
          </div>

          <!-- Botón de Acción (Carrito) -->
          <div class="mt-4">
            @if ($product->stock > 0)
            <!-- Esto es un formulario, ya que la adición al carrito debe ser POST -->
            <form action="{{ route('cart.add', $product) }}" method="POST">
              @csrf
              <button type="submit"
                class="btn btn-primary btn-lg w-100 shadow-sm"
                style="font-size: 1.1rem; padding: .75rem 1.5rem;">
                <i class="fas fa-shopping-cart me-2"></i> Agregar al Carrito
              </button>
            </form>
            @else
            <button class="btn btn-secondary btn-lg w-100 cursor-not-allowed" disabled>
              Producto Agotado
            </button>
            @endif
          </div>

        </div>
      </div>
    </div>
  </div>

</div>
@endsection