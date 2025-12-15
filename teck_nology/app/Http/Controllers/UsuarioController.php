<?php

namespace App\Http\Controllers;
use App\Models\Rol;
use App\Models\Cliente;
use App\Models\UsuarioSistema;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
public function index(Request $request)
{
    $q = $request->query('q');
    $tipo = $request->query('tipo', 'usuarios'); 

    $usuarios = UsuarioSistema::with('rol')
        ->when($q, function ($query) use ($q) {
            $query->where('nombre', 'LIKE', "%{$q}%")
                  ->orWhere('email', 'LIKE', "%{$q}%")
                  ->orWhereHas('rol', function ($sub) use ($q) {
                      $sub->where('nombre', 'LIKE', "%{$q}%");
                  });
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

    return view('privado.usuarios', compact('usuarios', 'clientes', 'tipo'));
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
            'email' => 'required|email|unique:usuario_sistema,email',
            'contrasena' => 'required|min:6',
        ]);

        UsuarioSistema::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            // Almacenamos contraseña hasheada por seguridad
            'contrasena' => bcrypt($request->contrasena),
            'id_rol' => $request->input('id_rol', 1),
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado');
    }
 public function actualizarAjax(Request $request, $id){
 try {
        $usuario = UsuarioSistema::findOrFail($id);

        $rules = [
            'nombre' => 'required|max:255',
            // usar la tabla correcta 'usuario_sistema' (singular) en la regla unique
            'email' => 'required|email|unique:usuario_sistema,email,' . $usuario->id_usuario . ',id_usuario',
        ];

        // Validar contraseña solo si se proporciona
        if ($request->has('contrasena') && !empty($request->contrasena)) {
            $rules['contrasena'] = 'required|min:6';
        }

        $request->validate($rules);

        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        if ($request->has('id_rol')) {
            $usuario->id_rol = $request->id_rol;
        }
        if ($request->has('contrasena') && !empty($request->contrasena)) {
            $usuario->contrasena = bcrypt($request->contrasena);
        }

        $usuario->save();

        // Si la petición espera JSON (AJAX), devolvemos JSON, si no, redirigimos
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado correctamente',
                'usuario' => $usuario
            ]);
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');

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