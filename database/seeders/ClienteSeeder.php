<?php

namespace Database\Seeders;

use App\Models\Clientes\Clientes\Cliente;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/clientes.csv', 'r')) !== false) {

            $bitacora=now().": Creado por Gescontable";
            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {

                    Cliente::create([
                            'name'=>strtolower($data[0]),
                            'nit'=>$data[1],
                            'DV'=>$data[2],
                            'representante_legal'=>strtolower($data[3]),
                            'cedula_rl'=>$data[4],
                            'direccion'=>strtolower($data[5]),
                            'telefono'=>$data[6],
                            'persona_contacto'=>strtolower($data[7]),
                            'email'=>$data[8],
                            'software_contable'=>strtolower($data[9]),
                            'usuario'=>$data[10],
                            'llave'=>$data[11],
                            'matricula'=>$data[12],
                            'bitacora'=>$bitacora,
                    ]);

                }catch(Exception $exception){
                    Log::info('Line: ' . $row . ' clientes with error: ' . $exception->getMessage());
                }
            }
        }

        fclose($handle);
    }
}
