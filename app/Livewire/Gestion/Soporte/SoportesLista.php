<?php

namespace App\Livewire\Gestion\Soporte;

use App\Models\Clientes\Clientes\Cliente;
use App\Models\Configuracion\Parametro;
use App\Models\Gestion\Soporte;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class SoportesLista extends Component
{
    use WithPagination;
    use WithFileUploads;


    public $buscar=null;
    public $buscaregistro;

    public $ordena='created_at';
    public $ordenado='DESC';
    public $pages = 15;

    public $cliente;
    public $name;
    public $parametro;
    public $archivo;
    public $ruta;


    public function mount($id){
        $this->cliente=Cliente::find($id);
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

    /**
     * Reglas de validación
     */
    protected $rules = [
        'parametro' =>'required',
        'name'      => 'required',
        'archivo'   => 'required|mimes:jpg,bmp,png,pdf,jpeg',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'parametro',
            'name',
            'archivo',
        );
    }

    public function new(){

        // validate
        $this->validate();

        $param=Parametro::find(intval($this->parametro));

        if($this->archivo){

            $this->ruta='soporte/'.$param->id."_".$this->cliente->id."-".uniqid().".".$this->archivo->extension();
            $this->archivo->storeAs($this->ruta);
        }


        Soporte::create([
                'parametro_id'=>$param->id,
                'cliente_id'=>$this->cliente->id,
                'cargado_id'=>Auth::user()->id,
                'ruta'=>$this->ruta,
                'parame'=>$param->name,
                'clien'=>$this->cliente->name,
                'name'=>$this->name,
                'observaciones'=>now()." ".Auth::user()->name.", cargo el documento.",
            ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha cargado correctamente el documento');
        $this->resetFields();
    }

    private function soportes(){
        return Soporte::where('cliente_id', $this->cliente->id)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }

    private function parametros(){
        return Parametro::where('tipo',1)
                        ->where('status',true)
                        ->orderBy('name','ASC')
                        ->get();
    }

    public function render()
    {
        return view('livewire.gestion.soporte.soportes-lista',[
            'soportes'=>$this->soportes(),
            'parametros'=>$this->parametros()
        ]);
    }
}
