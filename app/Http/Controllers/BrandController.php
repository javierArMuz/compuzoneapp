<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
	public function index()
	{
		// Obtiene todas las marcas y los envía a la vista
		$brands = Brand::orderBy('name')->paginate(10);
		return view('admin.brands.index', [
			'brands'   => $brands,
			'editing'  => false,
			'brand'    => null,
		]);
	}

	public function store(Request $request)
	{
		// Valida los datos del formulario
		$validated = $request->validate([
			'name' => [
				'required',
				'string',
				'max:50',
				'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]+$/u',
				'unique:brands,name'
			],
		]);

		// Crea una nueva marca con los datos validados
		Brand::create($validated);
		// Redirige con mensaje de éxito
		return redirect()->route('admin.brands.index')->with('ok', 'Marca creada');
	}

	// Muestra el formulario de edición para una marca específica.
	public function edit(Brand $brand)
	{
		$brands = Brand::orderBy('name')->paginate(10);
		return view('admin.brands.index', [
			'brands'   => $brands,
			'editing'  => true,
			'brand'    => $brand,
		]);
	}

	// Actualiza una marca
	public function update(Request $request, Brand $brand)
	{
		$validated = $request->validate([
			'name' => [
				'required',
				'string',
				'max:50',
				'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]+$/u',
				Rule::unique('brands', 'name')->ignore($brand->id),
			],
		]);

		$brand->update($validated);
		return redirect()->route('admin.brands.index')->with('ok', 'Marca actualizada');
	}

	// Elimina una marca
	public function destroy(Brand $brand)
	{
		$brand->delete();
		return back()->with('ok', 'Marca eliminada');
	}
}
