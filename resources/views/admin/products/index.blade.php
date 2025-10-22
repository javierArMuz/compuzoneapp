@extends('layouts.admin')

@section('title', 'CompuzoneApp | Admin/Productos')

@section('content')
<div class="container-fluid mt-4">
	<div class="d-flex justify-content-between align-items-center mb-3">
		<h2 class="h2 fw-bold">Listado de Productos</h2>
		<a href="{{ route('admin.products.create') }}" class="btn btn-success"><i class="fas fa-plus me-2"></i>Nuevo Producto</a>
	</div>

	{{-- Muestra mensaje de éxito si existe --}}
	@if(session('ok'))
	<div class="alert alert-success" role="alert">
		{{ session('ok') }}
	</div>
	@endif

	{{-- Tabla de productos --}}
	<div class="card shadow-sm">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead class="bg-dark text-white">
						<tr>
							<th>ID</th>
							<th>Nombre</th>
							<th>Marca</th>
							<th>Categoría</th>
							<th>Modelo</th>
							<th>Precio</th>
							<th>Stock</th>
							<th>Activo</th>
							<th class="ps-3">Acciones</th>
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
							<td>
								@if($p->is_active)
								<span class="badge bg-success">Sí</span>
								@else
								<span class="badge bg-danger">No</span>
								@endif
							</td>
							<td style="width: 150px;">
								<a href="{{ route('admin.products.edit', $p) }}" class="btn" title="Editar"><i class="far text-warning">&#xf044;</i></a>
								<form method="POST" action="{{ route('admin.products.destroy', $p) }}" style="display:inline" onsubmit="return confirm('¿Eliminar este producto?');">
									@csrf @method('DELETE')
									<!-- <button type="submit" class="btn btn-danger btn-sm"><i class='far'>&#xf2ed;</i></button> -->
									<button type="submit" class="btn" title="Eliminar"><i class='far text-danger'>&#xf2ed;</i></button>
								</form>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="9" class="text-center">No hay productos registrados</td>
						</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="mt-3">
		{{ $products->links() }}
	</div>
</div>
@endsection