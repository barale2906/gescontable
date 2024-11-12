<?php

namespace App\Livewire\Gestion;

use App\Models\Gestion\Gestion;
use App\Models\Gestion\Programacion;
use App\Models\Gestion\Soporte;
use App\Traits\EdicionTrait;
use App\Traits\FiltroTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Gestiones extends Component
{
    use WithPagination;
    use FiltroTrait;
    use EdicionTrait;

    public $is_modify=true;
    public $is_editing=false;
    public $is_inactivar=false;
    public $is_programacion=false;
    public $is_soporte=false;
    public $sopor;
    public $progra;
    public $id;
    public $name;
    public $observaciones;
    public $programacion_id;
    public $soporte_id;
    public $nameinac;
    public $statusinac;
    public $elegido;
    public $avance;

    public $buscar=null;
    public $buscaregistro;

    public $ordena='id';
    public $ordenado='DESC';
    public $pages = 15;


    public function mount($id){
        $this->id=$id;
        $this->claseFiltro(5);
    }

    //Cargar variable
    public function buscaText(){
        $this->resetPage();
        $this->buscaregistro=strtolower($this->buscar);
    }

    // Ordenar Registros
    public function organizar($campo)
    {
        if($this->ordenado === 'ASC')
        {
            $this->ordenado = 'DESC';
        }else{
            $this->ordenado = 'ASC';
        }
        return $this->ordena = $campo;
    }

    //Numero de registros
    public function paginas($valor)
    {
        $this->resetPage();
        $this->pages=$valor;
    }

    //Activar evento
    #[On('cancelando')]
    //Mostrar formulario de inactivación
    public function volver()
    {
        $this->reset(
                'observaciones',
                'name',
                'nameinac',
                'statusinac',
                'elegido',
                'buscar',
                'buscaregistro',
                'ordena',
                'ordenado',
                'pages',
        );
    }

    /**
     * Reglas de validación
     */
    protected function rules(){

        return [
            'name'                  =>'required',
            'observaciones'         =>'required',
        ];

    }

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'name',
            'observaciones',
            'programacion_id',
            'soporte_id',
            'is_editing',
            'is_inactivar',
            'is_modify'
        );
    }

    // Crear
    public function creando(){
        $this->is_editing=true;
        $this->is_modify=false;
        $this->reset('elegido');

        $this->generar(8);
    }

    public function crear(){

        // validate
        $this->validate();

        $bitacora=now()." ".strtolower(Auth::user()->name).": Creo la gestión: ";


        Gestion::create([
                            'name'              =>$this->name,
                            'cliente_id'        =>$this->id,
                            'usuario_id'        =>Auth::user()->id,
                            'programacion_id'   =>$this->programacion_id,
                            'soporte_id'        =>$this->soporte_id,
                            'observaciones'     =>$bitacora.$this->observaciones.' ----- ',
                        ]);

        //Cerrar programación
        if($this->programacion_id>0 && $this->avance>1){
            $progra=Programacion::find($this->programacion_id);
            $reg=now()." ".strtolower(Auth::user()->name).": Cerro la programación con estas observaciones: ";
            //Actualiza estado
            Programacion::where('id',$this->programacion_id)
                        ->update([
                            'observaciones' =>$reg." ".$this->observaciones." ----- ".$progra->observaciones,
                            'status'        =>false
                        ]);
        }

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente la gestión: '.$this->name);
        $this->resetFields();

        //refresh
        //$this->dispatch('cancelando');
    }

    public function show($item, $accion){

        $this->is_modify=false;
        $this->elegido=Gestion::find($item);

        switch ($accion) {

            case 0:
                $this->is_editing=true;
                $this->modificar(6);
                $this->cargavalores();
                break;

            case 1:
                $this->is_inactivar=true;
                $this->nameinac=$this->elegido->name;
                if($this->elegido->status){
                    $this->statusinac=true;
                }else{
                    $this->statusinac=false;
                }
                break;

            case 2:
                $this->reset('sopor','progra','is_soporte','is_programacion','is_modify');
                $this->complementos();
                break;
        }

    }

    public function complementos(){
        if($this->elegido->soporte_id>0){
            $crt=$this->elegido->soporte_id;
            $this->sopor=Soporte::where('id',$crt)
                                    ->select('id','name','ruta')
                                    ->first();

            $this->is_soporte=true;
        }

        if($this->elegido->programacion_id>0){
            $trc=$this->elegido->programacion_id;
            $this->progra=Programacion::where('id',$trc)
                                        ->select('id','name','inicio','fin')
                                        ->first();

            $this->is_programacion=true;
        }
    }

    public function cargavalores(){
        $this->name=$this->elegido->name;
        //$this->observaciones=$this->elegido->observaciones;
        $this->programacion_id=$this->elegido->programacion_id;
        $this->soporte_id=$this->elegido->soporte_id;
    }

    //Editar
    public function editar(){
        // validate
        $this->validate();

        $bitacora=now()." ".strtolower(Auth::user()->name).": Actualizo la gestión: ";

        $gestion=Gestion::find($this->elegido->id);
        $gestion->update([
            'name'=>strtolower($this->name),
            'cliente_id'=>$this->id,
            'programacion_id'   =>$this->programacion_id,
            'soporte_id'        =>$this->soporte_id,
            'observaciones'=>$bitacora.strtolower($this->observaciones).' ----- '.$this->elegido->observaciones,
        ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente la gestión: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        //$this->dispatch('cancelando');
    }

    public function inactivar(){

        Gestion::where('id',$this->elegido->id)
                ->update([
                    'status'    =>!$this->statusinac,
                ]);

        $this->dispatch('alerta', name:'Se modifico el estado de la gestión: '.$this->nameinac);
        $this->resetFields();
    }

    private function registros(){
        return Gestion::where('cliente_id',$this->id)
                        ->buscar($this->buscaregistro)
                        ->orderBy('status','DESC')
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }

    private function soportes(){
        return Soporte::where('cliente_id',$this->id)
                        ->select('name','id')
                        ->orderBy('id','DESC')
                        ->get();
    }

    private function programaciones(){
        return Programacion::where('cliente_id',$this->id)
                            ->where('status',true)
                            ->select('name','id')
                            ->orderBy('id','DESC')
                            ->get();
    }

    public function render()
    {
        return view('livewire.gestion.gestiones',[
            'registros'         =>$this->registros(),
            'soportes'          =>$this->soportes(),
            'programaciones'    =>$this->programaciones()
        ]);
    }
}
