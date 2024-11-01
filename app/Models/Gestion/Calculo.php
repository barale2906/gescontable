<?php

namespace App\Models\Gestion;

use App\Models\Clientes\Clientes\Cliente;
use App\Models\Configuracion\Parametro;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calculo extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relaciones uno a muchos inversa
    public function papel():BelongsTo
    {
        return $this->belongsTo(Papele::class);
    }

    public function parametro():BelongsTo
    {
        return $this->belongsTo(Parametro::class);
    }

    public function cliente():BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeParametro($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('parametro_id', $item);
        });
    }

    public function scopeFecha($query, $lapso){
        $query->when($lapso ?? null, function($query, $lapso){
            $fecha1=Carbon::parse($lapso[0]);
            $fecha2=Carbon::parse($lapso[1]);
            $fecha2->addSeconds(86399);
            $query->whereBetween('fecha', [$fecha1 , $fecha2]);
        });
    }
}
