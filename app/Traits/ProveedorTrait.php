<?php

namespace App\Traits;

use App\Models\Gestion\Proveedor;
use App\Traits\FiltroTrait;
use App\Traits\EdicionTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\WithPagination;

trait ProveedorTrait
{
    use WithPagination;
    use FiltroTrait;
    use EdicionTrait;

    public $is_modify=true;
    public $is_editing=false;
    public $is_inactivar=false;

    public $name;
    public $direccion;
    public $telefono;
    public $persona_contacto;
    public $email;
    public $productos;
    public $elegido;

    public $buscar=null;
    public $buscaregistro;

    public $nameinac;
    public $statusinac;

    public $ordena='name';
    public $ordenado='ASC';
    public $pages = 15;

    public function mount(){
        $this->claseFiltro(4);
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
                'direccion',
                'telefono',
                'persona_contacto',
                'email',
                'productos',
                'elegido',
                'nameinac',
                'statusinac',
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
        'name'              =>'required|max:100',
        'direccion'         =>'required',
        'telefono'          =>'required',
        'persona_contacto'  =>'required',
        'email'             =>'required',
        'productos'         =>'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                'name',
                'direccion',
                'telefono',
                'persona_contacto',
                'email',
                'productos',
        );
    }

    // Crear
    public function creando(){
        $this->is_editing=true;
        $this->is_modify=false;

        $this->generar(6);
    }

    public function crear(){

        // validate
        $this->validate();

        Proveedor::create([
                    'name'=>strtolower($this->name),
                    'direccion'=>strtolower($this->direccion),
                    'telefono'=>$this->telefono,
                    'persona_contacto'=>strtolower($this->persona_contacto),
                    'email'=>strtolower($this->email),
                    'productos'=>strtolower($this->productos),
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el proveedor: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('cancelando');
    }

    public function show($item, $accion){

        $this->is_modify=false;
        $this->elegido=Proveedor::find($item);

        switch ($accion) {

            case 0:
                $this->is_editing=true;
                $this->modificar(4);
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
        $this->direccion=$this->elegido->direccion;
        $this->telefono=$this->elegido->telefono;
        $this->persona_contacto=$this->elegido->persona_contacto;
        $this->email=$this->elegido->email;
        $this->productos=$this->elegido->productos;
    }

    //Editar
    public function editar(){
        // validate
        $this->validate();

        $cliente=Proveedor::find($this->elegido->id);
        $cliente->update([
                'name'=>strtolower($this->name),
                'direccion'=>strtolower($this->direccion),
                'telefono'=>$this->telefono,
                'persona_contacto'=>strtolower($this->persona_contacto),
                'email'=>strtolower($this->email),
                'productos'=>strtolower($this->productos),
        ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente el proveedor: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
        $this->limpiar();
    }

    public function inactivar(){

        Proveedor::where('id',$this->elegido->id)
                ->update([
                    'status'    =>!$this->statusinac,
                ]);

        $this->dispatch('alerta', name:'Se modifico el estado del proveedor: '.$this->nameinac);
        $this->volver();
    }

    private function proveedores(){
        return Proveedor::buscar($this->buscaregistro)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);
    }
}
