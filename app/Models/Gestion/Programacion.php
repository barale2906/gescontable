<?php

namespace App\Models\Gestion;

use App\Models\Clientes\Clientes\Cliente;
use App\Models\Configuracion\Parametro;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Programacion extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    //Relaciones uno a muchos inversa
    public function cliente():BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function parametro():BelongsTo
    {
        return $this->belongsTo(Parametro::class);
    }

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('observaciones', 'like', "%".$item."%")
                    ->orwhere('name', 'like', "%".$item."%");
        });
    }

    public function scopeCliente($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('cliente_id', $item);
        });
    }

    public function scopeParametro($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('parametro_id', $item);
        });
    }

    public function scopeInicia($query, $lapso){
        $query->when($lapso ?? null, function($query, $lapso){
            $fecha1=Carbon::parse($lapso[0]);
            $fecha2=Carbon::parse($lapso[1]);
            $query->whereBetween('inicio', [$fecha1 , $fecha2]);
        });
    }
}
