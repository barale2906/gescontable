<?php

namespace App\Models\Gestion;

use App\Models\Clientes\Clientes\Cliente;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Papele extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relaciones uno a muchos
    public function calculos():HasMany
    {
        return $this->hasMany(Calculo::class);
    }

    //Relaciones uno a muchos inversa
    public function cliente():BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
