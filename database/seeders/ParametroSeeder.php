<?php

namespace Database\Seeders;

use App\Models\Configuracion\Parametro;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParametroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Parametro::create([
            'name'          =>'estados',
            'tipo'          =>1,
        ]);

        Parametro::create([
            'name'          =>'legales',
            'tipo'          =>1,
        ]);

        Parametro::create([
            'name'          =>'archivos de trabajo',
            'tipo'          =>1,
        ]);

        Parametro::create([
            'name'          =>'impuestos',
            'tipo'          =>1,
        ]);

        Parametro::create([
            'name'          =>'rrhh',
            'tipo'          =>1,
        ]);

        Parametro::create([
            'name'          =>'retención',
            'tipo'          =>3,
            'porcentaje'    =>3.5,
        ]);

        Parametro::create([
            'name'          =>'Declaración de renta',
            'tipo'          =>2,
        ]);


    }
}
