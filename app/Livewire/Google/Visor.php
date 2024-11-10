<?php

namespace App\Livewire\Google;

use App\Models\Gestion\Asignacion;
use App\Models\Gestion\Soporte;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;

class Visor extends Component
{
    #[Url(as: 'id')]
    public $regi = '';

    public $documento;
    public $is_ver=false;

    public function mount(){

        $this->documento=Soporte::find($this->regi);

        $usuario=Auth::user()->rol_id;
        if($usuario===1){
            $this->is_ver=true;
            $this->cargavisita();
        }else{
            $crt=Auth::user()->id;
            $esta=Asignacion::where('cliente_id',$this->documento->cliente_id)
                                ->where('usuario_id',$crt)
                                ->where('status',true)
                                ->count('id');

            if($esta>0){
                $this->is_ver=true;
                $this->cargavisita();
            }
        }

    }

    public function cargavisita(){
        $visita=now().": ".Auth::user()->name.", ingreso al documento. ----- ";
        $this->documento->update([
            'observaciones' =>$visita.$this->documento->observaciones,
        ]);
    }

    public function render()
    {
        return view('livewire.google.visor');
    }
}
