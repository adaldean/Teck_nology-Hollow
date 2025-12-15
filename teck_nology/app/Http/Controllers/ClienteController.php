<?php

namespace App\Http\Controllers;
use App\Models\Cliente;
use App\Models\UsuarioSistema;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
public function index(Request $request)
{
    // Return the full admin view that contains both empleados and clientes tables
    $q = $request->query('q');

    $usuarios = UsuarioSistema::with('rol')
        ->when($q, function ($query) use ($q) {
            $query->where('nombre', 'LIKE', "%{$q}%")
                  ->orWhere('email', 'LIKE', "%{$q}%");
        })
        ->orderBy('id_usuario', 'asc')
        ->paginate(10);

    $clientes = Cliente::when($q, function ($query) use ($q) {
            $query->where('nombre', 'LIKE', "%{$q}%")
                  ->orWhere('email', 'LIKE', "%{$q}%")
                  ->orWhere('telefono', 'LIKE', "%{$q}%")
                  ->orWhere('direccion', 'LIKE', "%{$q}%");
        })
        ->orderBy('id_cliente', 'asc')
        ->paginate(10);

    return view('privado.usuarios', compact('usuarios', 'clientes'));
}


    public function create()
    {
        return view('privado.clientes_crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'email' => 'required|email|unique:cliente,email',
            'telefono' => 'nullable|max:20',
            'direccion' => 'nullable|string',
        ]);

        $data = $request->only(['nombre','email','telefono','direccion']);
        if ($request->filled('contrasena')) {
            $data['contrasena'] = bcrypt($request->contrasena);
        }

        $cliente = Cliente::create($data);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cliente creado correctamente',
                'cliente' => $cliente
            ]);
        }

        return redirect()->route('clientes.index')->with('success', 'Cliente creado correctamente');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('privado.clientes_editar', compact('cliente'));
    }

    // Actualizar cliente
    public function actualizarAjax(Request $request, $id){
        try {
            $cliente = Cliente::findOrFail($id);

            $rules = [
                'nombre' => 'required|max:100',
                'email' => 'required|email|unique:cliente,email,' . $cliente->id_cliente . ',id_cliente',
                'telefono' => 'nullable|max:20',
                'direccion' => 'nullable|string',
            ];

            if ($request->has('contrasena') && !empty($request->contrasena)) {
                $rules['contrasena'] = 'required|min:6';
            }

            $request->validate($rules);

            $cliente->nombre = $request->nombre;
            $cliente->email = $request->email;
            $cliente->telefono = $request->telefono;
            $cliente->direccion = $request->direccion;
            if ($request->has('contrasena') && !empty($request->contrasena)) {
                $cliente->contrasena = bcrypt($request->contrasena);
            }

            $cliente->save();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cliente actualizado correctamente',
                    'cliente' => $cliente
                ]);
            }

            return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // Eliminar cliente
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente');
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
