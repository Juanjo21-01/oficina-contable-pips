<?php

namespace App\Livewire\Bitacora;

use Livewire\Component;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;

class Detalle extends Component
{
    // Variables
    public $bitacora, $bitacoraId;

    // Constructor
    public function mount($id)
    {
        // Solo los administradores pueden acceder
        if (Auth::user()->role->nombre != 'Administrador') {
            abort(403);
        }

        $this->bitacoraId = $id;
        $this->bitacora = Bitacora::find($id);
    }

    public function render()
    {
        $this->bitacora = Bitacora::find($this->bitacoraId);
        return view('livewire.bitacora.detalle', [
            'bitacora' => $this->bitacora
        ]);
    }
}
