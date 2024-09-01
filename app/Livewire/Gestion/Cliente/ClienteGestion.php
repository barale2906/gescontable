<?php

namespace App\Livewire\Gestion\Cliente;

use App\Models\Clientes\Clientes\Cliente;
use Livewire\Attributes\On;
use Livewire\Component;

class ClienteGestion extends Component
{
    public $actual;
    public $is_gestion=false;
    public $is_programacion=false;
    public $is_soporte=false;
    public $is_bitacora=false;
    public $is_asignado=false;
    public $bitacoras=[];

    public function mount($id){

        $this->actual=Cliente::find($id);
        $this->is_asignado=true;

    }

    #[On('volviendo')]
    public function volver(){
        $this->reset(
            'is_gestion',
            'is_programacion',
            'is_soporte',
            'is_bitacora',
            'bitacoras'
        );
    }

    public function activbitacoras(){

        $this->volver();

        $bitacora=$this->actual->bitacora;
        $cambios=explode("-----",$bitacora);

        foreach ($cambios as $value) {
            array_push($this->bitacoras,$value);
        }

        $this->is_bitacora=true;
    }

    public function cargasoporte(){
        $this->volver();
        $this->is_soporte=true;
    }

    public function render()
    {
        return view('livewire.gestion.cliente.cliente-gestion');
    }
}
