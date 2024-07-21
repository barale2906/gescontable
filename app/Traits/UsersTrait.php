<?php

namespace App\Traits;

use App\Models\User;
use Livewire\WithPagination;
use App\Traits\FiltroTrait;
use Livewire\Attributes\On;

trait UsersTrait
{
    use WithPagination;
    use FiltroTrait;

    public $is_modify=true;
    public $is_editing=false;
    public $is_inactivar=false;

    public $nameinac;
    public $statusinac;
    public $elegido;

    public $buscar=null;
    public $buscaregistro;

    public $ordena='name';
    public $ordenado='ASC';
    public $pages = 15;

    public function mount(){
        $this->claseFiltro(1);
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
        );

        $this->users();

        $this->limpiar();
    }

    public function show($item, $accion){

        $this->is_modify=false;
        $this->elegido=User::find($item);

        switch ($accion) {
            case 0:
                $this->is_editing=true;
                $this->modificar(1);
                $this->cargavalores();
                break;

            case 1:
                $this->is_inactivar=true;
                $this->nameinac=$this->elegido->name;
                $this->statusinac=$this->elegido->status;
                break;

            case 2:
                $this->is_permiso=true;
                $this->generar(2);
                break;

            case 3:
                $this->is_editing=true;
                $this->generar(1);
                break;
        }
    }

    public function inactivar(){

        User::where('id',$this->elegido->id)
                ->update([
                    'status'    =>!$this->statusinac,
                ]);

        $this->dispatch('alerta', name:'Se modifico el estado del Usuario: '.$this->nameinac);
        $this->volver();
    }

    private function users(){
        return User::buscar($this->buscaregistro)
                    ->orderBy($this->ordena, $this->ordenado)
                    ->paginate($this->pages);
    }
}
