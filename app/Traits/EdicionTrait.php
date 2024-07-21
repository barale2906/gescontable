<?php

namespace App\Traits;

trait EdicionTrait
{
    //Campos
    public $is_name=false;
    public $is_email=false;
    public $is_permisos=false;
    public $is_buscando=false;
    public $is_rols=false;
    public $is_password=false;

    //Zonas con grillas
    public $is_grilla=false;

    //PLace holders y encabezado de campo
    public $texto_holder_name;
    public $texto_enca_name;


    //Botones
    public $is_crear=false;
    public $is_editar=false;
    public $is_asignar=false;

    public function limpiar(){
        $this->reset(
            'is_name',
            'is_email',
            'is_permisos',
            'is_buscando',
            'is_rols',
            'is_password',
            'is_grilla',
            'texto_holder_name',
            'texto_enca_name',
            'is_editar',
            'is_crear',
            'is_asignar'
        );
    }


    public function generar($id){
        $this->limpiar();
        $this->is_crear=true;
        switch ($id) {
            case 1:
                //Roles
                $this->is_name=!$this->is_name;
                $this->is_permisos=!$this->is_permisos;
                $this->texto_enca_name="Nombre del Rol";
                $this->texto_holder_name='Registre nombre';
                break;

            case 2:
                //Roles Asigna permisos
                $this->is_buscando=!$this->is_buscando;
                $this->texto_enca_name="Nombre del Usuario";
                $this->is_crear=false;
                $this->is_asignar=true;
                break;
        }
    }

    public function modificar($id){

        $this->limpiar();
        $this->is_editar=true;
        switch ($id) {
            case 1:
                //Rol
                $this->is_name=!$this->is_name;
                $this->is_permisos=!$this->is_permisos;
                $this->texto_enca_name="Nombre del Rol";
                $this->texto_holder_name='Registro el nombre del rol';
                break;

            case 2:
                //Usuario
                $this->is_name=!$this->is_name;
                $this->is_email=!$this->is_email;
                $this->is_rols=!$this->is_rols;
                $this->texto_enca_name="Nombre del Usuario";
                $this->texto_holder_name='Registro el nombre del usuario';
                break;
        }
    }
}
