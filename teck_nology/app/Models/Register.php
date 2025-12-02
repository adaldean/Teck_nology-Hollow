<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UsuarioSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    public function showRegistrationForm()
    {
        return view('users.register');
    }

    public function register(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'nombre' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:usuario_sistema,email'], // Verifica unicidad en tu tabla
            'phone' => ['nullable', 'string', 'max:15'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();

        UsuarioSistema::create([
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'telefono' => $data['phone'] ?? null,
            'contrasena' => Hash::make($data['password']),
        ]);

        return redirect()->route('login.show')->with('status', '¡Cuenta creada con éxito! Por favor, inicia sesión.');
    }
}