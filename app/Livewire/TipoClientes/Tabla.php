<?php

namespace App\Livewire\TipoClientes;

use Livewire\Component;
use App\Models\TipoCliente;

class Tabla extends Component
{
    // Variables
    public $tipoClientes;

    // Constructor
    public function mount()
    {
        $this->tipoClientes = TipoCliente::all();
    }

    public function render()
    {
        return view('livewire.tipo-clientes.tabla', [
            'tipoClientes' => $this->tipoClientes
        ]);
    }
}
