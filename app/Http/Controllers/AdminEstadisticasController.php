<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminEstadisticasController extends Controller
{
public function index(Request $request)
{
    $fechaInicio = $request->input('fecha_inicio');
    $fechaFin = $request->input('fecha_fin');

    $diagnosticos = [];
    $servicios = collect();
    $totalFacturado = 0;
    $totalPagado = 0;
    $facturasPagadas = 0;
    $facturasPendientes = 0;
    $consultasPorVet = collect();

    if ($fechaInicio && $fechaFin) {
        // Diagnósticos
        $diagnosticos = DB::table('diagnostico')
            ->select('descripcion', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->groupBy('descripcion')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Servicios más solicitados
        $servicios = DB::table('factura_servicio')
            ->join('servicio', 'factura_servicio.id_servicio', '=', 'servicio.id_servicio')
            ->join('factura', 'factura.id_factura', '=', 'factura_servicio.id_factura')
            ->whereBetween('factura.fecha', [$fechaInicio, $fechaFin])
            ->select('servicio.nombre', DB::raw('SUM(factura_servicio.cantidad) as total'))
            ->groupBy('servicio.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Total facturado
        $totalFacturado = DB::table('factura')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->sum('total');

        // Total pagado
        $totalPagado = DB::table('factura')
            ->where('estado', 'pagado')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->sum('total');

        // Estado de facturas
        $facturasPagadas = DB::table('factura')
            ->where('estado', 'pagado')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->count();

        $facturasPendientes = DB::table('factura')
            ->where('estado', 'pendiente')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->count();

        // Consultas por veterinario
        $consultasPorVet = DB::table('usuario')
            ->leftJoin('turno', function($join) use ($fechaInicio, $fechaFin) {
                $join->on('usuario.id_usuario', '=', 'turno.id_veterinario')
                     ->where('turno.estado', '=', 'completado')
                     ->whereBetween('turno.fecha_hora', [$fechaInicio, $fechaFin]);
            })
            ->where('usuario.rol', 'empleado')
            ->select('usuario.nombre', 'usuario.apellido', DB::raw('COUNT(turno.id_turno) as total_consultas'))
            ->groupBy('usuario.id_usuario', 'usuario.nombre', 'usuario.apellido')
            ->orderByDesc('total_consultas')
            ->limit(3)
            ->get();
    }

    return view('admin.estadisticas', compact(
        'diagnosticos',
        'servicios',
        'totalFacturado',
        'totalPagado',
        'facturasPagadas',
        'facturasPendientes',
        'consultasPorVet',
        'fechaInicio',
        'fechaFin'
    ));
}

}
