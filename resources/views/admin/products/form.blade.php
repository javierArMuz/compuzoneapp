@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
	<div class="card shadow-sm mx-auto" style="max-width: 800px;">
		<div class="card-header bg-dark text-white">
			<h2 class="h5 m-0">{{ $editing ? 'Editar Producto' : 'Registrar Producto' }}</h2>
		</div>
		<div class="card-body">
			{{-- Formulario crear/editar --}}
			<form method="POST" action="{{ $editing ? route('admin.products.update', $product) : route('admin.products.store') }}">
				@csrf
				@if($editing) @method('PUT') @endif

				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="name" class="form-label">Nombre</label>
							<input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required maxlength="100">
							{{-- Mensaje de error --}}
							@error('name')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="brand_id" class="form-label">Marca</label>
							<select id="brand_id" name="brand_id" class="form-select @error('brand_id') is-invalid @enderror" required>
								<option value="">--Seleccione--</option>
								@foreach($brands as $b)
								<option value="{{ $b->id }}" {{ old('brand_id', $product->brand_id) == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
								@endforeach
							</select>
							{{-- Mensaje de error --}}
							@error('brand_id')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="model" class="form-label">Modelo</label>
							<input type="text" id="model" name="model" class="form-control @error('model') is-invalid @enderror" value="{{ old('model', $product->model) }}">
							{{-- Mensaje de error --}}
							@error('model')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="category_id" class="form-label">Categoría</label>
							<select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
								<option value="">--Seleccione--</option>
								@foreach($categories as $c)
								<option value="{{ $c->id }}" {{ old('category_id', $product->category_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
								@endforeach
							</select>
							{{-- Mensaje de error --}}
							@error('category_id')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="price" class="form-label">Precio</label>
							<input type="number" id="price" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
							{{-- Mensaje de error --}}
							@error('price')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="stock" class="form-label">Stock</label>
							<input type="number" id="stock" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock) }}" required>
							{{-- Mensaje de error --}}
							@error('stock')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>

				<div class="mb-3">
					<label for="description" class="form-label">Descripción</label>
					<textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
					{{-- Mensaje de error --}}
					@error('description')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				<div class="mb-3">
					<label for="image_url" class="form-label">Imagen (URL)</label>
					<input type="url" id="image_url" name="image_url" class="form-control @error('image_url') is-invalid @enderror" value="{{ old('image_url', $product->image_url) }}">
					{{-- Mensaje de error --}}
					@error('image_url')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				<div class="form-check mb-3">
					<input type="checkbox" id="is_active" name="is_active" class="form-check-input @error('is_active') is-invalid @enderror" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
					<label for="is_active" class="form-check-label">Activo</label>
					{{-- Mensaje de error --}}
					@error('is_active')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				<button type="submit" class="btn btn-primary">{{ $editing ? 'Actualizar' : 'Guardar' }}</button>
				<a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancelar</a>
			</form>
		</div>
	</div>
</div>
@endsection