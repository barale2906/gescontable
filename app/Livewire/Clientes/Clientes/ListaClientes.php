<?php

namespace App\Livewire\Clientes\Clientes;

use App\Traits\ClienteTrait;
use Livewire\Component;

class ListaClientes extends Component
{
    use ClienteTrait;

    public function render()
    {
        return view('livewire.clientes.clientes.lista-clientes',[
            'clientes'  =>$this->clientes(),
            'usuarios'  =>$this->usuarios(),
        ]);
    }
}
