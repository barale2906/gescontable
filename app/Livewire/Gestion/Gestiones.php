<?php

namespace App\Livewire\Gestion;

use App\Models\Gestion\Gestion;
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
    public $id;
    public $name;
    public $observaciones;
    public $nameinac;
    public $statusinac;
    public $elegido;

    public $buscar=null;
    public $buscaregistro;

    public $ordena='id';
    public $ordenado='DESC';
    public $pages = 15;


    public function mount($id){
        $this->id=$id;
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
                'observaciones',
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
            'name'                  => 'required',
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
            'observaciones'
        );
    }

    // Crear
    public function creando(){
        $this->is_editing=true;
        $this->is_modify=false;

        $this->generar(5);
    }

    public function crear(){

        // validate
        $this->validate();

        $bitacora=now()." ".strtolower(Auth::user()->name).": Creo la gestión: ";


        Gestion::create([
                            'name'          =>$this->name,
                            'observaciones' =>$bitacora.$this->observaciones.' ----- ',
                        ]);



        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente la gestión: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('cancelando');
    }

    public function show($item, $accion){

        $this->is_modify=false;
        $this->elegido=Gestion::find($item);

        switch ($accion) {

            case 0:
                $this->is_editing=true;
                $this->modificar(3);
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
        $this->observaciones=$this->observaciones;
    }

    //Editar
    public function editar(){
        // validate
        $this->validate();

        $bitacora=now()." ".strtolower(Auth::user()->name).": Actualizo la gestión: ";

        $gestion=Gestion::find($this->elegido->id);
        $gestion->update([
            'name'=>strtolower($this->name),
            'observaciones'=>$bitacora.strtolower($this->observaciones).' ----- '.$this->elegido->observaciones,
        ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente la gestión: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    public function inactivar(){

        Gestion::where('id',$this->elegido->id)
                ->update([
                    'status'    =>!$this->statusinac,
                ]);

        $this->dispatch('alerta', name:'Se modifico el estado de la gestión: '.$this->nameinac);
        $this->volver();
    }

    private function registros(){
        return Gestion::buscar($this->buscaregistro)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.gestion.gestiones',[
            'registros' =>$this->registros(),
        ]);
    }
}
