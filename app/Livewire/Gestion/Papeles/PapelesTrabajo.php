<?php

namespace App\Livewire\Gestion\Papeles;

use App\Models\Clientes\Clientes\Cliente;
use App\Models\Configuracion\Parametro;
use App\Models\Gestion\Calculo;
use App\Models\Gestion\Papele;
use App\Traits\FiltroTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PapelesTrabajo extends Component
{
    use WithPagination;
    use WithFileUploads;
    use FiltroTrait;

    public $elegido;
    public $ruta;
    public $archivo;
    public $param;
    public $paradeta;
    public $valor;

    public $buscar=null;
    public $buscaregistro;

    public $filtrofecdes;
    public $filtrofechas;
    public $filtrofechagest=[];
    public $filtroparametro;
    public $is_confirma=false;
    public $borrareg;
    public $is_borraregistro=false;

    public $crterrores=[];
    public $is_errores=false;

    public $ordena='created_at';
    public $ordenado='DESC';
    public $pages = 15;

    public function mount($id){
        $this->elegido=Cliente::find($id);
        $this->claseFiltro(6);
    }

    //Cargar variable
    public function buscaText(){
        $this->resetPage();
        $this->buscaregistro=strtolower($this->buscar);
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
        'archivo'   => 'required|mimes:csv',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'archivo',
        );
    }

    public function updatedParam(){
        $this->paradeta=Parametro::find(intval($this->param));
        $this->limpiacarga();
    }

    public function updatedFiltrofechas(){
        if($this->filtrofecdes<=$this->filtrofechas){
            $crea=array();
            array_push($crea, $this->filtrofecdes);
            array_push($crea, $this->filtrofechas);
            $this->filtrofechagest=$crea;
            if($this->valor){
                $this->updatedFiltroparametro();
            }
        }else{
            $this->dispatch('alerta', name:'Fecha de inicio debe ser menor a fecha fin');
        }
    }

    public function updatedFiltroparametro(){
        $this->reset('paradeta','valor','param');
        $this->paradeta=Parametro::find(intval($this->filtroparametro));
        $this->valor=Calculo::where('cliente_id',$this->elegido->id)
                            ->parametro(intval($this->filtroparametro))
                            ->fecha($this->filtrofechagest)
                            ->get();
    }

    public function limpiacarga(){
        Calculo::where('cliente_id', $this->elegido->id)
                ->where('user_id', Auth::user()->id)
                ->where('status',1)
                ->delete();
    }

    public function cargar(){

        // validate
        $this->validate();
        $this->reset('crterrores','is_errores');

        $this->ruta='papeles/'.$this->elegido->id."-".uniqid().".".$this->archivo->extension();
        $this->archivo->storeAs($this->ruta);

        $this->cargarch();


    }

    public function calculo($id){
        $esta=Calculo::where('papele_id',$id)
                        ->where('parametro_id',$this->paradeta->id)
                        ->where('cliente_id',$this->elegido->id)
                        ->first();
        if($esta){
            $this->dispatch('alerta', name:'Ya se cargo este registro.');
        }else{
            $ele=Papele::where('id',$id)->select('id','valor','fecha')->first();
            $valor=$this->paradeta->porcentaje*$ele->valor/100;
            Calculo::create([
                    'papele_id'     =>$id,
                    'parametro_id'  =>$this->paradeta->id,
                    'cliente_id'    =>$this->elegido->id,
                    'user_id'       =>Auth::user()->id,
                    'valor'         =>$valor,
                    'fecha'         =>$ele->fecha,
            ]);

            $this->totalizar();
        }

    }

    public function eliminar($id){
        Calculo::where('id',$id)
                ->delete();

        $this->totalizar();
    }

    public function totalizar(){
        $this->valor=Calculo::where('status',1)
                            ->where('parametro_id',$this->paradeta->id)
                            ->where('cliente_id',$this->elegido->id)
                            ->where('user_id',Auth::user()->id)
                            ->get();
    }

    public function eliminarregistro($id){
        $this->borrareg=$id;
        $this->is_borraregistro=true;
    }

    public function eliminarconfirma($id){
        Papele::where('id',$id)->delete();
        $this->reset('borrareg','is_borraregistro');
        $this->dispatch('alerta', name:'Se elimino el registro correctamente.');
    }

    public function confirmar(){
        $this->is_confirma=true;
    }

    public function finalizar(){
        foreach ($this->valor as $value) {
            $reg=Papele::where('id',$value->papele_id)->first();
                    $reg->update([
                        'calculos'=>$reg->calculos+1,
                    ]);
        }

        Calculo::where('status',1)
                ->where('parametro_id',$this->paradeta->id)
                ->where('cliente_id',$this->elegido->id)
                ->where('user_id',Auth::user()->id)
                ->update([
                    'status'=>2,
                    'fecha_calculo'=>now(),
                ]);

        $this->dispatch('alerta', name:'Se cargaron correctamente los calculos.');
        $this->reset('paradeta','valor','param');
    }

    private function cargarch(){
        $row = 0;

        if(($handle = fopen(Storage::path($this->ruta), 'r')) !== false) {

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {

                    Papele::create([
                        'cliente_id'    =>$this->elegido->id,
                        'user_id'       =>Auth::user()->id,
                        'fecha'         =>$data[0],
                        'documento'     =>strtolower($data[1]),
                        'numero'        =>$data[2],
                        'destinatario'  =>strtolower($data[3]),
                        'documento_dest'=>$data[4],
                        'valor'         =>$data[5],
                        'iva'           =>$data[6],
                        'total'         =>$data[7],
                    ]);

                }catch(Exception $exception){
                    //Log::info('Line: ' . $row . ' '.$this->ruta.' with error: ' . $exception->getMessage().' real: '.$data[1]);
                    $errorMessage = $exception->getMessage();
                    $cleanMessage = preg_replace("/\(Connection:.*$/", "", $errorMessage);
                    $error=$cleanMessage.' numero de línea: '.$row;
                    array_push($this->crterrores,$error);
                }
            }

            fclose($handle);

            // Elimina el archivo después de procesarlo
            Storage::delete($this->ruta);
            Log::info('Archivo eliminado: ' . $this->ruta);
        } else {
            Log::error('No se pudo abrir el archivo en la ruta: ' . Storage::path($this->ruta));
        }

        if(count($this->crterrores)>0){
            $this->dispatch('alerta', name:'Se presentaron errores al cargar, valide los datos');
            $this->is_errores=true;
        }else{
            // Notificación
            $this->dispatch('alerta', name:'Se ha cargado correctamente el documento');
        }

        $this->resetFields();
    }

    private function papeles(){
        return Papele::where('cliente_id', $this->elegido->id)
                        ->buscar($this->buscaregistro)
                        ->fecha($this->filtrofechagest)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }

    private function parametros(){
        return Parametro::where('status', true)
                            ->where('tipo','>',2)
                            ->orderBy('name','ASC')
                            ->get();
    }

    public function render()
    {
        return view('livewire.gestion.papeles.papeles-trabajo',[
            'papeles'   =>$this->papeles(),
            'parametros'=>$this->parametros()
        ]);
    }
}
