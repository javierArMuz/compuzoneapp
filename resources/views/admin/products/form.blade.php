@extends('layouts.admin'){{-- El layout --}}

@section('content')
<div style="max-width:800px;margin:24px auto;">
  <h2>{{ $editing ? 'Editar Producto' : 'Registrar Producto' }}</h2>

  {{-- Formulario crear/editar --}}
  <form method="POST" action="{{ $editing ? route('admin.products.update', $product) : route('admin.products.store') }}">
    @csrf
    @if($editing) @method('PUT') @endif

    <label>Nombre</label>
    <input type="text" name="name" value="{{ old('name',$product->name) }}" required maxlength="100"><br>
    {{-- Mensaje de error --}}
    @error('name')
    <div style="color:red">{{ $message }}</div>
    @enderror

    <label>Descripción</label>
    <textarea name="description">{{ old('description',$product->description) }}</textarea><br>
    {{-- Mensaje de error --}}
    @error('description')
    <div style="color:red">{{ $message }}</div>
    @enderror

    <label>Marca</label>
    <select name="brand_id" required>
      <option value="">--Seleccione--</option>
      @foreach($brands as $b)
      <option value="{{ $b->id }}" {{ old('brand_id',$product->brand_id)==$b->id?'selected':'' }}>{{ $b->name }}</option>
      @endforeach
    </select><br>
    {{-- Mensaje de error --}}
    @error('brand_id')
    <div style="color:red">{{ $message }}</div>
    @enderror

    <label>Modelo</label>
    <input type="text" name="model" value="{{ old('model',$product->model) }}"><br>
    {{-- Mensaje de error --}}
    @error('model')
    <div style="color:red">{{ $message }}</div>
    @enderror

    <label>Precio</label>
    <input type="number" step="0.01" name="price" value="{{ old('price',$product->price) }}" required><br>
    {{-- Mensaje de error --}}
    @error('price')
    <div style="color:red">{{ $message }}</div>
    @enderror

    <label>Stock</label>
    <input type="number" name="stock" value="{{ old('stock',$product->stock) }}" required><br>
    {{-- Mensaje de error --}}
    @error('stock')
    <div style="color:red">{{ $message }}</div>
    @enderror

    <label>Categoría</label>
    <select name="category_id" required>
      <option value="">--Seleccione--</option>
      @foreach($categories as $c)
      <option value="{{ $c->id }}" {{ old('category_id',$product->category_id)==$c->id?'selected':'' }}>{{ $c->name }}</option>
      @endforeach
    </select><br>
    {{-- Mensaje de error --}}
    @error('category_id')
    <div style="color:red">{{ $message }}</div>
    @enderror

    <label>Imagen (URL)</label>
    <input type="url" name="image_url" value="{{ old('image_url',$product->image_url) }}"><br>
    {{-- Mensaje de error --}}
    @error('image_url')
    <div style="color:red">{{ $message }}</div>
    @enderror

    <label>Activo</label>
    <input type="checkbox" name="is_active" value="1" {{ old('is_active',$product->is_active)?'checked':'' }}><br><br>
    {{-- Mensaje de error --}}
    @error('is_active')
    <div style="color:red">{{ $message }}</div>
    @enderror

    <button type="submit">{{ $editing ? 'Actualizar' : 'Guardar' }}</button>
    <a href="{{ route('admin.products.index') }}">Cancelar</a>
  </form>
</div>
@endsection