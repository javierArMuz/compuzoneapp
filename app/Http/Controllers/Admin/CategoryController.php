<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
	// Listado + formulario
	public function index()
	{
		// Obtiene todas las categorías y los envía a la vista
		$categories = \App\Models\Category::orderBy('name')->paginate(10);
		return view('admin.categories.index', [
			'categories' => $categories,
			'editing'    => false,
			'category'   => null,
		]);
	}

	// Muestra el formulario de edición para una categoría específica.
	public function edit(\App\Models\Category $category)
	{
		$categories = \App\Models\Category::orderBy('name')->paginate(10);
		return view('admin.categories.index', [
			'categories' => $categories,
			'editing'    => true,
			'category'   => $category,
		]);
	}

	public function store(\Illuminate\Http\Request $request)
	{
		// Valida los datos del formulario
		$validated = $request->validate([
			'name' => ['required', 'string', 'max:30', 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]+$/u', 'unique:categories,name'],
		]);
		// Crea una nueva categoría con los datos validados
		\App\Models\Category::create($validated);
		// Redirige con mensaje de éxito
		return redirect()->route('admin.categories.index')->with('ok', 'Categoría creada');
	}

	// Actualiza una categoría
	public function update(\Illuminate\Http\Request $request, \App\Models\Category $category)
	{
		$validated = $request->validate([
			'name' => ['required', 'string', 'max:30', 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]+$/u', \Illuminate\Validation\Rule::unique('categories', 'name')->ignore($category->id)],
		]);
		$category->update($validated);
		return redirect()->route('admin.categories.index')->with('ok', 'Categoría actualizada');
	}

	// Elimina una categoría
	public function destroy(\App\Models\Category $category)
	{
		$category->delete();
		return back()->with('ok', 'Categoría eliminada');
	}
}
