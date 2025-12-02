<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UsuarioSistema; 

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


        $user = UsuarioSistema::where('email', $request->email)->first();
        if ($user && $user->contrasena === $request->password) {
            Auth::login($user);
            return redirect('/privado/home')->with('success', 'Login exitoso');
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
        return view('privado/registro'); 
    }

}
