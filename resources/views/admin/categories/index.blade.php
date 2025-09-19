@extends('layouts.admin') {{-- El layout --}}
@section('content')

<div style="max-width:720px;margin:24px auto;font-family:system-ui, sans-serif">
  <h2>{{ !empty($editing) ? 'Editar Categoría' : 'Registrar Categoría' }}</h2>

  {{-- Mensajes --}}
  @if (session('ok'))
  <div style="padding:8px 12px;background:#e8f5e9;border:1px solid #a5d6a7;margin-bottom:12px">
    {{ session('ok') }}
  </div>
  @endif

  {{-- Errores --}}
  @if ($errors->any())
  <div style="padding:8px 12px;background:#ffebee;border:1px solid #ef9a9a;margin-bottom:12px">
    <ul style="margin:0;padding-left:18px">
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

    <input type="text"
      name="name"
      placeholder="Nombre de la categoría"
      minlength="1" maxlength="30"
      pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}"
      required
      value="{{ old('name', $category->name ?? '') }}"
      style="width:100%;padding:8px;border:1px solid #ccc;border-radius:6px">
    <br><br>

    <button type="submit"
      style="padding:8px 14px;border:0;background:#111;color:#fff;border-radius:6px;cursor:pointer">
      {{ !empty($editing) ? 'Actualizar' : 'Guardar' }}
    </button>

    @if(!empty($editing))
    <a href="{{ route('admin.categories.index') }}"
      style="margin-left:8px">Cancelar</a>
    @endif
  </form>

  <hr style="margin:24px 0">

  <h3>Listado de Categorías</h3>

  {{-- Tabla de Categorías --}}
  <table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th align="left">Nombre</th>
        <th width="160">Acciones</th>
      </tr>
    </thead>
    <tbody>
      {{-- Itera sobre las Categorías --}}
      @forelse ($categories as $c)
      <tr>
        <td>{{ $c->name }}</td>
        <td>
          <a href="{{ route('admin.categories.edit', $c) }}">Editar</a>

          <form method="POST"
            action="{{ route('admin.categories.destroy', $c) }}"
            style="display:inline"
            onsubmit="return confirm('¿Seguro de eliminar esta categoría?');">
            @csrf @method('DELETE')
            <button type="submit">Eliminar</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="2">Sin categorías</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <div style="margin-top:12px">
    {{ $categories->links() }}
  </div>
</div>

@endsection