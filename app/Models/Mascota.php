<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    use HasFactory;

    protected $table = 'mascota';
    protected $primaryKey = 'id_mascota';

    protected $fillable = [
        'nombre',
        'especie',
        'raza',
        'edad',
        'sexo',
    ];

    // Relacion clientes - mascotas
    public function clientes()
    {
        return $this->belongsToMany(Usuario::class, 'usuario_mascota', 'id_mascota', 'id_usuario')
                    ->withTimestamps();
    }

    // Relacion veterinarios - mascotas
    public function veterinarios()
    {
        return $this->belongsToMany(Usuario::class, 'veterinario_mascota', 'id_mascota', 'id_veterinario')
                    ->withPivot('fecha_asignacion', 'activo')
                    ->withTimestamps();
    }

    public function diagnosticos()
    {
        return $this->hasMany(Diagnostico::class, 'id_mascota');
    }

    public function turnos()
    {
        return $this->hasMany(Turno::class, 'id_mascota');
    }

    public function factura()
    {
        return $this->hasMany(Factura::class, 'mascota_id');
    }
}

    

