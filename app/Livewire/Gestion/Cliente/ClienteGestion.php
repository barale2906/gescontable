<?php

namespace App\Livewire\Gestion\Cliente;

use App\Models\Clientes\Clientes\Cliente;
use Livewire\Component;

class ClienteGestion extends Component
{
    public $actual;

    public function mount($id){

        $this->actual=Cliente::find($id);

    }

    public function render()
    {
        return view('livewire.gestion.cliente.cliente-gestion');
    }
}
