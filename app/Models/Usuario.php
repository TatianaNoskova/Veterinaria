<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombre',
        'apellido',
        'password',
        'dni',
        'telefono',
        'correo_electronico',
        'direccion',
        'matricula',
        'especialidad',
        'rol',
    ];

    protected $hidden = ['password'];

    // Cliente - mascotas
    public function mascotas()
    {
        return $this->belongsToMany(Mascota::class, 'usuario_mascota', 'id_usuario', 'id_mascota')
                    ->withTimestamps();
    }

    // Veterinario - mascotas
    public function pacientes()
    {
        return $this->belongsToMany(Mascota::class, 'veterinario_mascota', 'id_veterinario', 'id_mascota')
                    ->withPivot('fecha_asignacion', 'activo')
                    ->withTimestamps();
    }
}

