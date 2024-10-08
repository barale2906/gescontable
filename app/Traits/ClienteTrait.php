<?php

namespace App\Traits;

use App\Models\Clientes\Clientes\Cliente;
use App\Models\Gestion\Asignacion;
use App\Models\User;
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
    public $is_gestion=false;

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
    public $id;
    public $permis=[];

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
                'is_gestion',
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


        $cliente=Cliente::create([
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

        //Cargar usuarios
        foreach ($this->permis as $value) {
            Asignacion::create([
                'cliente_id'=>$cliente->id,
                'usuario_id'=>intval($value),
                'observaciones'=>now().": ".strtolower(Auth::user()->name)." Creación del cliente.",
            ]);
        }

        /* //Cargar superusuarios
        $superusu=User::where('status',true)
                        ->where('rol_id',1)
                        ->orderBy('name','ASC')
                        ->get();

        foreach ($superusu as $value) {
            Asignacion::create([
                'cliente_id'=>$cliente->id,
                'usuario_id'=>intval($value->id),
                'observaciones'=>now().": ".strtolower(Auth::user()->name)." Creación del cliente.",
            ]);
        } */

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

            case 2:
                $this->is_gestion=true;
                $this->id=$item;
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

    public function asignauser($id){
        $esta=Asignacion::where('usuario_id',$id)
                            ->where('cliente_id',$this->elegido->id)
                            ->count();

        if($esta>0){
            $this->dispatch('alerta', name:'¡Ya esta asignado!');
        }else{
            Asignacion::create([
                'cliente_id'    =>$this->elegido->id,
                'usuario_id'    =>$id,
                'observaciones' =>now().' '.Auth::user()->name.' Asigno usuarios gestores',
            ]);
            //$this->dispatch('alerta', name:'¡Se asigno correctamente!');
        }
    }

    public function eliminauser($id){
        Asignacion::where('usuario_id',$id)
                    ->where('cliente_id',$this->elegido->id)
                    ->delete();

        $this->dispatch('alerta', name:'¡Se elimino correctamente!');
    }

    //Editar
    public function editar(){
        // validate
        $this->validate();

        $bitacora=now()." ".strtolower(Auth::user()->name).": Actualizo el cliente con los siguientes datos: ".$this->name.", ".
        'Nombre: '.$this->name.", ".
        'Nit: '.$this->nit.", ".
        'DV: '.$this->DV.", ".
        'RL: '.$this->representante_legal.", ".
        'Cédula RL: '.$this->cedula_rl.", ".
        'Dirección: '.$this->direccion.", ".
        'Teléfono: '.$this->telefono.", ".
        'Contacto: '.$this->persona_contacto.", ".
        'Correo: '.$this->email.", ".
        'Software: '.$this->software_contable.", ".
        'Usuario: '.$this->usuario.", ".
        'llave: '.$this->llave.", ".
        'Matricula: '.$this->matricula.", ".
        " ----- ".$this->elegido->bitacora;

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

    private function usuarios(){
        return User::where('status',true)
                    ->where('rol_id','>',1)
                    ->orderBy('name','ASc')
                    ->get();
    }
}
