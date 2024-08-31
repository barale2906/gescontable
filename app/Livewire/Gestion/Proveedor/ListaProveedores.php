<?php

namespace App\Livewire\Gestion\Proveedor;

use App\Traits\ProveedorTrait;
use Livewire\Component;

class ListaProveedores extends Component
{
    use ProveedorTrait;

    public function render()
    {
        return view('livewire.gestion.proveedor.lista-proveedores',[
            'proveedores'=>$this->proveedores(),
        ]);
    }
}
