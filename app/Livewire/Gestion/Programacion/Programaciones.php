<?php

namespace App\Livewire\Gestion\Programacion;

use App\Traits\ProgramacionTrait;
use Livewire\Component;

class Programaciones extends Component
{
    use ProgramacionTrait;

    public function render()
    {
        return view('livewire.gestion.programacion.programaciones',[
            'programas' => $this->programas(),
        ]);
    }
}
