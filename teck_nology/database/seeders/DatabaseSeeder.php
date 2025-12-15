<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\UsuarioSistema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear roles base si no existen
        $roles = [
            'Administrador',
            'Gerente',
            'Vendedor',
            'Cajero',
            'Almacenista',
            'Supervisor',
            'Contable',
        ];

        foreach ($roles as $index => $nombre) {
            Rol::firstOrCreate(['id_rol' => $index + 1], ['nombre' => $nombre]);
        }

        // Crear un usuario administrador por defecto si no existe
        $adminEmail = 'd.admin@mail.com';
        $admin = UsuarioSistema::where('email', $adminEmail)->first();
        if (!$admin) {
            UsuarioSistema::create([
                'nombre' => 'David Admin',
                'email' => $adminEmail,
                // Guardamos la contraseña hasheada; LoginController acepta hash o plain
                'contrasena' => Hash::make('09876'),
                'id_rol' => 1,
            ]);
        }
    }
}
