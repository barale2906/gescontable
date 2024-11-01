<?php

namespace App\Models\Configuracion;

use App\Models\Gestion\Calculo;
use App\Models\Gestion\Programacion;
use App\Models\Gestion\Soporte;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parametro extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relaciones uno a muchos
    public function soportes():HasMany
    {
        return $this->hasMany(Soporte::class);
    }

    public function programaciones():HasMany
    {
        return $this->hasMany(Programacion::class);
    }

    public function calculos():HasMany
    {
        return $this->hasMany(Calculo::class);
    }


    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('name', 'like', "%".$item."%")
                    ->orwhere('tipo', 'like', "%".$item."%");
        });
    }
}
