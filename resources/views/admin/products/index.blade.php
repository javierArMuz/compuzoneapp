@extends('layouts.app'){{-- El layout --}}

@section('content')
<div style="max-width:900px;margin:24px auto;font-family:sans-serif">
  <h2>Listado de Productos</h2>

  <a href="{{ route('admin.products.create') }}">➕ Nuevo Producto</a>

  {{-- Muestra mensaje de éxito si existe --}}
  @if(session('ok'))
  <div style="background:#e8f5e9;padding:10px;margin:12px 0;border:1px solid #a5d6a7">
    {{ session('ok') }}
  </div>
  @endif

  {{-- Tabla de productos --}}
  <table border="1" width="100%" cellpadding="6">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Marca</th>
        <th>Categoría</th>
        <th>Modelo</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Activo</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      {{-- Itera sobre los productos --}}
      @forelse($products as $p)
      <tr>
        <td>{{ $p->id }}</td>
        <td>{{ $p->name }}</td>
        <td>{{ $p->brand->name ?? 'N/A' }}</td>
        <td>{{ $p->category->name ?? 'N/A' }}</td>
        <td>{{ $p->model }}</td>
        <td>${{ number_format($p->price, 2) }}</td>
        <td>{{ $p->stock }}</td>
        <td>{{ $p->is_active ? 'Sí' : 'No' }}</td>
        <td>
          <a href="{{ route('admin.products.edit', $p) }}">Editar</a>
          <form method="POST" action="{{ route('admin.products.destroy', $p) }}"
            style="display:inline"
            onsubmit="return confirm('¿Eliminar este producto?');">
            @csrf @method('DELETE')
            <button type="submit">Eliminar</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="9">No hay productos registrados</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <div style="margin-top:10px">
    {{ $products->links() }}
  </div>
</div>
@endsection