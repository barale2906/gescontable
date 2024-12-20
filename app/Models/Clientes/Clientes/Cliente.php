<?php

namespace App\Models\Clientes\Clientes;

use App\Models\Gestion\Asignacion;
use App\Models\Gestion\Calculo;
use App\Models\Gestion\Gestion;
use App\Models\Gestion\Papele;
use App\Models\Gestion\Programacion;
use App\Models\Gestion\Soporte;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relaciones uno a muchos
    public function soportes():HasMany
    {
        return $this->hasMany(Soporte::class);
    }

    public function asignaciones():HasMany
    {
        return $this->hasMany(Asignacion::class);
    }

    public function programaciones():HasMany
    {
        return $this->hasMany(Programacion::class);
    }

    public function gestiones():HasMany
    {
        return $this->hasMany(Gestion::class);
    }

    public function papeles():HasMany
    {
        return $this->hasMany(Papele::class);
    }

    public function calculos():HasMany
    {
        return $this->hasMany(Calculo::class);
    }

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('name', 'like', "%".$item."%")
                    ->orwhere('nit', 'like', "%".$item."%");
        });
    }
}
