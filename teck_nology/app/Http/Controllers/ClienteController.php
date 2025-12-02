<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    // Listar clientes con búsqueda y paginación
    public function index(Request $request)
    {
        $q = $request->query('q');

        $clientes = Cliente::query()
            ->when($q, function ($query) use ($q) {
                $query->where('nombre', 'LIKE', "%{$q}%")
                      ->orWhere('email', 'LIKE', "%{$q}%");
            })
            ->orderBy('id_cliente', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('privado.clientes', compact('clientes'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('privado.clientes_crear');
    }

    // Guardar nuevo cliente
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'email' => 'required|email|unique:cliente,email',
            'telefono' => 'nullable|max:20',
            'direccion' => 'nullable|string',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente creado correctamente');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('privado.clientes_editar', compact('cliente'));
    }

    // Actualizar cliente
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'nombre' => 'required|max:100',
            'email' => 'required|email|unique:cliente,email,' . $cliente->id_cliente,
            'telefono' => 'nullable|max:20',
            'direccion' => 'nullable|string',
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente');
    }

    // Eliminar cliente
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente');
    }
}
