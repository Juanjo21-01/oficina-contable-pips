<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\TipoCliente;

class Modal extends Component
{
    // Variables
    public $show = false;
    public $clienteId = null;
    public $errorMessage;
    public $nombres, $apellidos, $dpi, $nit, $direccion, $telefono, $email, $tipoClienteId;

    // Eventos
    protected $listeners = ['editarCliente'];

    // Abrir modal para editar
    public function editarCliente($clienteId)
    {
        $this->limpiarModal();

        $this->clienteId = $clienteId;
        $this->show = true;

        // Buscar cliente
        $cliente = Cliente::find($clienteId);

        // Asignar valores
        $this->clienteId = $cliente->id;
        $this->nombres = $cliente->nombres;
        $this->apellidos = $cliente->apellidos;
        $this->dpi = $cliente->dpi;
        $this->nit = $cliente->nit;
        $this->direccion = $cliente->direccion;
        $this->telefono = $cliente->telefono;
        $this->email = $cliente->email;
        $this->tipoClienteId = $cliente->tipo_cliente_id;
    }

    // Actualizar cliente
    public function actualizar()
    {
        $this->validate([
            'nombres' => 'required|string|max:50',
            'apellidos' => 'required|string|max:50',
            'dpi' => 'required|string|max:13|unique:clientes,dpi,' . $this->clienteId,
            'nit' => 'required|string|max:13|unique:clientes,nit,' . $this->clienteId,
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:8',
            'email' => 'nullable|email|max:100|unique:clientes,email,' . $this->clienteId,
            'tipoClienteId' => 'required|int|exists:tipo_clientes,id'
        ]);
        
        try{
            // Actualizar cliente
            $cliente = Cliente::find($this->clienteId);

            $cliente->nombres = $this->nombres;
            $cliente->apellidos = $this->apellidos;
            $cliente->dpi = $this->dpi;
            $cliente->nit = $this->nit;
            $cliente->direccion = $this->direccion;
            $cliente->telefono = $this->telefono;
            $cliente->email = $this->email;
            $cliente->tipo_cliente_id = $this->tipoClienteId;

            $cliente->save();

            // Emitir evento
            $this->dispatch('clienteGuardado');

            // Mostrar mensaje
            toastr()->addInfo('Cliente actualizado!', [
                    'positionClass' => 'toast-bottom-right',
                    'closeButton' => true,
                ]);

            // Cerrar modal
            $this->show = false;
        }
        catch(\Exception $e){
            $this->errorMessage = 'Error al guardar el cliente: '.$e->getMessage();

            // Mostrar mensaje
            toastr()->addError($this->errorMessage, [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);
        }
    }

    // Cerrar modal
    public function cerrarModal()
    {
        $this->show = false;
    }

    // Limpiar modal
    public function limpiarModal()
    {
        $this->clienteId = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    // Limpiar errores
    public function clearError($field)
    {
        $this->resetErrorBag($field);
    }

    public function render()
    {
        $tipoClientes = TipoCliente::all();
        return view('livewire.clientes.modal', [
            'tipoClientes' => $tipoClientes
        ]);
    }
}
