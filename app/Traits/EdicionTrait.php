<?php

namespace App\Traits;

trait EdicionTrait
{
    //Campos
    public $is_name=false;
    public $is_porcentaje=false;
    public $is_email=false;
    public $is_permisos=false;
    public $is_buscando=false;
    public $is_rols=false;
    public $is_tipo=false;
    public $is_password=false;
    public $is_nit=false;
    public $is_DV=false;
    public $is_representante_legal=false;
    public $is_cedula_rl=false;
    public $is_direccion=false;
    public $is_telefono=false;
    public $is_persona_contacto=false;
    public $is_software_contable=false;
    public $is_usuario=false;
    public $is_llave=false;
    public $is_matricula=false;

    public $is_productos=false;
    public $is_gestor=false;
    public $is_gestor_mod=false;

    public $is_parametros=false;
    public $is_clientes=false;
    public $is_inicio=false;
    public $is_fin=false;
    public $is_observaciones=false;



    //Zonas con grillas
    public $is_grilla=false;
    public $is_pass_change=false;

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
            'is_porcentaje',
            'is_email',
            'is_permisos',
            'is_buscando',
            'is_rols',
            'is_tipo',
            'is_password',
            'is_nit',
            'is_DV',
            'is_representante_legal',
            'is_cedula_rl',
            'is_direccion',
            'is_telefono',
            'is_persona_contacto',
            'is_software_contable',
            'is_usuario',
            'is_llave',
            'is_matricula',
            'is_grilla',
            'is_pass_change',
            'texto_holder_name',
            'texto_enca_name',
            'is_editar',
            'is_crear',
            'is_asignar',
            'is_productos',
            'is_gestor',
            'is_gestor_mod',
            'is_inicio',
            'is_fin',
            'is_parametros',
            'is_clientes',
            'is_observaciones',
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

            case 3:
                //Usuarios
                $this->is_name=!$this->is_name;
                $this->is_email=!$this->is_email;
                $this->is_password=!$this->is_password;
                $this->is_rols=!$this->is_rols;
                $this->texto_enca_name="Nombre del Usuario";
                $this->texto_holder_name='Nombre del usuario';
                break;

            case 4:
                //Parámetros
                $this->is_name=!$this->is_name;
                $this->is_porcentaje=!$this->is_porcentaje;
                $this->is_tipo=!$this->is_tipo;
                $this->texto_enca_name="Nombre del Parámetro";
                $this->texto_holder_name='Registre nombre';
                break;

            case 5:
                //Cliente
                $this->is_name=!$this->is_name;
                $this->is_email=!$this->is_email;
                $this->is_nit=!$this->is_nit;
                $this->is_DV=!$this->is_DV;
                $this->is_representante_legal=!$this->is_representante_legal;
                $this->is_cedula_rl=!$this->is_cedula_rl;
                $this->is_direccion=!$this->is_direccion;
                $this->is_telefono=!$this->is_telefono;
                $this->is_persona_contacto=!$this->is_persona_contacto;
                $this->is_software_contable=!$this->is_software_contable;
                $this->is_usuario=!$this->is_usuario;
                $this->is_llave=!$this->is_llave;
                $this->is_matricula=!$this->is_matricula;
                $this->is_gestor=!$this->is_gestor;
                $this->texto_enca_name="Nombre del Cliente";
                $this->texto_holder_name='Registro el nombre del cliente';

                break;

            case 6:
                //proveedor
                $this->is_name=!$this->is_name;
                $this->is_email=!$this->is_email;
                $this->is_direccion=!$this->is_direccion;
                $this->is_telefono=!$this->is_telefono;
                $this->is_persona_contacto=!$this->is_persona_contacto;
                $this->is_productos=!$this->is_productos;
                $this->texto_enca_name="Nombre del proveedor";
                $this->texto_holder_name='Registro el nombre del proveedor';
                break;

            case 7:
                //programaciones
                $this->is_name=!$this->is_name;
                $this->is_inicio=!$this->is_inicio;
                $this->is_fin=!$this->is_fin;
                $this->is_parametros=!$this->is_parametros;
                $this->is_clientes=!$this->is_clientes;
                $this->is_observaciones=!$this->is_observaciones;
                $this->texto_enca_name="Nombre de la actividad a programar";
                $this->texto_holder_name='Nombre de la actividad';
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
                $this->is_pass_change=!$this->is_pass_change;
                $this->texto_enca_name="Nombre del Usuario";
                $this->texto_holder_name='Registro el nombre del usuario';
                break;

            case 3:
                //Cliente
                $this->is_name=!$this->is_name;
                $this->is_nit=!$this->is_nit;
                $this->is_DV=!$this->is_DV;
                $this->is_representante_legal=!$this->is_representante_legal;
                $this->is_cedula_rl=!$this->is_cedula_rl;
                $this->is_direccion=!$this->is_direccion;
                $this->is_telefono=!$this->is_telefono;
                $this->is_persona_contacto=!$this->is_persona_contacto;
                $this->is_software_contable=!$this->is_software_contable;
                $this->is_usuario=!$this->is_usuario;
                $this->is_llave=!$this->is_llave;
                $this->is_matricula=!$this->is_matricula;
                //$this->is_gestor=!$this->is_gestor;
                $this->is_gestor_mod=!$this->is_gestor_mod;
                $this->texto_enca_name="Nombre del Cliente";
                $this->texto_holder_name='Registro el nombre del cliente';
                break;

            case 4:
                //proveedor
                $this->is_name=!$this->is_name;
                $this->is_email=!$this->is_email;
                $this->is_direccion=!$this->is_direccion;
                $this->is_telefono=!$this->is_telefono;
                $this->is_persona_contacto=!$this->is_persona_contacto;
                $this->is_productos=!$this->is_productos;
                $this->texto_enca_name="Nombre del proveedor";
                $this->texto_holder_name='Registro el nombre del proveedor';
                break;

            case 5:
                //programaciones
                $this->is_name=!$this->is_name;
                $this->is_inicio=!$this->is_inicio;
                $this->is_fin=!$this->is_fin;
                $this->is_parametros=!$this->is_parametros;
                $this->is_clientes=!$this->is_clientes;
                $this->is_observaciones=!$this->is_observaciones;
                $this->texto_enca_name="Nombre de la actividad a programar";
                $this->texto_holder_name='Nombre de la actividad';
                break;
        }
    }
}
