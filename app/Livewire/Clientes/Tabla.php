<?php

namespace App\Livewire\Clientes;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Tabla extends Component
{
    use WithPagination, WithoutUrlPagination;

    // Variables
    public $clienteId, $password, $nombres, $apellidos;
    public $abrirModal = false;
    public $search = '', $estado = '';
    public $perPage = 5;

    // Eventos
    protected $listeners = ['clienteGuardado' => 'render', 'clienteEliminado' => 'render'];

    // Abrir modal
    public function modalEliminar($clienteId)
    {
        // Solo los administradores pueden eliminar clientes
        if (Auth::user()->role->nombre !== 'Administrador') {
            return toastr()->addError('¡No tienes permiso para eliminar clientes!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
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
                toastr()->addWarning('¡El cliente tiene una agencia virtual asociada!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
                ]);
                return;
            }

            // Verificar si el cliente tiene tramites
            if ($cliente->tramites->count() > 0) {
                toastr()->addWarning('¡El cliente tiene trámites asociados!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
                ]);
                return;
            }

            // Eliminar cliente
            $cliente->delete();

            // Cerrar modal
            $this->abrirModal = false;
            $this->dispatch('clienteEliminado');

            // Mostrar mensaje
            toastr()->addSuccess('Cliente eliminado.', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
       } catch (\Exception $e) {
            $this->addError('password', 'Error al eliminar el cliente.'.$e->getMessage());
            toastr()->addError('¡Error al eliminar el cliente!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
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

        // Mostrar mensaje
        toastr()->addSuccess('Estado actualizado.', [
            'positionClass' => 'toast-bottom-right',
            'closeButton' => true,
        ]);
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

    public function render()
    {
        $query = Cliente::query();
        // Filtrar por nombre o apellido, correo, nit o dpi
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nombres', 'like', '%' . $this->search . '%')
                ->orWhere('apellidos', 'like', '%' . $this->search . '%');
            });
        }

        // Filtrar por estado
        if ($this->estado !== '') {
            $query->where('estado', $this->estado);
        }

        // Ordenar de manera descendente
        $query->orderBy('created_at', 'desc');

        // Obtener los clientes paginados
        $clientes = $query->paginate($this->perPage);

        return view('livewire.clientes.tabla', [
            'clientes' => $clientes]);
    }
}
