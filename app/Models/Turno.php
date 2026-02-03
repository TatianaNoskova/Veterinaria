<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $table = 'turno';

    protected $primaryKey = 'id_turno';

    protected $fillable = [
        'id_mascota',
        'id_veterinario',
        'fecha_hora',
        'motivo',
        'estado',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($turno) {
            if ($turno->factura && $turno->factura->estado !== 'pagado') {
                $turno->factura->delete();
            }
        });
    }

    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'id_mascota');
    }

    public function veterinario()
    {
        return $this->belongsTo(Usuario::class, 'id_veterinario');
    }

    public function diagnostico()
    {
        return $this->hasOne(Diagnostico::class, 'id_turno');
    }

    public function factura()
    {
        return $this->hasOne(Factura::class, 'id_turno');
    }
}
