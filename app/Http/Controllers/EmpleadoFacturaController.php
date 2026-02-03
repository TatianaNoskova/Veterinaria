<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
use App\Models\Mascota;
use App\Models\Factura;
use App\Models\Servicio;
use App\Models\Turno;

class EmpleadoFacturaController extends Controller
{
public function index(Request $request)
{
    $veterinario = auth()->user();

    
    $clientes = Usuario::where('rol', 'cliente')
        ->whereHas('mascotas.turnos', function ($query) use ($veterinario) {
            $query->where('id_veterinario', $veterinario->id_usuario)
                  ->where('estado', '!=', 'cancelado');
                
        })
        ->get();

    $cliente = null;
    $mascotas = collect();
    $turnos = collect();
    $mascotaSeleccionada = null;
    $turnoSeleccionado = null;

    
    if ($request->has('cliente')) {
        $cliente = Usuario::find($request->cliente);

        
        $mascotas = $cliente->mascotas()
            ->whereHas('turnos', function ($query) use ($veterinario) {
                $query->where('id_veterinario', $veterinario->id_usuario)
                      ->where('estado', '!=', 'cancelado');
                      
            })
            ->get();

        
        if ($request->has('mascota')) {
            $mascotaSeleccionada = Mascota::find($request->mascota);

            
            $turnos = Turno::where('id_mascota', $mascotaSeleccionada->id_mascota)
                ->where('id_veterinario', $veterinario->id_usuario)
                ->where('estado', '!=', 'cancelado')
              
                ->orderBy('fecha_hora', 'desc')
                ->get();

            
            if ($request->has('turno')) {
                $turnoSeleccionado = Turno::find($request->turno);

               
            }
        }
    }

    $servicios = Servicio::all();
    $facturas = Factura::with([
        'turno.veterinario',
        'turno.mascota.clientes'
    ])
    ->whereHas('turno', function ($query) use ($veterinario) {
        $query->where('id_veterinario', $veterinario->id_usuario);
    })
    ->orderBy('fecha', 'desc')
    ->get();


    return view('empleado.facturas', compact(
        'clientes',
        'cliente',
        'mascotas',
        'turnos',
        'turnoSeleccionado',
        'mascotaSeleccionada',
        'servicios',
        'facturas'
    ));
}



    public function store(Request $request)
{
    // Валидация
    if (!$request->has('turno_id') || !$request->has('servicios')) {
        return redirect()->back()->with('error', 'Debe seleccionar un turno y al menos un servicio.');
    }

    $turno = Turno::find($request->turno_id);

    if (!$turno || $turno->estado === 'cancelado') {
        return redirect()->back()->with('error', 'El turno no es válido o está cancelado.');
    }

    $mascota = $turno->mascota;

    if (!$mascota) {
        return redirect()->back()->with('error', 'No se encontró la mascota asociada al turno.');
    }

    
    $total = 0;
    $detalles = [];

    foreach ($request->servicios as $servicioId) {
        $servicio = Servicio::where('id_servicio', $servicioId)->first();

        if ($servicio) {
            $subtotal = $servicio->precio;
            $total += $subtotal;

            $detalles[] = [
                'id_servicio' => $servicio->id_servicio,
                'precio' => $servicio->precio,
                'cantidad' => 1,
                'subtotal' => $subtotal,
            ];
        }
    }

    if (empty($detalles)) {
        return redirect()->back()->with('error', 'No se encontraron servicios válidos.');
    }

    
    $factura = new Factura();
    $factura->fecha = now();
    $factura->estado = 'pendiente';
    $factura->id_turno = $turno->id_turno;
    $factura->total = $total;
    $factura->save();

    
    foreach ($detalles as $item) {
        DB::table('factura_servicio')->insert([
            'id_factura' => $factura->id_factura,
            'id_servicio' => $item['id_servicio'],
            'precio' => $item['precio'],
            'cantidad' => $item['cantidad'],
            'subtotal' => $item['subtotal'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return redirect()->route('empleado.facturas.index')->with('success', 'Factura creada exitosamente.');
}

public function edit($id)
{
    $factura = Factura::with(['turno.mascota.clientes', 'servicios'])->findOrFail($id);
    $servicios = Servicio::all(); 

    return view('empleado.factura_edit', compact('factura', 'servicios'));
}

public function update(Request $request, $id)
{
    $factura = Factura::findOrFail($id);

    
    $factura->fecha = $request->input('fecha');
    $factura->estado = $request->input('estado');

    
    $serviciosSeleccionados = $request->input('servicios', []); 
    $sincronizarServicios = [];

    foreach ($serviciosSeleccionados as $id_servicio) {
        $servicio = Servicio::find($id_servicio);
        if ($servicio) {
            $precio = $servicio->precio;
            $cantidad = 1;
            $subtotal = $precio * $cantidad;

            $sincronizarServicios[$id_servicio] = [
                'precio' => $precio,
                'cantidad' => $cantidad,
                'subtotal' => $subtotal
            ];
        }
    }

   
    $factura->servicios()->sync($sincronizarServicios);

    
    $nuevoTotal = array_sum(array_column($sincronizarServicios, 'subtotal'));
    $factura->total = $nuevoTotal;

    $factura->save();

    return redirect()->route('empleado.facturas.index')
                     ->with('success', 'Factura actualizada correctamente.');
}

public function show($id)
{
    $factura = Factura::with(['servicios', 'turno.mascota.clientes'])->findOrFail($id);

    return view('empleado.factura_show', compact('factura'));
}


public function updateStatus(Request $request, $id)
{
    $request->validate([
        'estado' => 'required|in:pendiente,pagado',
    ]);

    $factura = Factura::findOrFail($id);
    $factura->estado = $request->input('estado');
    $factura->save();

    return redirect()->route('empleado.facturas.index')->with('success', 'Estado actualizado correctamente.');
}




public function destroy($id)
{
    $factura = Factura::findOrFail($id);

    
   

    $factura->delete();

    return redirect()->route('empleado.facturas.index')
                     ->with('success', 'Factura eliminada correctamente.');
}

}
