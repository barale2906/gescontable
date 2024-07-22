<?php

namespace App\Livewire\Configuracion\Parametro;

use App\Traits\ParametrosTrait;
use Livewire\Component;

class Parametros extends Component
{
    use ParametrosTrait;

    public function render()
    {
        return view('livewire.configuracion.parametro.parametros',[
            'params' =>$this->params()
        ]);
    }
}
