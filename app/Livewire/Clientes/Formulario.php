<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\TipoCliente;
use App\Models\AgenciaVirtual;

class Formulario extends Component
{
    // Variables
    public $nombres, $apellidos, $dpi, $nit, $direccion, $telefono, $email, $tipoClienteId;
    public $clienteId = null;
    public $abrirModalAgencia = false, $mostrarFormularioAgencia = false;
    public $correo, $contrasenia, $observaciones;
    public $errorMessage;


    // Eventos
    protected $listeners = ['cargarCliente'];

    // Constructor
    public function mount($clienteId = null)
    {
        if ($clienteId) {
            $this->cargarCliente($clienteId);
        }
    }

    // Guardar
    public function guardar()
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
            // Crear cliente
            $cliente = Cliente::create([
                'nombres' => $this->nombres,
                'apellidos' => $this->apellidos,
                'dpi' => $this->dpi,
                'nit' => $this->nit,
                'direccion' => $this->direccion,
                'telefono' => $this->telefono,
                'email' => $this->email,
                'tipo_cliente_id' => $this->tipoClienteId,
                'user_id' => auth()->user()->id
            ]);

            // Asignar id
            $this->clienteId = $cliente->id;

            // Emitir evento
            $this->dispatch('clienteGuardado');

            $this->abrirModalAgencia = false;

            // Mostrar mensaje
            toastr()->addSuccess('¡Cliente guardado!', [
                'positionClass' => 'toast-bottom-right',
                'closeButton' => true,
            ]);

            // Regresar a la lista
            return redirect()->route('clientes.index');
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

    public function abrirAgencia()
    {
        // Validar
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

        $this->abrirModalAgencia = true;
    }

    public function agregarAgenciaVirtual()
    {
        // Validar
        $this->validate([
            'correo' => 'required|string|email|max:100|unique:agencia_virtual,correo',
            'contrasenia' => 'required|string|min:8|max:255',
            'observaciones' => 'nullable|string|max:255',
        ]);

        // Guardar el cliente antes de la agencia
        $this->guardar();

        AgenciaVirtual::create([
            'cliente_id' => $this->clienteId,
            'correo' => $this->correo,
            'password' => $this->contrasenia,
            'observaciones' => $this->observaciones,
        ]);

        $this->abrirModalAgencia = false;

        toastr()->addSuccess('¡Agencia Virtual creada!', [
            'positionClass' => 'toast-bottom-right',
            'closeButton' => true,
        ]);
    }

    public function cerrarModalAgencia()
    {
        $this->mostrarFormularioAgencia = false;
        $this->abrirModalAgencia = false;
    }

    public function abrirFormularioAgencia()
    {
        $this->mostrarFormularioAgencia = true;
    }

    // Limpiar errores
    public function clearError($field)
    {
        $this->resetErrorBag($field);
    }

    public function render()
    {
        $tipoClientes = TipoCliente::all();
        return view('livewire.clientes.formulario', [
            'tipoClientes' => $tipoClientes
        ]);
    }
}
