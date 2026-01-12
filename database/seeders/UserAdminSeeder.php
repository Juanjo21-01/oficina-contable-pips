<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asignar el rol de administrador al usuario principal
        $rolAdmin = Role::where('nombre', 'administrador')->first();

        // Crear usuario administrador
        User::create([
            'nombres' => env('ADMIN_NOMBRES'),
            'apellidos' => env('ADMIN_APELLIDOS'),
            'email' => env('ADMIN_EMAIL'),
            'password' => bcrypt(env('ADMIN_PASSWORD')),
            'role_id' => $rolAdmin->id,
        ]);
    }
}
