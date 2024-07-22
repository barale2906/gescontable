<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('name', 'like', "%".$item."%")
                    ->orwhere('tipo', 'like', "%".$item."%");
        });
    }
}
