<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\TipoCliente;
use App\Models\AgenciaVirtual;

class Formulario extends Component
{
    // Datos personales
    public $nombres, $apellidos, $dpi, $nit, $direccion, $telefono, $email, $tipoClienteId;

    // Agencia virtual (opcional)
    public $correo, $contrasenia, $observaciones;

    // Preferencias
    public $estado = true;

    public $errorMessage;

    public function guardar()
    {
        $rules = [
            'nombres'       => 'required|string|max:50',
            'apellidos'     => 'required|string|max:50',
            'dpi'           => 'required|string|max:13|unique:clientes,dpi',
            'nit'           => 'required|string|max:13|unique:clientes,nit',
            'direccion'     => 'required|string|max:255',
            'telefono'      => 'required|string|max:8',
            'email'         => 'nullable|email|max:100|unique:clientes,email',
            'tipoClienteId' => 'required|int|exists:tipo_clientes,id',
        ];

        if ($this->correo) {
            $rules['correo']        = 'required|string|email|max:100|unique:agencia_virtual,correo';
            $rules['contrasenia']   = 'required|string|min:8|max:255';
            $rules['observaciones'] = 'nullable|string|max:255';
        }

        $this->validate($rules);

        try {
            $cliente = Cliente::create([
                'nombres'         => $this->nombres,
                'apellidos'       => $this->apellidos,
                'dpi'             => $this->dpi,
                'nit'             => $this->nit,
                'direccion'       => $this->direccion,
                'telefono'        => $this->telefono,
                'email'           => $this->email,
                'tipo_cliente_id' => $this->tipoClienteId,
                'estado'          => $this->estado,
                'user_id'         => auth()->user()->id,
            ]);

            if ($this->correo) {
                AgenciaVirtual::create([
                    'cliente_id'    => $cliente->id,
                    'correo'        => $this->correo,
                    'password'      => $this->contrasenia,
                    'observaciones' => $this->observaciones,
                ]);
            }

            $this->dispatch('clienteGuardado');
            $this->dispatch('toast', type: 'success', message: '¡Cliente guardado!');

            return redirect()->route('clientes.index');
        } catch (\Exception $e) {
            $this->errorMessage = 'Error al guardar el cliente: ' . $e->getMessage();
            $this->dispatch('toast', type: 'error', message: $this->errorMessage);
        }
    }

    public function clearError($field)
    {
        $this->resetErrorBag($field);
    }

    public function render()
    {
        return view('livewire.clientes.formulario', [
            'tipoClientes' => TipoCliente::all(),
        ]);
    }
}
