<?php

namespace App\Livewire\Usuarios;

use Livewire\Component;

class Modal extends Component
{
    // Variables
    public $show = false;
    public $usuarioId = null;

    // Eventos
    protected $listeners = ['crearUsuario', 'editarUsuario', 'cerrarModal'];

    // Abrir modal para crear
    public function crearUsuario()
    {
        $this->limpiarModal();
        $this->show = true;
    }

    // Abrir modal para editar
    public function editarUsuario($usuarioId)
    {
        $this->usuarioId = $usuarioId;
        $this->show = true;

        $this->dispatch('cargarUsuario', $usuarioId);
    }

    // Cerrar modal
    public function cerrarModal()
    {
        $this->show = false;
    }

    // Limpiar modal
    public function limpiarModal()
    {
        $this->usuarioId = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.usuarios.modal');
    }
}
