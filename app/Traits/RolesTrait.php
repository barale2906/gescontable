<?php

namespace App\Traits;

use Livewire\Attributes\On;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Traits\EdicionTrait;
use Illuminate\Support\Facades\DB;

trait RolesTrait
{
    use EdicionTrait;

    public $is_modify=true;
    public $is_editing=false;
    public $is_inactivar=false;
    public $is_permiso=false;
    public $elegido;
    public $nameinac;
    public $statusinac;
    public $name;
    public $permis = [];

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'permis'=>'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'permis');

    }

    // Crear
    public function crear(){

        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=Role::Where('name', '=',strtolower($this->name))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe este rol: '.$this->name);
        } else {
            //Crear registro
            $rol = Role::create([
                'name'=>strtolower($this->name),
            ]);

            //Asignar permisos
            //$rol->givePermissionTo($this->permis);
            foreach ($this->permis as $value) {
                DB::table('role_has_permissions')
                    ->insert([
                        'permission_id'=>$value,
                        'role_id'=>$rol->id
                    ]);
            }

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el rol: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('cancelando');$this->volver();
        }
    }

    //Editar rol
    public function editar()
    {
        // validate
        $this->validate();

        $rol=Role::find($this->elegido->id);
        $rol->update([
            'name'=>strtolower($this->name)
        ]);

        //Actualizar registros
        /* Role::whereId($this->elegido->id)->update([
            'name'=>strtolower($this->name)
        ]);
        */
        //Actualizar permisos
        //$this->elegido->syncPermissions($this->permis);
        $rol->permissions()->sync($this->permis);

        $this->dispatch('alerta', name:'Se ha modificado correctamente el Rol: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
        $this->limpiar();
    }

    //Activar evento
    #[On('cancelando')]
    //Mostrar formulario de inactivación
    public function volver()
    {
        $this->reset(
            'is_modify',
            'is_editing',
            'is_permiso',
            'is_inactivar',
            'name',
            'permis'
        );

        $this->limpiar();
    }

    public function show($item, $accion){

        $this->is_modify=false;
        $this->elegido=Role::find($item);

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
                break;

            case 3:
                $this->is_editing=true;
                $this->generar(1);
                break;
        }
    }

    public function cargavalores(){
        $this->name=$this->elegido->name;
        foreach ($this->elegido->permissions as $value) {
            array_push($this->permis,$value->id);
        }
    }

    public function inactivar(){
        $this->elegido->update([
            'status'    =>!$this->statusinac,
        ]);
        $this->dispatch('alerta', name:'Se modifico el estado del rol.');
        $this->volver();
    }

    private function roles(){
        return Role::all();
    }

    private function permisos(){
        return Permission::all();
    }

    private function encabezados(){
        return Permission::groupBy('modulo')
                            ->select('modulo')
                            ->get();
    }
}
