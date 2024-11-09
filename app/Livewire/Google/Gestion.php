<?php

namespace App\Livewire\Google;

use Exception;
use Livewire\Component;
use Google\Client;
use Google\Service\Drive;
use Illuminate\Support\Facades\Log;

class Gestion extends Component
{
    function createGoogleSheet() {

        $client = new Client();
        $client->setAuthConfig(config('services.google.client_secret'));
        $client->addScope(Drive::DRIVE);

        $driveService = new Drive($client);
        $fileMetadata = new Drive\DriveFile([
            'name' => 'Mi nuevo documento',
            /* 'mimeType' => 'application/vnd.google-apps.spreadsheet', */
            /* 'mimeType' => 'application/vnd.google-apps.document', */
            'mimeType' => 'application/vnd.google-apps.presentation',
        ]);

        try {

            $file = $driveService->files->create($fileMetadata, [
                'fields' => 'id',
            ]);

            // Hacer el archivo público
            $permission = new Drive\Permission([
                'type' => 'anyone',
                'role' => 'writer', // o 'reader' si solo quieres que vean el archivo
            ]);

            // Añadir permiso al archivo
            $driveService->permissions->create($file->id, $permission);

            //return redirect("https://docs.google.com/spreadsheets/d/{$file->id}/edit"); // Hojas de calculo
            //return redirect("https://docs.google.com/document/d/{$file->id}/edit"); // Documento
            return redirect("https://docs.google.com/presentation/d/{$file->id}/edit"); // presentación

        } catch (Exception $e) {
                // Manejar excepciones
                Log::info('Error al crear la hoja de cálculo:' . $e->getMessage());
                $this->dispatch('alerta', name:'No se genero.');
                return response()->json(['error' => 'Error al crear la hoja de cálculo.'], 500);
            }

    }

    public function render()
    {
        return view('livewire.google.gestion');
    }
}
