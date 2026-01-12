<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Roles
        $this->call(RoleSeeder::class);

        // Usuarios
        $this->call(UserAdminSeeder::class);

        // Tipos de clientes
        $this->call(TipoClienteSeeder::class);
    }
}
