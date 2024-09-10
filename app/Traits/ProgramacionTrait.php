<?php

namespace App\Traits;

use App\Models\Clientes\Clientes\Cliente;
use App\Models\Configuracion\Parametro;
use App\Models\Gestion\Programacion;
use Livewire\WithPagination;
use App\Traits\EdicionTrait;
use App\Traits\FiltroTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

trait ProgramacionTrait
{
    use WithPagination;
    use FiltroTrait;
    use EdicionTrait;

    public $is_modify=true;
    public $is_editing=false;
    public $is_inactivar=false;
    public $elegido;
    public $prele=false;
    public $id;

    public $buscar=null;
    public $buscaregistro;

    public $name;
    public $inicio;
    public $fin;
    public $observaciones;
    public $cliente_id;
    public $parametro_id;
    public $nameinac;
    public $statusinac;

    public $filtroInides;
    public $filtroInihas;
    public $filtroinicia=[];
    public $filtrocliente;
    public $filtroparametro;

    public $ordena='inicio';
    public $ordenado='ASC';
    public $pages = 15;

    public function mount($cli=null){
        if($cli){
            $this->id=$cli;
            $this->prele=true;
            $this->preseleccionado();
        }
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
                'is_modify',
                'is_editing',
                'is_inactivar',
                'buscar',
                'buscaregistro',
                'ordena',
                'ordenado',
                'pages',
                'elegido',
                'name',
                'inicio',
                'fin',
                'observaciones',
                'cliente_id',
                'parametro_id',
                'filtroInides',
                'filtroInihas',
                'filtroinicia',
                'filtrocliente',
                'filtroparametro',
            );

        if($this->prele){
            $this->preseleccionado();
        }
    }

    public function limpia(){
        $this->reset(
            'is_modify',
            'is_editing',
            'is_inactivar',
            'name',
            'inicio',
            'fin',
            'observaciones',
            'cliente_id',
            'parametro_id',
        );
        $this->preseleccionado();
    }

    public function preseleccionado(){
        $this->filtrocliente=$this->id;
        $this->cliente_id=$this->id;
    }

    /**
     * Reglas de validación
     */
    protected function rules(){

        return [
            'name'                  =>'required',
            'inicio'                =>'required',
            'fin'                   =>'required',
            'observaciones'         =>'required',
            'cliente_id'            =>'required',
            'parametro_id'          =>'required',

        ];

    }

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'name',
            'inicio',
            'fin',
            'observaciones',
            'cliente_id',
            'parametro_id',
        );
    }

    public function updatedFiltroInihas(){
        if($this->filtroInides<=$this->filtroInihas){
            $crea=array();
            array_push($crea, $this->filtroInides);
            array_push($crea, $this->filtroInihas);
            $this->filtroinicia=$crea;
        }else{
            $this->dispatch('alerta', name:'Fecha de inicio debe ser menor a fecha fin');
        }
    }

    // Crear
    public function creando(){
        $this->is_editing=true;
        $this->is_modify=false;

        $this->generar(7);
    }

    public function show($item, $accion){

        $this->is_modify=false;
        $this->elegido=Programacion::find($item);

        switch ($accion) {

            case 0:
                $this->is_editing=true;
                $this->modificar(5);
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
        }

    }

    public function cargavalores(){
        $this->name=$this->elegido->name;
        $this->inicio=$this->elegido->inicio;
        $this->fin=$this->elegido->fin;
        $this->cliente_id=$this->elegido->cliente_id;
        $this->parametro_id=$this->elegido->parametro_id;
    }

    public function crear(){

        // validate
        $this->validate();

        $bitacora=now()." ".strtolower(Auth::user()->name).": Creo la actividad con estas observaciones: ";

        Programacion::create([
                        'name'          => $this->name,
                        'inicio'        => $this->inicio,
                        'fin'           => $this->fin,
                        'observaciones' => $bitacora.$this->observaciones." ----- ",
                        'cliente_id'    => $this->cliente_id,
                        'parametro_id'  => $this->parametro_id,
                    ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente la actividad: '.$this->name);
        $this->resetFields();

        //refresh
        if($this->prele){
            $this->limpia();
        }else{
            $this->dispatch('cancelando');
        }
    }

    public function inactivar(){

        Programacion::where('id',$this->elegido->id)
                ->update([
                    'status'    =>!$this->statusinac,
                ]);

        $this->dispatch('alerta', name:'Se modifico el estado de la actividad: '.$this->nameinac);
        //refresh
        if($this->prele){
            $this->limpia();
        }else{
            $this->dispatch('cancelando');
        }
    }

    //Editar
    public function editar(){
        // validate
        $this->validate();

        $bitacora=now()." ".strtolower(Auth::user()->name).": Actualizo la actividad con: ";

        $programa=Programacion::find($this->elegido->id);
        $programa->update([
                    'name'          => $this->name,
                    'inicio'        => $this->inicio,
                    'fin'           => $this->fin,
                    'observaciones' => $bitacora.$this->observaciones." ----- ".$this->elegido->observaciones,
                    'cliente_id'    => $this->cliente_id,
                    'parametro_id'  => $this->parametro_id,
                ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente la actividad: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        //refresh
        if($this->prele){
            $this->limpia();
        }else{
            $this->dispatch('cancelando');
        }
    }

    private function programas(){
        return Programacion::buscar($this->buscaregistro)
                            ->inicia($this->filtroinicia)
                            ->cliente($this->filtrocliente)
                            ->parametro($this->filtroparametro)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);
    }

    private function clientes(){

        return Cliente::where('status',true)
                        ->select('id','name')
                        ->orderBy('name','ASC')
                        ->get();

    }

    private function parametros(){
        return Parametro::where('status', true)
                            ->where('tipo', '>',1)
                            ->orderBy('name','ASC')
                            ->get();
    }

}
