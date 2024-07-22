<?php

namespace App\Traits;

use App\Traits\EdicionTrait;

trait FiltroTrait
{
    use EdicionTrait;

    public $is_filtro=false;
    public $txt;
    public $permiso;

    public function filtroMostrar(){
        $this->is_filtro=!$this->is_filtro;
    }

    public function claseFiltro($id){
        switch ($id) {
            case 1:
                //Usuarios
                $this->txt="Buscar por nombre o correo";
                $this->permiso='cf_usersCrea';
                break;

            case 2:
                //Parámetros
                $this->txt="Buscar por parámetro";
                $this->permiso='cf_paramsCrea';
                break;
        }
    }
}
