<?php

namespace App\Livewire\Gestion\Programacion;

use App\Models\Gestion\Asignacion;
use App\Models\Gestion\Programacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Planeador extends Component
{
    public $filtrohasta;
    public $filtrodesde;
    public $filtrofin=[];
    public $dias=[];
    public $is_consulta=true;

    public $clientes=[];

    public function mount(){
        $this->obtempresas();
    }

    public function obtempresas(){

        if(Auth::user()->rol_id>1){

            $asigna=Asignacion::where('usuario_id',Auth::user()->id)->where('status',true)->select('cliente_id')->get();

            if($asigna->count()>0){
                foreach ($asigna as $value) {
                    array_push($this->clientes,$value->cliente_id);
                }
            }else{
                $this->is_consulta=false;
            }
        }
        $this->rango(2);
    }

    public function updatedFiltrodesde(){
        $this->rango(3);
    }

    public function rango($id){
        $this->reset('filtrofin','dias');

        if($id===2){
            $this->filtrodesde=Carbon::today();
            $hasta=Carbon::today();
            $this->filtrohasta=$hasta->addDays(7);
        }else{
            $this->filtrohasta=Carbon::create($this->filtrodesde)->addDays(7);
        }

        array_push($this->filtrofin,$this->filtrodesde);
        array_push($this->filtrofin,$this->filtrohasta);

        $crt=$this->filtrodesde;
        for ($i=0; $i < 8; $i++) {
            $dia = (clone $crt)->addDays($i);
            array_push($this->dias, $dia->format('Y-m-d'));
        }

    }



    private function programaciones(){

        return Programacion::empresas($this->clientes)
                            ->fin($this->filtrofin)
                            ->orderBy('name', 'ASC')
                            ->get();
    }

    public function render()
    {
        return view('livewire.gestion.programacion.planeador',[
            'programaciones'    =>$this->programaciones(),
        ]);
    }
}
