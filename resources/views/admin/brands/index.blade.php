@extends('layouts.admin'){{-- El layout --}}

@section('content')
<div style="max-width:720px;margin:24px auto;font-family:sans-serif">
  <h2>{{ !empty($editing) ? 'Editar Marca' : 'Registrar Marca' }}</h2>

  {{-- Mensajes --}}
  @if (session('ok'))
  <div style="background:#e8f5e9;padding:10px;border:1px solid #a5d6a7">{{ session('ok') }}</div>
  @endif

  {{-- Errores --}}
  @if ($errors->any())
  <div style="background:#ffebee;padding:10px;border:1px solid #ef9a9a">
    <ul>
      @foreach ($errors->all() as $e)
      <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  {{-- Formulario crear/editar --}}
  <form method="POST"
    action="{{ empty($editing) ? route('admin.brands.store') : route('admin.brands.update', $brand) }}">
    @csrf
    @if(!empty($editing)) @method('PUT') @endif

    <input type="text" name="name"
      placeholder="Nombre de la marca"
      minlength="1" maxlength="50"
      required
      pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,50}"
      value="{{ old('name', $brand->name ?? '') }}">
    <br><br>

    <button type="submit">
      {{ !empty($editing) ? 'Actualizar' : 'Guardar' }}
    </button>

    @if(!empty($editing))
    <a href="{{ route('admin.brands.index') }}">Cancelar</a>
    @endif
  </form>

  <hr>
  <h3>Listado de Marcas</h3>

  {{-- Tabla de Marcas --}}
  <table border="1" width="100%" cellpadding="6">
    <tr>
      <th>Nombre</th>
      <th>Acciones</th>
    </tr>
    {{-- Itera sobre las Marcas --}}
    @forelse($brands as $b)
    <tr>
      <td>{{ $b->name }}</td>
      <td>
        <a href="{{ route('admin.brands.edit', $b) }}">Editar</a>
        <form method="POST" action="{{ route('admin.brands.destroy', $b) }}"
          style="display:inline"
          onsubmit="return confirm('¿Eliminar marca?');">
          @csrf @method('DELETE')
          <button type="submit">Eliminar</button>
        </form>
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="2">No hay marcas</td>
    </tr>
    @endforelse
  </table>

  <div style="margin-top:10px">{{ $brands->links() }}</div>
</div>
@endsection