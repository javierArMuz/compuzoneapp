@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h2 fw-bold">Gestión de Usuarios</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-success shadow-sm">
      <i class="fas fa-plus me-2"></i> Crear Nuevo Usuario
    </a>
  </div>

  @if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  @if (session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <div class="card shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="bg-light">
            <tr>
              <th class="border-top-0">ID</th>
              <th class="border-top-0">Nombre</th>
              <th class="border-top-0">Email</th>
              <!-- <th class="border-top-0">Rol</th> -->
              <th class="border-top-0">Creado en</th>
              <th class="border-top-0 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $user)
            <tr>
              <td class="align-middle">{{ $user->id }}</td>
              <td class="align-middle">{{ $user->first_name }}</td>
              <td class="align-middle">{{ $user->email }}</td>
              <!-- <td class="align-middle">
                <span class="badge 
                                    @if ($user->role === 'admin') bg-primary 
                                    @else bg-secondary 
                                    @endif
                                    text-uppercase">
                  {{ $user->role }}
                </span>
              </td> -->
              <td class="align-middle">{{ $user->created_at->format('Y-m-d') }}</td>
              <td class="align-middle text-center">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm text-white" title="Editar">
                  <i class="far text-warning">&#xf044;</i>
                </a>
                {{-- Formulario de eliminación --}}
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de que desea eliminar este usuario?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm" title="Eliminar">
                    <i class='far text-danger'>&#xf2ed;</i>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center py-4">No se encontraron usuarios.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer bg-white border-top">
      {{ $users->links() }}
    </div>
  </div>
</div>
@endsection