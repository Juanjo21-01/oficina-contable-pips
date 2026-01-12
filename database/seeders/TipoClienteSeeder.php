<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TipoCliente;

class TipoClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear tipos de clientes
        TipoCliente::create(['nombre' => 'Persona Normal']);
        TipoCliente::create(['nombre' => 'Empresa']);
    }
}
