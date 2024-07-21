<?php

namespace App\Livewire\Configuracion\Usuario;

use App\Traits\UsersTrait;
use Livewire\Component;

class Usuarios extends Component
{
    use UsersTrait;

    protected $listeners = ['refresh' => '$refresh'];

    public function render()
    {
        return view('livewire.configuracion.usuario.usuarios',[
            'users' =>$this->users(),
        ]);
    }
}
