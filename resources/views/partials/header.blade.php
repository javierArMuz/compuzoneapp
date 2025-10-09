<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg">
    <div class="container-fluid container-lg">

      <!-- Logo y Nombre de la Aplicación -->
      <a class="navbar-brand d-flex align-items-center" href="#">
        <span class="logo-icon me-2"></span>
        <span class="h5 m-0 text-white fw-bold">CompuzoneApp</span>
      </a>

      <!-- Botón de Tienda/Home -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-none d-lg-flex">
        <li class="nav-item">
          <!-- Asume que la tienda es la página principal (Home) -->
          <a class="nav-link text-white" href="#">
            <i class="fa-solid fa-store me-1"></i> Tienda
          </a>
        </li>
      </ul>

      <!-- Contenedor para Carrito y Perfil (Alineado a la derecha) -->
      <div class="d-flex align-items-center gap-3">
        <!-- Botón de Carrito con Insignia de Conteo -->
        <a href="#" class="cart-icon-btn position-relative">
          <i class="fa-solid fa-shopping-cart fa-xl"></i> <!-- Icono más grande -->
          <!-- Insignia (badge) para el conteo de artículos -->
          <span class="position-absolute translate-middle badge rounded-pill cart-badge">
            3
            <span class="visually-hidden">Productos en el carrito</span>
          </span>
        </a>

        <!-- Dropdown de Perfil (Avatar y Menú de Cuenta) -->
        <div class="dropdown">
          <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <!-- Icono de Usuario con fondo o Avatar -->
            <i class="fa-solid fa-circle-user fa-lg me-2 text-info"></i>
            <span class="fw-normal d-none d-sm-inline">Nombre del Usuario</span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
            <!-- Enlace al Perfil del Usuario -->
            <li>
              <a class="dropdown-item rounded" href="#">
                <i class="fa-solid fa-user-circle me-2"></i> Mi Perfil
              </a>
            </li>
            <!-- Enlace a Pedidos/Historial -->
            <li>
              <a class="dropdown-item rounded" href="#">
                <i class="fa-solid fa-receipt me-2"></i> Mis Pedidos
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <!-- Botón para Cerrar Sesión -->
            <li>
              <a class="dropdown-item rounded text-danger" href="{{ route('auth.temp_logout') }}">
                <i class="fa-solid fa-sign-out-alt me-2"></i> Cerrar Sesión
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</header>