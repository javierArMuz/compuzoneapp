<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg">
    <div class="container-fluid container-lg">

      <!-- Logo y Nombre de la Aplicación -->
      <a class="navbar-brand d-flex align-items-center" href="#">
        <span class="logo-icon me-2"></span>
        <span class="h5 m-0 text-white fw-bold">CompuzoneApp</span>
      </a>

      <!-- Toggle Button para móviles -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>


      <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <!-- Enlaces de Navegación (Izquierda) -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link text-white active" aria-current="page" href="{{ route('shop.index') }}">
              <i class="fa-solid fa-store me-1"></i> Tienda
            </a>
          </li>
        </ul>

        <!-- Contenedor para la Búsqueda y Elementos de Usuario (Alineado a la derecha) -->
        <div class="d-flex align-items-center flex-column flex-lg-row ms-lg-auto gap-3 pt-3 pt-lg-0">

          <!-- Formulario de Búsqueda (Apuntando a la misma ruta para filtrar) -->
          <form class="d-flex search-form-responsive" role="search" method="GET" action="{{ route('shop.index') }}">
            <div class="input-group">
              <!-- AQUÍ ESTÁ EL CAMBIO CLAVE: Usamos 'value' para mantener el texto buscado -->
              <input class="form-control form-control-sm rounded-start-pill"
                type="search"
                name="search"
                placeholder="Buscar productos..."
                aria-label="Search"
                value="{{ $searchQuery ?? '' }}">
              <button class="btn btn-primary rounded-end-pill" type="submit">
                <i class="fa-solid fa-search"></i>
              </button>
            </div>
          </form>

          <!-- Botón de Carrito con Insignia de Conteo -->
          <a href="{{ route('cart.index')}}" class="cart-icon-btn position-relative">
            <i class="fa-solid fa-shopping-cart fa-xl"></i>

            <!-- Lógica de Conteo Dinámico -->
            <span class="position-absolute translate-middle badge rounded-pill cart-badge">
              {{
            collect(Session::get('cart', []))->sum(function ($item) {
                return $item['quantity'] ?? 0;
            }) 
              }}
              <span class="visually-hidden">Productos en el carrito</span>
            </span>
          </a>

          <!-- Dropdown de Perfil (Avatar y Menú de Cuenta) -->
          <div class="dropdown">
            <a class="nav-link dropdown-toggle text-white d-flex align-items-center p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-circle-user fa-lg me-2 text-info"></i>
              <!-- Muestra el nombre del usuario logueado -->
              <span class="fw-normal d-none d-sm-inline">{{ Auth::user()->name ?? 'Usuario' }}</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
              <li><a class="dropdown-item rounded" href="#"><i class="fa-solid fa-user-circle me-2"></i> Mi Perfil</a></li>
              <li><a class="dropdown-item rounded" href="#"><i class="fa-solid fa-receipt me-2"></i> Mis Pedidos</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <!-- Botón para Cerrar Sesión (Formulario POST requerido en Laravel) -->
              <li>
                <form method="POST" action="{{ route('auth.logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item rounded text-danger">
                    <i class="fa-solid fa-sign-out-alt me-2"></i> Cerrar Sesión
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>
</header>