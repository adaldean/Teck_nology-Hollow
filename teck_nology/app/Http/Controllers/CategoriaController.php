<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Muestra una lista de todas las categorías.
     * GET /categories
     */
    public function index()
    {
        // Obtiene todas las categorías ordenadas por nombre
        $categories = Categoria::orderBy('name')->get(); 
        
        // Retorna la vista de índice (listado)
        return view('categories.index', compact('categories'));
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     * GET /categories/create
     */
    public function create()
    {
        // Retorna la vista del formulario de creación
        return view('categories.create');
    }

    /**
     * Almacena una categoría recién creada en la base de datos.
     * POST /categories
     */
    public function store(Request $request)
    {
        // 1. Validación de datos
        $request->validate([
            // 'name' es obligatorio, debe ser único en la tabla 'categories', y max 255 caracteres
            'name' => 'required|unique:categories|max:255', 
            // 'description' es opcional (nullable) y max 1000 caracteres
            'description' => 'nullable|max:1000', 
        ]);

        // 2. Creación del registro
        Categoria::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // 3. Redirección con mensaje de éxito
        return redirect()->route('categories.index')
                         ->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Muestra una categoría específica.
     * GET /categories/{category}
     * @param  \App\Models\Category  $category (Route Model Binding)
     */
    public function show(Categoria $category)
    {
        // Retorna la vista mostrando los detalles de la categoría
        return view('categories.show', compact('category'));
    }

    /**
     * Muestra el formulario para editar una categoría específica.
     * GET /categories/{category}/edit
     * @param  \App\Models\Category  $category (Route Model Binding)
     */
    public function edit(Categoria $category)
    {
        // Retorna la vista del formulario de edición, pasando la categoría
        return view('categories.edit', compact('category'));
    }

    /**
     * Actualiza la categoría específica en la base de datos.
     * PUT/PATCH /categories/{category}
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category (Route Model Binding)
     */
    public function update(Request $request, Categoria $category)
    {
        // 1. Validación de datos
        $request->validate([
            // La validación de unicidad debe ignorar el ID de la categoría actual
            'name' => 'required|max:255|unique:categories,name,'.$category->id, 
            'description' => 'nullable|max:1000',
        ]);

        // 2. Actualización del registro
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // 3. Redirección con mensaje de éxito
        return redirect()->route('categories.index')
                         ->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Elimina una categoría específica de la base de datos.
     * DELETE /categories/{category}
     * @param  \App\Models\Category  $category (Route Model Binding)
     */
    public function destroy(Categoria $category)
    {
        // Elimina el registro
        $category->delete();

        // Redirección con mensaje de éxito
        return redirect()->route('categories.index')
                         ->with('success', 'Categoría eliminada exitosamente.');
    }
}