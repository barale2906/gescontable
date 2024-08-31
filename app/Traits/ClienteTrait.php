<?php

namespace App\Traits;

use App\Models\Clientes\Clientes\Cliente;
use App\Traits\FiltroTrait;
use App\Traits\EdicionTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\WithPagination;

trait ClienteTrait
{
    use WithPagination;
    use FiltroTrait;
    use EdicionTrait;

    public $is_modify=true;
    public $is_editing=false;
    public $is_inactivar=false;

    public $name;
    public $nit;
    public $DV;
    public $representante_legal;
    public $cedula_rl;
    public $direccion;
    public $telefono;
    public $persona_contacto;
    public $email;
    public $software_contable;
    public $usuario;
    public $llave;
    public $matricula;
    public $nameinac;
    public $statusinac;
    public $elegido;

    public $buscar=null;
    public $buscaregistro;

    public $ordena='name';
    public $ordenado='ASC';
    public $pages = 15;

    public function mount(){
        $this->claseFiltro(3);
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
                'nit',
                'DV',
                'representante_legal',
                'cedula_rl',
                'direccion',
                'telefono',
                'persona_contacto',
                'email',
                'software_contable',
                'usuario',
                'llave',
                'matricula',
                'nameinac',
                'statusinac',
                'elegido',
                'buscar',
                'buscaregistro',
                'ordena',
                'ordenado',
                'pages',
        );

        $this->limpiar();
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name'                  =>'required|max:100|unique:clientes',
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

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'name',
            'nit',
            'DV',
            'representante_legal',
            'cedula_rl',
            'direccion',
            'telefono',
            'persona_contacto',
            'email',
            'software_contable',
            'usuario',
            'llave',
            'matricula',
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

        $bitacora=now()." ".strtolower(Auth::user()->name).": Creo el cliente";

        Cliente::create([
            'name'=>$this->name,
            'email'=>$this->email,
            'nit'=>$this->nit,
            'DV'=>$this->DV,
            'representante_legal'=>$this->representante_legal,
            'cedula_rl'=>$this->cedula_rl,
            'direccion'=>$this->direccion,
            'telefono'=>$this->telefono,
            'persona_contacto'=>$this->persona_contacto,
            'email'=>$this->email,
            'software_contable'=>$this->software_contable,
            'usuario'=>$this->usuario,
            'llave'=>$this->llave,
            'matricula'=>$this->matricula,
            'bitacora'=>$bitacora,
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el cliente: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('cancelando');
    }

    public function show($item, $accion){

        $this->is_modify=false;
        $this->elegido=Cliente::find($item);

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
        $this->nit=$this->elegido->nit;
        $this->DV=$this->elegido->DV;
        $this->representante_legal=$this->elegido->representante_legal;
        $this->cedula_rl=$this->elegido->cedula_rl;
        $this->direccion=$this->elegido->direccion;
        $this->telefono=$this->elegido->telefono;
        $this->persona_contacto=$this->elegido->persona_contacto;
        $this->email=$this->elegido->email;
        $this->software_contable=$this->elegido->software_contable;
        $this->usuario=$this->elegido->usuario;
        $this->llave=$this->elegido->llave;
        $this->matricula=$this->elegido->matricula;
    }

    //Editar
    public function editar(){
        // validate
        $this->validate();

        $bitacora=now()." ".strtolower(Auth::user()->name).": Actualizo el cliente ----- ".$this->elegido->bitacora;

        $cliente=Cliente::find($this->elegido->id);
        $cliente->update([
            'name'=>strtolower($this->name),
            'nit'=>$this->nit,
            'DV'=>$this->DV,
            'representante_legal'=>strtolower($this->representante_legal),
            'cedula_rl'=>$this->cedula_rl,
            'direccion'=>strtolower($this->direccion),
            'telefono'=>$this->telefono,
            'persona_contacto'=>strtolower($this->persona_contacto),
            'email'=>$this->email,
            'software_contable'=>strtolower($this->software_contable),
            'usuario'=>$this->usuario,
            'llave'=>$this->llave,
            'matricula'=>$this->matricula,
            'bitacora'=>$bitacora,
        ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente el cliente: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
        $this->limpiar();
    }

    public function inactivar(){

        Cliente::where('id',$this->elegido->id)
                ->update([
                    'status'    =>!$this->statusinac,
                ]);

        $this->dispatch('alerta', name:'Se modifico el estado del cliente: '.$this->nameinac);
        $this->volver();
    }

    private function clientes(){
        return cliente::buscar($this->buscaregistro)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);
    }
}
