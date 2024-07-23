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

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {

                    Cliente::create([
                            'name'=>$data[0],
                            'nit'=>$data[1],
                            'DV'=>$data[2],
                            'representante_legal'=>$data[3],
                            'cedula_rl'=>$data[4],
                            'direccion'=>$data[5],
                            'telefono'=>$data[6],
                            'persona_contacto'=>$data[7],
                            'email'=>$data[8],
                            'software_contable'=>$data[9],
                            'usuario'=>$data[10],
                            'llave'=>$data[11],
                            'matricula'=>$data[12],
                            'bitacora'=>$data[13],
                    ]);


                }catch(Exception $exception){
                    Log::info('Line: ' . $row . ' clientes with error: ' . $exception->getMessage());
                }
            }
        }

        fclose($handle);
    }
}
