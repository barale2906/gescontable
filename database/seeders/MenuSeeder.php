<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Layout\Menu;
use App\Models\Layout\Submenu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $m1=Menu::create([
            'name'              => 'CONFIGURACIÓN',
            'identificaRuta'    => 'configuracion.*',
            'permiso'           => 'Configuracion',
            'icono'             => 'fa-solid fa-screwdriver-wrench text-gray-500'
        ]);

        Submenu::create([
            'permiso'           => 'cf_roles',
            'ruta'              => 'configuracion.roles',
            'identificaRuta'    => 'configuracion.roles',
            'name'              => 'Roles',
            'icono'             => 'fa-solid fa-wrench text-gray-500',
            'menu_id'           => $m1->id

        ]);

        Submenu::create([
            'permiso'           => 'cf_users',
            'ruta'              => 'configuracion.users',
            'identificaRuta'    => 'configuracion.users',
            'name'              => 'Usuarios',
            'icono'             => 'fa-solid fa-wrench text-gray-500',
            'menu_id'           => $m1->id

        ]);

        Submenu::create([
            'permiso'           => 'cf_params',
            'ruta'              => 'configuracion.params',
            'identificaRuta'    => 'configuracion.params',
            'name'              => 'Parámetros',
            'icono'             => 'fa-solid fa-wrench text-gray-500',
            'menu_id'           => $m1->id

        ]);


        $m2=Menu::create([
            'name'              => 'CLIENTES',
            'identificaRuta'    => 'clientes.*',
            'permiso'           => 'Clientes',
            'icono'             => 'fa-solid fa-people-roof text-gray-500'
        ]);

        Submenu::create([
            'permiso'           => 'cl_clientes',
            'ruta'              => 'clientes.clientes',
            'identificaRuta'    => 'clientes.clientes',
            'name'              => 'Clientes',
            'icono'             => 'fa-solid fa-diagram-project text-gray-500',
            'menu_id'           => $m2->id

        ]);

        Submenu::create([
            'permiso'           => 'cl_calendario',
            'ruta'              => 'clientes.calendario',
            'identificaRuta'    => 'clientes.calendario',
            'name'              => 'Calendario',
            'icono'             => 'fa-solid fa-diagram-project text-gray-500',
            'menu_id'           => $m2->id

        ]);

        Submenu::create([
            'permiso'           => 'cl_programacion',
            'ruta'              => 'clientes.programacion',
            'identificaRuta'    => 'clientes.programacion',
            'name'              => 'Programación',
            'icono'             => 'fa-solid fa-diagram-project text-gray-500',
            'menu_id'           => $m2->id

        ]);
    }
}
