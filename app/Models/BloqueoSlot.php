<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloqueoSlot extends Model
{
    protected $table = 'bloqueos_de_slots';

    protected $fillable = [
        'id_veterinario',
        'fecha_hora',
    ];

    public function veterinario()
    {
        return $this->belongsTo(Usuario::class, 'id_veterinario');
    }
}

