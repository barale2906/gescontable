<?php

namespace App\Traits;

use App\Models\Gestion\Programacion;
use Livewire\WithPagination;
use App\Traits\EdicionTrait;
use App\Traits\FiltroTrait;
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

    public $buscar=null;
    public $buscaregistro;

    public $filtroInides;
    public $filtroInihas;
    public $filtroinicia=[];

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
                'buscar',
                'buscaregistro',
                'ordena',
                'ordenado',
                'pages',
                'elegido'
            );
    }

    /**
     * Reglas de validación
     */
    protected function rules(){

        if($this->elegido){
            return [
                'name'                  => 'required|max:100|unique:clientes,name,' . $this->elegido->id,
                'nit'                   =>'required',
                'DV'                    =>'required',
                'representante_legal'   =>'required',
                'cedula_rl'             =>'required',
                'direccion'             =>'required',
                'telefono'              =>'required',
                'persona_contacto'      =>'required',
                'email'                 =>'required',
                'software_contable'     =>'required',
                'usuario'               =>'required',
                'llave'                 =>'required',
                'matricula'             =>'required',
            ];
        }else{
            return [
                'name'                  => 'required|max:100|unique:clientes,name',
                'nit'                   =>'required',
                'DV'                    =>'required',
                'representante_legal'   =>'required',
                'cedula_rl'             =>'required',
                'direccion'             =>'required',
                'telefono'              =>'required',
                'persona_contacto'      =>'required',
                'email'                 =>'required',
                'software_contable'     =>'required',
                'usuario'               =>'required',
                'llave'                 =>'required',
                'matricula'             =>'required',
            ];
        }

    }

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

        $this->generar(4);
    }

    private function programas(){
        return Programacion::buscar($this->buscaregistro)
                            ->inicia($this->filtroinicia)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);
    }

}
