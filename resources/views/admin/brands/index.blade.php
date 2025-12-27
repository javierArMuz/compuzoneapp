@extends('layouts.admin')

@section('title', 'CompuzoneApp | Admin/Marcas')

@section('content')
<div class="container-fluid py-4">
  <div class="card shadow-sm p-4">
    <h2 class="mb-3">{{ !empty($editing) ? 'Editar Marca' : 'Registrar Marca' }}</h2>

    {{-- Formulario crear/editar --}}
    <form method="POST"
      action="{{ empty($editing) ? route('admin.brands.store') : route('admin.brands.update', $brand) }}">
      @csrf
      @if(!empty($editing)) @method('PUT') @endif

      <div class="mb-3">
        <input type="text" name="name"
          class="form-control"
          placeholder="Nombre de la marca"
          minlength="1" maxlength="50"
          required
          pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,50}"
          value="{{ old('name', $brand->name ?? '') }}">
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
          {{ !empty($editing) ? 'Actualizar' : 'Guardar' }}
        </button>
        @if(!empty($editing))
        <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Cancelar</a>
        @endif
      </div>
    </form>

    <hr class="my-4">
    <h3 class="mb-3">Listado de Marcas</h3>

    {{-- Tabla de Marcas --}}
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead>
          <tr>
            <th scope="col">Nombre</th>
            <th scope="col" style="width: 20%;" class="ps-3">Acciones</th>
          </tr>
        </thead>
        <tbody>
          {{-- Itera sobre las Marcas --}}
          @forelse($brands as $b)
          <tr>
            <td>{{ $b->name }}</td>
            <td class="d-flex gap-2">
              <a href="{{ route('admin.brands.edit', $b) }}" class="btn"><i class="far text-warning">&#xf044;</i></a>
              <form method="POST" action="{{ route('admin.brands.destroy', $b) }}"
                onsubmit="return confirm('¿Eliminar marca?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn"><i class='far text-danger'>&#xf2ed;</i></button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="2" class="text-center">No hay marcas registradas</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $brands->links() }}
    </div>
  </div>
</div>
@endsection