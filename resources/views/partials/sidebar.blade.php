<div id="sidebar-wrapper" class="collapsed">
  <div class="sidebar-heading d-flex justify-content-between align-items-center">
    <div class="hamburger-icon" id="hamburger-desktop">☰</div>
    <h5 class="my-0">Admin</h5>
  </div>
  <div class="list-group list-group-flush">
    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action" title="Home"><i class="fas fa-home"></i></a>
    <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action" title="Productos"><i class="fas fa-box"></i><span>Productos</span></a>
    <a href="{{ route('admin.brands.index') }}" class="list-group-item list-group-item-action" title="Marcas"><i class="fas fa-tags"></i><span>Marcas</span></a>
    <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action" title="Categorías"><i class="fas fa-folder"></i><span>Categorías</span></a>
    <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action" title="Usuarios"><i class="fas fa-users"></i><span>Usuarios</span></a>
    <a href="{{ route('admin.orders.index') }}" class="list-group-item list-group-item-action" title="Pedidos"><i class="fas fa-shopping-basket"></i><span>Pedidos</span></a>
    <a href="#" class="list-group-item list-group-item-action" title="Ajustes"><i class="fas fa-cog"></i><span>Ajustes</span></a>
    <a href="#"
      title="Cerrar"
      class="list-group-item"
      onclick="event.preventDefault(); if (confirm('¿Estás seguro de que quieres cerrar la sesión?')) { document.getElementById('logout-form').submit(); }">
      <i class="fas fa-sign-out-alt"></i><span>Cerrar</span>
    </a>
  </div>
</div>