<?php

namespace App\Models\Clientes\Clientes;

use App\Models\Gestion\Soporte;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relaciones uno a muchos
    public function parametros():HasMany
    {
        return $this->hasMany(Soporte::class);
    }

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('name', 'like', "%".$item."%")
                    ->orwhere('nit', 'like', "%".$item."%");
        });
    }
}
