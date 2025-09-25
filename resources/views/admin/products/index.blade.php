@extends('layouts.admin'){{-- El layout --}}

@section('content')
<div class="container-fluid mt-4">
	<div class="d-flex justify-content-between align-items-center mb-3">
		<h2>Listado de Productos</h2>
		<a href="{{ route('admin.products.create') }}" class="btn btn-success">➕ Nuevo Producto</a>
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
							<td>
								@if($p->is_active)
								<span class="badge bg-success">Sí</span>
								@else
								<span class="badge bg-danger">No</span>
								@endif
							</td>
							<td>
								<a href="{{ route('admin.products.edit', $p) }}" class="btn btn-warning btn-sm me-2">Editar</a>
								<form method="POST" action="{{ route('admin.products.destroy', $p) }}" style="display:inline" onsubmit="return confirm('¿Eliminar este producto?');">
									@csrf @method('DELETE')
									<button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
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