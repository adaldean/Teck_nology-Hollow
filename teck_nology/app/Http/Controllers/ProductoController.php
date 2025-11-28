<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $categoria = $request->get('categoria');
        $orden = $request->get('orden');

        $query = Producto::query();

        if ($categoria) {
            $query->where('id_categoria', $categoria);
        }

        if ($orden == 'asc') {
            $query->orderBy('precio', 'asc');
        } elseif ($orden == 'desc') {
            $query->orderBy('precio', 'desc');
        } elseif ($orden == 'ofertas') {
            $query->where('precio', '<', 500); 
        }

        $productos = $query->paginate(12);

        return view('catalogo', compact('productos'));
    }
}
