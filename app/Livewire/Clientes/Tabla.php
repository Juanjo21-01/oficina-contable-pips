<?php

namespace App\Livewire\Clientes;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Cliente;
use App\Models\TipoCliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Tabla extends Component
{
    use WithPagination, WithoutUrlPagination;

    // Variables
    public $clienteId, $password, $nombres, $apellidos;
    public $abrirModal = false;
    public $search = '', $estado = '', $tipoClienteId = '';
    public $perPage = 5;

    // Eventos
    protected $listeners = ['clienteGuardado' => 'render', 'clienteEliminado' => 'render'];

    // Abrir modal
    public function modalEliminar($clienteId)
    {
        // Solo los administradores pueden eliminar clientes
        if (Auth::user()->role->nombre !== 'Administrador') {
            $this->dispatch('toast', type: 'error', message: '¡No tienes permiso para eliminar clientes!');
            return;
        }

        $this->password = '';
        $this->clearError('password');

        // Buscar cliente
        $cliente = Cliente::find($clienteId);

        // Asignar valores
        $this->nombres = $cliente->nombres;
        $this->apellidos = $cliente->apellidos;

        $this->clienteId = $clienteId;
        $this->abrirModal = true;
    }

    // Cerrar modal
    public function cerrarModal()
    {
        $this->abrirModal = false;
        $this->reset('clienteId');
    }

    // Editar
    public function editar($clienteId)
    {
        $this->dispatch('editarCliente', $clienteId);
    }

    // Eliminar
    public function eliminar()
    {
        try {
            // Validar contraseña
            if (!Hash::check($this->password, Auth::user()->password)) {
                $this->addError('password', 'La contraseña es incorrecta.');
                return;
            }

            // Buscar cliente
            $cliente = Cliente::find($this->clienteId);

            // Verificar si el cliente tiene agencia virtual
            if ($cliente->agenciaVirtual) {
                $this->dispatch('toast', type: 'warning', message: '¡El cliente tiene una agencia virtual asociada!');
                return;
            }

            // Verificar si el cliente tiene tramites
            if ($cliente->tramites->count() > 0) {
                $this->dispatch('toast', type: 'warning', message: '¡El cliente tiene trámites asociados!');
                return;
            }

            // Eliminar cliente
            $cliente->delete();

            // Cerrar modal
            $this->abrirModal = false;
            $this->dispatch('clienteEliminado');

            $this->dispatch('toast', type: 'success', message: 'Cliente eliminado correctamente.');
       } catch (\Exception $e) {
            $this->addError('password', 'Error al eliminar el cliente.' . $e->getMessage());
            $this->dispatch('toast', type: 'error', message: '¡Error al eliminar el cliente!');
       }
    }

    // Limpiar errores
    public function clearError($field)
    {
        $this->resetErrorBag($field);
    }

    // Cambiar estado
    public function cambiarEstado($clienteId)
    {
        // Buscar cliente
        $cliente = Cliente::find($clienteId);

        // Cambiar estado
        $cliente->estado = !$cliente->estado;
        $cliente->save();

        $this->dispatch('toast', type: 'success', message: 'Estado actualizado.');
    }

    // Resetear paginación al buscar
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingEstado()
    {
        $this->resetPage();
    }

    public function updatingTipoClienteId()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Cliente::query()->with('tipoCliente');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nombres', 'like', '%' . $this->search . '%')
                  ->orWhere('apellidos', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->estado !== '') {
            $query->where('estado', $this->estado);
        }

        if ($this->tipoClienteId !== '') {
            $query->where('tipo_cliente_id', $this->tipoClienteId);
        }

        $query->orderBy('created_at', 'desc');

        $clientes = $query->paginate($this->perPage);

        return view('livewire.clientes.tabla', [
            'clientes'     => $clientes,
            'tipoClientes' => TipoCliente::all(),
        ]);
    }
}
