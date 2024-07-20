<?php

namespace App\Livewire\Configuracion\Rols;

use Livewire\Component;
use App\Traits\RolesTrait;

class Roles extends Component
{
    use RolesTrait;

    public function render()
    {
        return view('livewire.configuracion.rols.roles',[
            'roles'         =>$this->roles(),
            'permisos'      =>$this->permisos(),
            'encabezados'   =>$this->encabezados(),
            'usuarios'      =>$this->usuarios(),
        ]);
    }
}
