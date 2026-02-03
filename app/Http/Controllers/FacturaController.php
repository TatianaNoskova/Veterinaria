<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    public function index()
    {
        
        $usuario = auth()->user();

        $mascotasIds = $usuario->mascotas->pluck('id_mascota');

         $turnosIds = DB::table('turno')
            ->whereIn('id_mascota', $mascotasIds)
            ->pluck('id_turno');

         $facturas = Factura::whereIn('id_turno', $turnosIds)
            ->where('estado', 'pendiente')
            ->get();

        
        $totalDeudaPendiente = $facturas->sum('total'); 

        
        return view('user.facturas', compact('facturas', 'totalDeudaPendiente'));
    }

    

       
        
}


