<?php

namespace App\Livewire\Google;

use App\Models\Clientes\Clientes\Cliente;
use App\Models\Configuracion\Parametro;
use App\Models\Gestion\Soporte;
use Exception;
use Livewire\Component;
use Google\Client;
use Google\Service\Drive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Gestion extends Component
{
    public $nombre;
    public $nombrecarga;
    public $tipo;
    public $nime;
    public $ruta;
    public $cliente;
    public $archivoid;
    public $param;

    public function mount($id){
        $this->cliente=Cliente::find($id);
    }

    public function definicion(){

        if($this->nombre && $this->tipo && $this->param){
            $this->nombrecarga=now()."-".$this->cliente->nit."-".$this->nombre;

            switch (intval($this->tipo)) {
                case 1:
                    $this->nime='application/vnd.google-apps.spreadsheet';
                    break;

                case 2:
                    $this->nime='application/vnd.google-apps.document';
                    break;

                case 3:
                    $this->nime='application/vnd.google-apps.presentation';
                    break;
            }

            $this->createGoogle();
        }else{
            $this->dispatch('alerta', name:'Ambos campos son obligatorios.');
        }


    }

    private function createGoogle() {

        $client = new Client();
        $client->setAuthConfig(config('services.google.client_secret'));
        $client->addScope(Drive::DRIVE);

        $driveService = new Drive($client);
        $fileMetadata = new Drive\DriveFile([
            'name' => $this->nombrecarga,
            'mimeType' => $this->nime,
        ]);

        try {

            $file= $driveService->files->create($fileMetadata, [
                'fields' => 'id',
            ]);

            $this->archivoid =$file->id;

            // Hacer el archivo público
            $permission = new Drive\Permission([
                'type' => 'anyone',
                'role' => 'writer', // o 'reader' si solo quieres que vean el archivo
            ]);

            // Añadir permiso al archivo
            $driveService->permissions->create($this->archivoid, $permission);

            switch (intval($this->tipo)) {
                case 1:
                    $this->ruta="https://docs.google.com/spreadsheets/d/{$this->archivoid}/edit";
                    break;

                case 2:
                    $this->ruta="https://docs.google.com/document/d/{$this->archivoid}/edit";
                    break;

                case 3:
                    $this->ruta="https://docs.google.com/presentation/d/{$this->archivoid}/edit";
                    break;
            }

            // Cargar información a la base de datos:

            $parametro=Parametro::where('id',intval($this->param))
                                    ->select('name')
                                    ->first();

            /* dd(
                " param: ",$this->param,
                " cliente: ",$this->cliente->id,
                " carga: ",Auth::user()->id,
                " Ruta: ",$this->ruta,
                " parame: ",$parametro->name,
                " clien: ",$this->cliente->name,
                " name: ",$this->nombrecarga,
            ); */

            $registro=Soporte::create([
                    'parametro_id'=>intval($this->param),
                    'cliente_id'=>$this->cliente->id,
                    'cargado_id'=>Auth::user()->id,
                    'google'=>2,
                    'ruta'=>$this->ruta,
                    'parame'=>$parametro->name,
                    'clien'=>$this->cliente->name,
                    'name'=>$this->nombrecarga,
                    'observaciones'=>now()." ".Auth::user()->name.", genero el documento google.",
            ]);

            return redirect()->route('gestion.google', ['id' => $registro->id]);

        } catch (Exception $e) {
            // Manejar excepciones
            Log::info('Error al crear la hoja de cálculo:' . $e->getMessage());
            $this->dispatch('alerta', name:'No se genero.');
            return response()->json(['error' => 'Error al crear la hoja de cálculo.'], 500);
        }

    }

    private function parametros(){
        return Parametro::where('tipo',1)
                            ->where('status', true)
                            ->orderBy('name','ASC')
                            ->get();
    }

    public function render()
    {
        return view('livewire.google.gestion',[
            'parametros'    => $this->parametros()
        ]);
    }
}
