<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'factura';
    protected $primaryKey = 'id_factura';
    protected $fillable = ['total', 'fecha', 'estado', 'fecha_pagado'];

    public function servicios()
{
    return $this->belongsToMany(
        Servicio::class,
        'factura_servicio',
        'id_factura',    
        'id_servicio'   
    )->withPivot('cantidad', 'precio', 'subtotal');
}
    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'id_mascota');
    }

     public function turno()
    {
        return $this->belongsTo(Turno::class, 'id_turno');
    }

    
}


