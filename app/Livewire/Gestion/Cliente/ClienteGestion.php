<?php

namespace App\Livewire\Gestion\Cliente;

use App\Models\Clientes\Clientes\Cliente;
use App\Models\Gestion\Asignacion;
use Illuminate\Support\Facades\Auth;
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
    public $is_papeles=false;
    public $bitacoras=[];

    public function mount($id){

        $this->actual=Cliente::find($id);
        $rol=Auth::user()->rol_id;
        $userid=Auth::user()->id;
        $permi=Asignacion::where('cliente_id',$id)
                            ->where('usuario_id',$userid)
                            ->count();

        if($rol===1){
            $this->is_asignado=true;
        }

        if($permi>0){
            $this->is_asignado=true;
        }
    }

    #[On('volviendo')]
    public function volver(){
        $this->reset(
            'is_gestion',
            'is_programacion',
            'is_soporte',
            'is_bitacora',
            'is_papeles',
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

    public function papelestrabajo(){
        $this->volver();
        $this->is_papeles=true;
    }

    public function programacion(){
        $this->volver();
        $this->is_programacion=true;
    }

    public function gestion(){
        $this->volver();
        $this->is_gestion=true;
    }

    public function render()
    {
        return view('livewire.gestion.cliente.cliente-gestion');
    }
}
