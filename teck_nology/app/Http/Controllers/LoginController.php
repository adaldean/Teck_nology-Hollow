<?php

namespace App\Http\Controllers; // <-- ¡ESTO ES CRUCIAL!

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UsuarioSistema; 

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('privado/login'); // Retorna la vista 'login.blade.php'
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = UsuarioSistema::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            return redirect()->intended('/privado/inventario');
        }

        return back()->withErrors(['email' => 'Credenciales inválidas.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }  
}