<?php

namespace App\Traits;

use App\Models\User;
use Livewire\WithPagination;
use App\Traits\FiltroTrait;
use App\Traits\EdicionTrait;
use Livewire\Attributes\On;
use Spatie\Permission\Models\Role;

trait UsersTrait
{
    use WithPagination;
    use FiltroTrait;
    use EdicionTrait;

    public $is_modify=true;
    public $is_editing=false;
    public $is_inactivar=false;

    public $name;
    public $email;
    public $password;
    public $rol_id;
    public $contra1;
    public $contra2;

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
                'name',
                'email',
                'password',
                'rol_id',
                'nameinac',
                'statusinac',
                'elegido',
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
                $this->modificar(2);
                $this->cargavalores();
                break;

            case 1:
                $this->is_inactivar=true;
                $this->nameinac=$this->elegido->name;
                $this->statusinac=$this->elegido->status;
                break;
        }

    }

    public function cargavalores(){
        $this->name=$this->elegido->name;
        $this->email=$this->elegido->email;

        $this->rol_id=$this->elegido->roles[0]['name'];
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'email'=>'required|email',
        'rol_id'=>'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'name',
            'email',
            'password',
            'rol_id'
        );
    }

    // Crear
    public function creando(){
        $this->is_editing=true;
        $this->is_modify=false;

        $this->generar(3);
    }

    public function crear(){

        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=User::Where('email', strtolower($this->email))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe el usuario registrado con el correo electrónico: '.$this->email);
        } else if($this->password){

            //id del rol
            $rolelegido=Role::where('name', $this->rol_id)
                                ->first();

            $usuario=User::create([
                    'rol_id'=>$rolelegido->id,
                    'name'=>strtolower($this->name),
                    'email'=>strtolower($this->email),
                    'password'=>bcrypt($this->password),
                ]);

            $usuario->assignRole($this->rol_id);

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el usuario: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('cancelando');

        }else{
            $this->dispatch('alerta', name:'El campo contraseña es obligatorio');
        }
    }

    public function editar(){

        // validate
        $this->validate();

        $rol=Role::where('name', $this->rol_id)->first();

        //Actualizar registros
        User::whereId($this->elegido->id)
                ->update([
                    'name'=>strtolower($this->name),
                    'email'=>strtolower($this->email),
                    'rol_id'=>$rol->id
                ]);

        //Actualizar Rol
        $this->elegido->syncRoles($this->rol_id);


        $this->dispatch('alerta', name:'Se ha modificado correctamente el Usuario: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    public function inactivar(){

        User::where('id',$this->elegido->id)
                ->update([
                    'status'    =>!$this->statusinac,
                ]);

        $this->dispatch('alerta', name:'Se modifico el estado del Usuario: '.$this->nameinac);
        $this->volver();
    }

    public function cambiarpassword(){

        if($this->contra1 && $this->contra1===$this->contra2){

            $this->elegido->update([
                'password'=>bcrypt($this->contra1)
            ]);

            $this->reset(
                'contra1',
                'contra2'
            );

            $this->dispatch('alerta', name:'Se modifico la contraseña para: '.$this->name);

        }else{
            $this->dispatch('alerta', name:'Las contraseñas deben ser iguales');
        }
    }

    private function users(){
        return User::buscar($this->buscaregistro)
                    ->orderBy($this->ordena, $this->ordenado)
                    ->paginate($this->pages);
    }

    private function roles(){
        return Role::all();
    }
}
