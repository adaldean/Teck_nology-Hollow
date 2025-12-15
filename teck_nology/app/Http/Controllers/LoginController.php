<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UsuarioSistema;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('privado/login'); 
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $role = $request->input('role', 'empleado');

        if ($role === 'cliente') {
            // Login para clientes: no usan el mismo guard que los empleados.
            $cliente = Cliente::where('email', $request->email)->first();
            if ($cliente) {
                // Soportar contraseñas hasheadas y también plain (fallback) por compatibilidad.
                $stored = $cliente->contrasena ?? '';
                $hashInfo = password_get_info($stored);
                $checked = false;
                if (!empty($stored) && isset($hashInfo['algo']) && $hashInfo['algo'] !== 0) {
                    // Es un hash válido según password_get_info
                    $checked = Hash::check($request->password, $stored);
                }

                if ($checked || $stored === $request->password) {
                    // Guardar cliente en sesión (no usar Auth para no dar acceso a panel de empleados)
                    session(['cliente_id' => $cliente->id_cliente, 'cliente_nombre' => $cliente->nombre]);
                    return redirect('/')->with('success', 'Ingreso como cliente exitoso');
                }
            }
            return back()->withErrors(['email' => 'Credenciales de cliente inválidas.'])->onlyInput('email');
        }

        // Login para empleados/usuarios del sistema
        $user = UsuarioSistema::where('email', $request->email)->first();
        if ($user) {
            // Soportar hash y plain (compatibilidad)
            $stored = $user->contrasena ?? '';
            $hashInfo = password_get_info($stored);
            $checked = false;
            if (!empty($stored) && isset($hashInfo['algo']) && $hashInfo['algo'] !== 0) {
                $checked = Hash::check($request->password, $stored);
            }

            if ($checked || $stored === $request->password) {
                Auth::login($user);
                return redirect('/privado/home')->with('success', 'Login exitoso');
            }
        }

        return back()->withErrors(['email' => 'Credenciales inválidas.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }  

    public function showRegistroForm()
    {
        return view('privado.registro'); 
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:cliente,email',
            'telefono' => 'nullable|max:20',
            'direccion' => 'nullable|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'contrasena' => Hash::make($request->password),
        ]);

        // Iniciar sesión de cliente mediante sesión simple (no Auth guard)
        session(['cliente_id' => $cliente->id_cliente, 'cliente_nombre' => $cliente->nombre]);

        return redirect('/')->with('success', 'Cuenta creada. Bienvenido ' . $cliente->nombre);
    }

    // Logout para clientes: elimina claves de sesión específicas
    public function logoutCliente(Request $request)
    {
        $request->session()->forget(['cliente_id', 'cliente_nombre']);
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Sesión de cliente cerrada correctamente');
    }

    // Dev helper: crear un cliente de prueba (no requiere CSRF). Quitar en producción.
    public function seedDevClient()
    {
        $email = 'cliente_dev@example.com';
        $password = 'devpass123';

        $cliente = Cliente::where('email', $email)->first();
        if (!$cliente) {
            $cliente = Cliente::create([
                'nombre' => 'Cliente Dev',
                'email' => $email,
                'telefono' => '000000000',
                'direccion' => 'Calle Dev',
                'contrasena' => Hash::make($password),
            ]);
            return response()->json(['ok' => true, 'message' => 'Cliente creado', 'email' => $email, 'password' => $password]);
        }
        return response()->json(['ok' => true, 'message' => 'Cliente ya existente', 'email' => $email]);
    }

    // Dev helper: loguea (setea session) como el cliente dev creado por seedDevClient
    public function devLogin(Request $request)
    {
        $email = 'cliente_dev@example.com';
        $cliente = Cliente::where('email', $email)->first();
        if (!$cliente) {
            return redirect('/')->with('error', 'Cliente dev no encontrado. Genera seed primero en /dev/registro/seed');
        }

        session(['cliente_id' => $cliente->id_cliente, 'cliente_nombre' => $cliente->nombre]);
        return redirect('/')->with('success', 'Dev cliente logueado: ' . $cliente->email);
    }

}
