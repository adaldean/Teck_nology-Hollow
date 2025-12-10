<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
public function index()
{
    $clientes = Cliente::orderBy('id_cliente', 'desc')->paginate(10);
    return view('partials.tabla_clientes', compact('clientes'));
}


    public function create()
    {
        return view('privado.usuarios_crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'email' => 'required|email|unique:cliente,email',
            'telefono' => 'nullable|max:20',
            'direccion' => 'nullable|string',
        ]);

        Cliente::create($request->all());

        return redirect()->route('usuarios.index')->with('success', 'Cliente creado correctamente');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('privado.usuarios_editar', compact('cliente'));
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

        return redirect()->route('usuarios.index')->with('success', 'Cliente actualizado correctamente');
    }

    // Eliminar cliente
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('usuarios.index')->with('success', 'Cliente eliminado correctamente');
    }

    public function listar()
{
    $clientes = Cliente::paginate(10);
    return view('partials.tabla_clientes', compact('clientes'));
}

public function buscar(Request $request)
{
    $query = $request->input('query');

    $clientes = Cliente::where('nombre', 'LIKE', "%{$query}%")
        ->orWhere('email', 'LIKE', "%{$query}%")
        ->paginate(10);

    return view('partials.tabla_clientes', compact('clientes'));
}
}
