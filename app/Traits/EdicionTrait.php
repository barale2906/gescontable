<?php

namespace App\Traits;

trait EdicionTrait
{
    //Campos
    public $is_name=false;
    public $is_email=false;
    public $is_permisos=false;

    //Zonas con grillas
    public $is_grilla=false;

    //PLace holders y encabezado de campo
    public $texto_holder_name;
    public $texto_enca_name;


    //Botones
    public $is_crear=false;
    public $is_editar=false;

    public function limpiar(){
        $this->reset(
            'is_name',
            'is_email',
            'is_permisos',
            'is_grilla',
            'texto_holder_name',
            'texto_enca_name',
            'is_editar',
            'is_crear',
        );
    }


    public function crear($id){
        $this->limpiar();
        $this->is_crear=true;
        switch ($id) {
            case 1:
                //Roles
                $this->is_name=!$this->is_name;
                $this->is_permisos=!$this->is_permisos;
                $this->is_editar=!$this->is_editar;
                break;
        }
    }

    public function edirol(){
        $this->is_name=!$this->is_name;
        $this->is_permisos=!$this->is_permisos;
        $this->texto_enca_name="Nombre del Rol";
        $this->texto_holder_name='Registro el nombre del rol';
        $this->is_editar=!$this->is_editar;
    }
}
