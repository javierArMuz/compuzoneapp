@extends('layouts.app')

@section('title', 'CompuzoneApp | Admin/Categorías')

@section('content')
<div class="container-fluid py-4">
  <div class="card shadow-sm p-4">
    <h2 class="mb-3">{{ !empty($editing) ? 'Editar Categoría' : 'Registrar Categoría' }}</h2>

    {{-- Mensajes de éxito --}}
    @if (session('ok'))
    <div class="alert alert-success mt-3" role="alert">
      {{ session('ok') }}
    </div>
    @endif

    {{-- Mensajes de error --}}
    @if ($errors->any())
    <div class="alert alert-danger mt-3" role="alert">
      <ul>
        @foreach ($errors->all() as $e)
        <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    {{-- Formulario crear/editar --}}
    <form method="POST"
      action="{{ empty($editing) ? route('admin.categories.store') : route('admin.categories.update', $category) }}">
      @csrf
      @if(!empty($editing))
      @method('PUT')
      @endif

      <div class="mb-3">
        <input type="text"
          name="name"
          class="form-control"
          placeholder="Nombre de la categoría"
          minlength="1" maxlength="30"
          pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}"
          required
          value="{{ old('name', $category->name ?? '') }}">
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
          {{ !empty($editing) ? 'Actualizar' : 'Guardar' }}
        </button>
        @if(!empty($editing))
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancelar</a>
        @endif
      </div>
    </form>

    <hr class="my-4">

    <h3 class="mb-3">Listado de Categorías</h3>

    {{-- Tabla de Categorías --}}
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead>
          <tr>
            <th scope="col">Nombre</th>
            <th scope="col" style="width: 20%;" class="ps-3">Acciones</th>
          </tr>
        </thead>
        <tbody>
          {{-- Itera sobre las Categorías --}}
          @forelse ($categories as $c)
          <tr>
            <td>{{ $c->name }}</td>
            <td class="d-flex gap-2">
              <a href="{{ route('admin.categories.edit', $c) }}" class="btn"><i class="far text-warning">&#xf044;</i></a>
              <form method="POST"
                action="{{ route('admin.categories.destroy', $c) }}"
                onsubmit="return confirm('¿Seguro de eliminar esta categoría?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn"><i class='far text-danger'>&#xf2ed;</i></button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="2" class="text-center">No hay categorías registradas</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $categories->links() }}
    </div>
  </div>
</div>
@endsection