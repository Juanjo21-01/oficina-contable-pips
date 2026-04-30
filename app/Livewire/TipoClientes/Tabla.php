<?php

namespace App\Livewire\TipoClientes;

use Livewire\Component;
use App\Models\TipoCliente;

class Tabla extends Component
{
    public $search = '';

    public function render()
    {
        $tipoClientes = TipoCliente::when($this->search, fn ($q) =>
            $q->where('nombre', 'like', '%' . $this->search . '%')
        )->get();

        return view('livewire.tipo-clientes.tabla', compact('tipoClientes'));
    }
}
