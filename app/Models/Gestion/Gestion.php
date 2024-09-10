<?php

namespace App\Models\Gestion;

use App\Models\Clientes\Clientes\Cliente;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gestion extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relaciones uno a muchos inversa
    public function cliente():BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function usuario():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeBuscar($query, $item){
        $query->when($item ?? null, function($query, $item){
            $query->where('observaciones', 'like', "%".$item."%")
                    ->orWhere('name', 'like', "%".$item."%");
        });
    }
}
