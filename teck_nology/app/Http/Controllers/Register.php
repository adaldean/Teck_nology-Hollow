<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UsuarioSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // Muestra el formulario de registro. La vista se define en la sección 4.
    public function showRegistrationForm()
    {
        return view('users.register');
    }

    // Procesa el formulario de registro.
    public function register(Request $request)
    {
        $data = $request->all();

        // Reglas de validación
        Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:usuario_sistema,email'], // Verifica unicidad en tu tabla
            'phone' => ['nullable', 'string', 'max:15'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();

        // Crea el nuevo usuario
        UsuarioSistema::create([
            'nombre' => $data['name'],
            'email' => $data['email'],
            // La contraseña SIEMPRE debe guardarse hasheada
            'contrasena' => Hash::make($data['password']),
            'id_rol' => 3, // Asigna el rol por defecto (ej. Vendedor)
        ]);

        // Opcional: Inicia sesión después del registro
        // Auth::login($user); 

        return redirect()->route('login.show')->with('status', '¡Cuenta creada con éxito! Por favor, inicia sesión.');
    }
}