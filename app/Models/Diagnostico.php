<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    use HasFactory;

    protected $table = 'diagnostico';

    protected $fillable = [
        'id_mascota',
        'id_turno',
        'fecha',
        'descripcion',
        'receta',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'id_mascota');
    }

    public function turno()
    {
        return $this->belongsTo(Turno::class, 'id_turno'); 
    }

}

