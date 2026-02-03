<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicio';

    protected $primaryKey = 'id_servicio';

    protected $fillable = ['nombre', 'precio', 'tipo'];

    
    public function facturas()
{
    return $this->belongsToMany(
        Factura::class,
        'factura_servicio',
        'id_servicio',   
        'id_factura'    
    )->withPivot('cantidad', 'precio', 'subtotal');
}
}


