<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UsuarioSistema; 

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('privado.login'); // Retorna la vista 'login.blade.php'
    }

    public function login(Request $request)
    {
        // Validar datos
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Buscar usuario por email
        $user = UsuarioSistema::where('email', $request->email)->first();

        // Comparar contraseña directamente (texto plano)
        if ($user && $user->contrasena === $request->password) {
            Auth::login($user);
            return redirect('/privado/inventario')->with('success', 'Login exitoso');
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
}
