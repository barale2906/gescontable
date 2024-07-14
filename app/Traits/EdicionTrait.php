<?php

namespace App\Traits;

trait EdicionTrait
{
    //Campos
    public $is_name=false;
    public $is_email=false;
    public $is_permisos=false;

    //Botones
    public $is_crear=false;

    public function limpiar(){
        $this->reset(
            'is_name',
            'is_email',
            'is_permisos',
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
                break;
        }
    }
}
