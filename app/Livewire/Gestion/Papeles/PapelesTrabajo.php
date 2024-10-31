<?php

namespace App\Livewire\Gestion\Papeles;

use App\Models\Clientes\Clientes\Cliente;
use App\Models\Gestion\Papele;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PapelesTrabajo extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $elegido;

    public $ordena='created_at';
    public $ordenado='DESC';
    public $pages = 15;

    public function mount($id){
        $this->elegido=Cliente::find($id);
    }

    // Ordenar Registros
    public function organizar($campo)
    {
        if($this->ordenado === 'ASC')
        {
            $this->ordenado = 'DESC';
        }else{
            $this->ordenado = 'ASC';
        }
        return $this->ordena = $campo;
    }

    //Numero de registros
    public function paginas($valor)
    {
        $this->resetPage();
        $this->pages=$valor;
    }

    private function papeles(){
        return Papele::where('cliente_id', $this->elegido->id)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.gestion.papeles.papeles-trabajo',[
            'papeles'   =>$this->papeles(),
        ]);
    }
}
