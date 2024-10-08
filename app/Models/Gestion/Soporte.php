<?php

namespace App\Models\Gestion;

use App\Models\Clientes\Clientes\Cliente;
use App\Models\Configuracion\Parametro;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Soporte extends Model
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

    public function cargado():BelongsTo //Usuario que carga el soporte
    {
        return $this->belongsTo(User::class);
    }
}
