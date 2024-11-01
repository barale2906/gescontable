<?php

namespace App\Traits;

use App\Traits\EdicionTrait;

trait FiltroTrait
{
    use EdicionTrait;

    public $is_filtro=false;
    public $txt;
    public $permiso;

    public $is_fecha=false;
    public $is_parametro=false;

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

            case 3:
                //Clientes
                $this->txt="Buscar por nombre, nit";
                $this->permiso='cl_clientesCrea';
                break;

            case 4:
                //Proveedores
                $this->txt="Buscar por nombre, producto";
                $this->permiso='cl_proveedorCrea';
                break;

            case 5:
                //Programaciones - gestiones
                $this->txt="Buscar por nombre y observaciones";
                $this->permiso='cl_programacionCrea';
                break;

            case 6:
                //Papeles
                $this->txt="Buscar por documento, destinatario, documento destinatario";
                $this->permiso='cl';
                $this->is_fecha=true;
                $this->is_parametro=true;
                break;
        }
    }
}
