<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Superusuario=Role::create(['name'=>'Superusuario']);
        $Administrador=Role::create(['name'=>'Administrador']);
        $Coordinador=Role::create(['name'=>'Coordinador']);
        $Auxiliar=Role::create(['name'=>'Auxiliar']);

        Permission::create([
                    'name'=>'Configuracion',
                    'descripcion'=>'Ingreso al menú Configuración',
                    'modulo'=>'configuracion'
                ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);

        Permission::create([
                    'name'=>'cf_roles',
                    'descripcion'=>'Ver listado de roles',
                    'modulo'=>'configuracion'
                ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);

        Permission::create([
                    'name'=>'cf_rolesCrea',
                    'descripcion'=>'Genera roles',
                    'modulo'=>'configuracion'
                ])->syncRoles([$Superusuario]);

        Permission::create([
                    'name'=>'cf_rolesEdita',
                    'descripcion'=>'Edita roles',
                    'modulo'=>'configuracion'
                ])->syncRoles([$Superusuario]);

        Permission::create([
                    'name'=>'cf_users',
                    'descripcion'=>'Ver listado de usuarios',
                    'modulo'=>'configuracion'
                ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);

        Permission::create([
                    'name'=>'cf_usersCrea',
                    'descripcion'=>'Genera users',
                    'modulo'=>'configuracion'
                ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);

        Permission::create([
                    'name'=>'cf_usersEdita',
                    'descripcion'=>'Edita users',
                    'modulo'=>'configuracion'
                ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);

        Permission::create([
                    'name'=>'cf_params',
                    'descripcion'=>'Ver listado de parámetros',
                    'modulo'=>'configuracion'
                ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);

        Permission::create([
                    'name'=>'cf_paramsCrea',
                    'descripcion'=>'Genera parámetros',
                    'modulo'=>'configuracion'
                ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);

        Permission::create([
                    'name'=>'cf_paramsEdita',
                    'descripcion'=>'Edita parámetros',
                    'modulo'=>'configuracion'
                ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);


        Permission::create([
                    'name'=>'Gestion',
                    'descripcion'=>'Ingreso al menú Gestión',
                    'modulo'=>'gestion'
                ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Permission::create([
                    'name'=>'cl_clientes',
                    'descripcion'=>'Ver listado de clientes',
                    'modulo'=>'gestion'
                ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Permission::create([
                    'name'=>'cl_clientesCrea',
                    'descripcion'=>'Genera clientes',
                    'modulo'=>'gestion'
                ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);

        Permission::create([
                    'name'=>'cl_clientesEdita',
                    'descripcion'=>'Edita clientes',
                    'modulo'=>'gestion'
                ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);

        Permission::create([
                    'name'=>'cl_proveedor',
                    'descripcion'=>'Ver listado de proveedor.',
                    'modulo'=>'gestion'
                ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Permission::create([
                    'name'=>'cl_proveedorCrea',
                    'descripcion'=>'Genera proveedor.',
                    'modulo'=>'gestion'
                ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Permission::create([
                    'name'=>'cl_proveedorEdita',
                    'descripcion'=>'Edita proveedor.',
                    'modulo'=>'gestion'
                ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Permission::create([
                    'name'=>'cl_programacion',
                    'descripcion'=>'Ver listado de programación.',
                    'modulo'=>'gestion'
                ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Permission::create([
                    'name'=>'cl_programacionCrea',
                    'descripcion'=>'Genera programación.',
                    'modulo'=>'gestion'
                ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Permission::create([
                    'name'=>'cl_programacionEdita',
                    'descripcion'=>'Edita programación.',
                    'modulo'=>'gestion'
                ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
    }


}
