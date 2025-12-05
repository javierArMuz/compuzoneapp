@extends('layouts.admin')

@section('title', 'CompuzoneApp | Admin')

@section('content')
<div class="container-fluid mt-4">
  <h1 class="mb-4 text-dark">Panel</h1>

  <div class="row">

    <!-- Tarjeta de Productos -->
    <div class="col-md-4 mb-4">
      <div class="card shadow border-left-primary h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters">
            <div class="col mr-2 text-center">
              <div class="text-xs font-weight-bold mb-1">Productos</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $productCount }}</div>
              <a href="{{ route('admin.products.index') }}" class="text-primary small mt-2 d-block">Ver Productos &rarr;</a>
            </div>
            <div class="col-auto">
              <!-- Icono de Productos -->
              <i class="fas fa-box fa-1x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tarjeta de Categorías -->
    <div class="col-md-4 mb-4">
      <div class="card shadow border-left-success h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters">
            <div class="col mr-2 text-center">
              <div class="text-xs font-weight-bold mb-1">Categorías</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $categoryCount }}</div>
              <a href="{{ route('admin.categories.index') }}" class="text-primary small mt-2 d-block">Ver Categorías &rarr;</a>
            </div>
            <div class="col-auto">
              <!-- Icono de Categorías -->
              <i class="fas fa-folder fa-1x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tarjeta de Marcas -->
    <div class="col-md-4 mb-4">
      <div class="card shadow border-left-warning h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters">
            <div class="col mr-2 text-center">
              <div class="text-xs font-weight-bold mb-1">Marcas</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $brandCount }}</div>
              <a href="{{ route('admin.brands.index') }}" class="text-primary small mt-2 d-block">Ver Marcas &rarr;</a>
            </div>
            <div class="col-auto">
              <!-- Icono de Marcas -->
              <i class="fas fa-tags fa-1x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tarjeta de Usuarios -->
    <div class="col-md-4 mb-4">
      <div class="card shadow border-left-warning h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters">
            <div class="col mr-2 text-center">
              <div class="text-xs font-weight-bold mb-1">Usuarios</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $userCount }}</div>
              <a href="{{ route('admin.users.index') }}" class="text-primary small mt-2 d-block">Ver Usuarios &rarr;</a>
            </div>
            <div class="col-auto">
              <!-- Icono de Usuarios -->
              <i class="fas fa-users fa-1x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tarjeta de Pedidos -->
    <div class="col-md-4 mb-4">
      <div class="card shadow border-left-warning h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters">
            <div class="col mr-2 text-center">
              <div class="text-xs font-weight-bold mb-1">Pedidos</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orderCount }}</div>
              <a href="{{ route('admin.users.index') }}" class="text-primary small mt-2 d-block">Ver Pedidos &rarr;</a>
            </div>
            <div class="col-auto">
              <!-- Icono de Pedidos -->
              <i class="fas fa-shopping-basket fa-1x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Aquí puedes añadir más contenido específico del dashboard -->
</div>
@endsection