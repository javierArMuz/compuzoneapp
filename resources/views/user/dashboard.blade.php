@extends('layouts.user')

@section('title', 'CompuzoneApp | Usuario')

@section('content')

<!-- Galería de Productos -->
<main class="flex-grow-1 p-4">
  <div class="container-lg">

    <h1 class="mb-4 text-dark display-6 fw-bold border-bottom pb-2">
      <i class="fa-solid fa-laptop me-2 text-primary"></i>
      Catálogo de Productos Disponibles
    </h1>

    <!-- Fila de la Cuadrícula para Productos -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">

      <!-- INICIO DEL LOOP DE BLADE: Recorre la colección $products inyectada por el Controlador -->
      @foreach ($products as $product)
      <div class="col">
        <div class="card product-card shadow-sm h-100 {{ $product->stock == 0 ? 'opacity-50' : '' }}">
          <!-- Imagen del Producto -->
          <!-- Usa la URL o el PATH de la imagen del producto -->
          <img src="{{ $product->image_url ?? 'https://placehold.co/400x200/cccccc/333333?text=Sin+Imagen' }}"
            class="card-img-top-custom rounded-top"
            alt="Producto: {{ $product->name }}">

          <div class="card-body d-flex flex-column">
            <!-- Nombre del Artículo -->
            <!-- Limita el texto con la clase text-truncate de Bootstrap -->
            <h5 class="card-title fw-bold text-truncate" title="{{ $product->name }}">
              {{ $product->name }}
            </h5>
            <!-- Precio del Artículo (Formateado como moneda, si usas un helper de Laravel) -->
            <h4 class="card-text text-primary mb-3">
              <span class="fw-bolder">${{ number_format($product->price, 2) }}</span>
            </h4>
            <!-- <a href="{{ route('products.show', $product->id) }}" class="block hover:shadow-lg transition duration-300 rounded-lg overflow-hidden">
              <div class="p-4">
                <h3 class="text-xl font-semibold mb-1">{{ $product->name }}</h3>
                <p class="text-green-600 font-bold">${{ number_format($product->price, 2) }}</p>
              </div>
            </a> -->

            <!-- Botones de Acción -->
            <div class="d-grid gap-2 mt-auto">
              <!-- Botón Ver Detalles (Usando el ID del producto) -->
              <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm">
                <i class="fa-solid fa-eye me-1"></i> Ver Detalles
              </a>

              <!-- Botón Agregar al Carrito (Debe ser un formulario POST en la vida real) -->
              <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                @if ($product->stock > 0)
                <button type="submit" class="btn btn-success btn-sm w-100">
                  <i class="fa-solid fa-cart-plus me-1"></i> Agregar al Carrito
                </button>
                @else
                <button class="btn btn-secondary btn-sm w-100 cursor-not-allowed" disabled>Producto Agotado
                </button>
                @endif
              </form>
            </div>
          </div>
        </div>
      </div>
      @endforeach
      <!-- FIN DEL LOOP DE BLADE -->

      <!-- Manejo de Caso: Si no hay productos -->
      @if ($products->isEmpty())
      <div class="col-12 mt-5 text-center">
        <p class="lead text-muted">No se encontraron productos en el catálogo.</p>
      </div>
      @endif

    </div>

  </div>
</main>

@endsection