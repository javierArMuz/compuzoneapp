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
    <!-- La cuadrícula se adapta: 1 columna en móvil, 2 en tablets/medianos, 4 en grandes -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">

      <!-- INICIO: Tarjeta de Producto de Ejemplo -->
      <div class="col">
        <div class="card product-card shadow-sm h-100">
          <!-- Imagen del Producto -->
          <img src="https://placehold.co/400x200/535C91/FFFFFF?text=Tarjeta+Gr%C3%A1fica"
            class="card-img-top-custom rounded-top"
            alt="Producto: Tarjeta Gráfica RTX">

          <div class="card-body d-flex flex-column">
            <!-- Nombre del Artículo -->
            <h5 class="card-title fw-bold text-truncate" title="Tarjeta Gráfica RTX SuperPro Z300">
              Tarjeta Gráfica RTX SuperPro Z300
            </h5>
            <!-- Precio del Artículo -->
            <h4 class="card-text text-primary mb-3">
              <span class="fw-bolder">$499.99</span>
            </h4>

            <!-- Botones de Acción -->
            <div class="d-grid gap-2 mt-auto">
              <!-- Botón Ver Detalles (Azul) -->
              <a href="#" class="btn btn-outline-primary btn-sm">
                <i class="fa-solid fa-eye me-1"></i> Ver Detalles
              </a>
              <!-- Botón Agregar al Carrito (Verde) -->
              <a href="#" class="btn btn-success btn-sm">
                <i class="fa-solid fa-cart-plus me-1"></i> Agregar al Carrito
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- FIN: Tarjeta de Producto de Ejemplo -->

      <!-- COPIA: Tarjeta de Producto de Ejemplo 2 -->
      <div class="col">
        <div class="card product-card shadow-sm h-100">
          <!-- Imagen del Producto -->
          <img src="https://placehold.co/400x200/0d6efd/FFFFFF?text=Monitor+4K"
            class="card-img-top-custom rounded-top"
            alt="Producto: Monitor Curvo 4K 144Hz">

          <div class="card-body d-flex flex-column">
            <!-- Nombre del Artículo -->
            <h5 class="card-title fw-bold text-truncate" title="Monitor Curvo 4K 144Hz - 27 Pulgadas">
              Monitor Curvo 4K 144Hz
            </h5>
            <!-- Precio del Artículo -->
            <h4 class="card-text text-primary mb-3">
              <span class="fw-bolder">$349.50</span>
            </h4>

            <!-- Botones de Acción -->
            <div class="d-grid gap-2 mt-auto">
              <a href="#" class="btn btn-outline-primary btn-sm">
                <i class="fa-solid fa-eye me-1"></i> Ver Detalles
              </a>
              <a href="#" class="btn btn-success btn-sm">
                <i class="fa-solid fa-cart-plus me-1"></i> Agregar al Carrito
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- COPIA: Tarjeta de Producto de Ejemplo 3 -->
      <div class="col">
        <div class="card product-card shadow-sm h-100">
          <!-- Imagen del Producto -->
          <img src="https://placehold.co/400x200/9b59b6/FFFFFF?text=Disco+SSD+2TB"
            class="card-img-top-custom rounded-top"
            alt="Producto: Disco Duro SSD M.2 2TB">

          <div class="card-body d-flex flex-column">
            <!-- Nombre del Artículo -->
            <h5 class="card-title fw-bold text-truncate" title="Disco Duro SSD M.2 2TB Ultra Rápido">
              Disco Duro SSD M.2 2TB
            </h5>
            <!-- Precio del Artículo -->
            <h4 class="card-text text-primary mb-3">
              <span class="fw-bolder">$129.00</span>
            </h4>

            <!-- Botones de Acción -->
            <div class="d-grid gap-2 mt-auto">
              <a href="#" class="btn btn-outline-primary btn-sm">
                <i class="fa-solid fa-eye me-1"></i> Ver Detalles
              </a>
              <a href="#" class="btn btn-success btn-sm">
                <i class="fa-solid fa-cart-plus me-1"></i> Agregar al Carrito
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- COPIA: Tarjeta de Producto de Ejemplo 4 -->
      <div class="col">
        <div class="card product-card shadow-sm h-100">
          <!-- Imagen del Producto -->
          <img src="https://placehold.co/400x200/2ecc71/FFFFFF?text=Teclado+Mec%C3%A1nico"
            class="card-img-top-custom rounded-top"
            alt="Producto: Teclado Mecánico RGB Pro">

          <div class="card-body d-flex flex-column">
            <!-- Nombre del Artículo -->
            <h5 class="card-title fw-bold text-truncate" title="Teclado Mecánico RGB Pro Wireless">
              Teclado Mecánico RGB Pro
            </h5>
            <!-- Precio del Artículo -->
            <h4 class="card-text text-primary mb-3">
              <span class="fw-bolder">$75.99</span>
            </h4>

            <!-- Botones de Acción -->
            <div class="d-grid gap-2 mt-auto">
              <a href="#" class="btn btn-outline-primary btn-sm">
                <i class="fa-solid fa-eye me-1"></i> Ver Detalles
              </a>
              <a href="#" class="btn btn-success btn-sm">
                <i class="fa-solid fa-cart-plus me-1"></i> Agregar al Carrito
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- ... Puedes añadir más tarjetas aquí ... -->

    </div>

  </div>
</main>

@endsection