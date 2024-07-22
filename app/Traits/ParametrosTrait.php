<?php

namespace App\Traits;

use App\Models\Configuracion\Parametro as Variable;
use Livewire\WithPagination;
use App\Traits\EdicionTrait;
use App\Traits\FiltroTrait;
use Livewire\Attributes\On;

trait ParametrosTrait
{
    use WithPagination;
    use FiltroTrait;
    use EdicionTrait;

    public $is_modify=true;
    public $is_editing=false;
    public $is_inactivar=false;

    public $name;
    public $tipo;
    public $porcentaje;
    public $nameinac;
    public $statusinac;
    public $elegido;

    public $buscar=null;
    public $buscaregistro;

    public $ordena='name';
    public $ordenado='ASC';
    public $pages = 15;

    public function mount(){
        $this->claseFiltro(2);
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

        $this->params();

        $this->limpiar();
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name'  => 'required|max:100|unique:parametros.name',
        'tipo'  =>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'name',
            'tipo',
            'porcentaje'
        );
    }

    // Crear
    public function creando(){
        $this->is_editing=true;
        $this->is_modify=false;

        $this->generar(4);
    }

    public function crear(){

        // validate
        $this->validate();

        Variable::create([
                    'name'          =>strtolower($this->name),
                    'porcentaje'    =>floatval($this->porcentaje),
                    'tipo'          =>intval($this->tipo)
                ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el parámetro: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('cancelando');
    }

    public function show($item, $accion){

        $this->is_modify=false;
        $this->elegido=Variable::find($item);

        switch ($accion) {
            case 1:
                $this->is_inactivar=true;
                $this->nameinac=$this->elegido->name;
                $this->statusinac=$this->elegido->status;
                break;
        }

    }

    public function inactivar(){

        Variable::where('id',$this->elegido->id)
                ->update([
                    'status'    =>!$this->statusinac,
                ]);

        $this->dispatch('alerta', name:'Se modifico el estado del parámetro: '.$this->nameinac);
        $this->volver();
    }

    private function params(){
        return Variable::buscar($this->buscaregistro)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);
    }
}
