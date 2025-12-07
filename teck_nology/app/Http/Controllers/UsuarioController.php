<?php

namespace App\Http\Controllers;
use App\Models\Rol;
use App\Models\UsuarioSistema;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
public function index(Request $request)
{
    $q = $request->query('q');

    $usuarios = UsuarioSistema::with('rol')
        ->when($q, function ($query) use ($q) {
            $query->where('nombre', 'LIKE', "%{$q}%")
                  ->orWhere('email', 'LIKE', "%{$q}%")
                  ->orWhereHas('rol', function ($sub) use ($q) {
                      $sub->where('nombre', 'LIKE', "%{$q}%");
                  });
        })
        ->orderBy('id_usuario', 'asc')
        ->paginate(10)
        ->withQueryString();

    return view('privado.usuarios', compact('usuarios','clientes'));
}

    public function rol ()
    {
        $roles = Rol::all();
        return view('privado.usuarios', compact('roles'));
    }
    public function create()
    {
        return view('privado.usuarios_crear');
    }

    public function edit($id)
    {
        $usuario = UsuarioSistema::findOrFail($id);
        return view('privado.usuarios_editar', compact('usuario'));
    }

    public function destroy($id)
    {
        $usuario = UsuarioSistema::findOrFail($id);
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'email' => 'required|email|unique:usuario_sistemas,email',
            'contrasena' => 'required|min:6',
        ]);

        UsuarioSistema::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'contrasena' => $request->contrasena,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado');
    }

    public function update(Request $request, $id)
    {
        $usuario = UsuarioSistema::findOrFail($id);

        $request->validate([
            'nombre' => 'required|max:255',
            'email' => 'required|email|unique:usuario_sistemas,email,' . $usuario->id,
            'contrasena' => 'nullable|min:6',
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        if ($request->filled('contrasena')) {
            $usuario->contrasena = $request->contrasena;
        }
        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado');
    }

    public function listar()
{
    $usuarios = UsuarioSistema::paginate(10);
    return view('partials.tabla_usuario', compact('usuarios'));
}

public function buscar(Request $request)
{
    $query = $request->input('query');

    $usuarios = UsuarioSistema::where('nombre', 'LIKE', "%{$query}%")
        ->orWhere('email', 'LIKE', "%{$query}%")
        ->orWhere('rol', 'LIKE', "%{$query}%")
        ->paginate(10);

    return view('partials.tabla_usuario', compact('usuarios'));
}

}