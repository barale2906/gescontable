<?php

namespace App\Livewire\Configuracion\Rols;

use App\Traits\EdicionTrait;
use Livewire\Component;
use App\Traits\RolesTrait;

class Roles extends Component
{
    use RolesTrait;
    use EdicionTrait;

    public function render()
    {
        return view('livewire.configuracion.rols.roles',[
            'roles'         =>$this->roles(),
            'permisos'      =>$this->permisos(),
            'encabezados'   =>$this->encabezados(),
        ]);
    }
}
