<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUsuarioController;
use App\Http\Controllers\AdminEmpleadoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EmpleadoMascotaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMascotaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\EmpleadoFacturaController;
use App\Http\Controllers\UserTurnoController;
use App\Http\Controllers\EmpleadoHorarioController;
use App\Http\Controllers\EmpleadoTurnoController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\AdminEstadisticasController;



Route::get('/', function () {
    return view('index');
})->name('index');


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/registro', [RegisteredUserController::class, 'create'])->name('registro');
    Route::post('/registro', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::post('/impersonate/stop', [ImpersonateController::class, 'stop'])->name('impersonate.stop');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Gestión de usuarios
    Route::get('/usuarios', [AdminUsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios', [AdminUsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{id}/edit', [AdminUsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [AdminUsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [AdminUsuarioController::class, 'destroy'])->name('usuarios.destroy');

    // Gestión de empleados
    Route::get('/empleados', [AdminEmpleadoController::class, 'index'])->name('empleados.index');
    Route::post('/empleados', [AdminEmpleadoController::class, 'store'])->name('empleados.store');
    Route::get('/empleados/{id}/edit', [AdminEmpleadoController::class, 'edit'])->name('empleados.edit');
    Route::put('/empleados/{id}', [AdminEmpleadoController::class, 'update'])->name('empleados.update');
    Route::delete('/empleados/{id}', [AdminEmpleadoController::class, 'destroy'])->name('empleados.destroy');
    
    // Estadistica
    Route::get('/estadisticas', [AdminEstadisticasController::class, 'index'])->name('estadisticas.index');

    // Impersonate
    Route::post('/impersonate/{id}', [ImpersonateController::class, 'start'])->name('impersonate.start');
  
    Route::get('/ingresar_como', [ImpersonateController::class, 'show'])->name('ingresar_como')->middleware('auth', 'role:admin');


   
});


Route::middleware(['auth', 'role:empleado'])->prefix('empleado')->name('empleado.')->group(function () {
    Route::get('/dashboard', [EmpleadoController::class, 'index'])->name('dashboard');

 // Gestion de mascotas

    Route::get('/mascotas', [EmpleadoMascotaController::class, 'index'])->name('mascotas.index');
    Route::post('/mascotas', [EmpleadoMascotaController::class, 'store'])->name('mascotas.store');
    
    Route::post('/mascotas/agregar', [EmpleadoMascotaController::class, 'agregarMascota'])->name('mascota.agregar');
    Route::get('/mascotas/{id}/edit', [EmpleadoMascotaController::class, 'edit'])->name('mascota.edit');
    Route::put('/mascotas/{id}', [EmpleadoMascotaController::class, 'update'])->name('mascotas.update');

    Route::delete('/mascotas/{id}', [EmpleadoMascotaController::class, 'destroy'])->name('mascota.destroy');
    Route::get('/mascotas/{id}/historia-nueva', [EmpleadoMascotaController::class, 'historiaNueva'])->name('mascota.historia_nueva');
    Route::post('/mascotas/{id}/historia-nueva', [EmpleadoMascotaController::class, 'storeDiagnostico'])->name('mascota.store_historia_nueva');
    Route::get('mascotas/{id}/historial', [EmpleadoMascotaController::class, 'historial'])->name('mascota_historial');

    //Facturas:
    Route::get('/facturas', [EmpleadoFacturaController::class, 'index'])->name('facturas.index');
    Route::get('/factura/crear', [EmpleadoFacturaController::class, 'create'])->name('factura.create');
    Route::post('/factura', [EmpleadoFacturaController::class, 'store'])->name('facturas.store');
    Route::get('/factura/{id}/editar', [EmpleadoFacturaController::class, 'edit'])->name('factura.edit');
    Route::put('/factura/{id}', [EmpleadoFacturaController::class, 'update'])->name('factura.update');
    Route::get('/factura/{id}/ver', [EmpleadoFacturaController::class, 'show'])->name('factura.show');
    Route::put('/factura/{id}/estado', [EmpleadoFacturaController::class, 'updateStatus'])->name('factura.update_estado');


    Route::delete('/factura/{id}', [EmpleadoFacturaController::class, 'destroy'])->name('factura.destroy');
    
    // Horario
    Route::get('/horario', [EmpleadoHorarioController::class, 'index'])->name('horario.index');
    Route::get('/turno/crear', [EmpleadoTurnoController::class, 'create'])->name('turno.create');
    Route::post('/turno/store', [EmpleadoTurnoController::class, 'store'])->name('turno.store');
    Route::post('/horario/bloquear', [EmpleadoHorarioController::class, 'bloquearSlot'])->name('slot.bloquear');

   

});

Route::middleware(['auth', 'role:cliente'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::get('/perfil', [ClienteController::class, 'index'])->name('perfil.index');
    Route::post('/perfil/actualizar', [ClienteController::class, 'actualizarPerfil'])->name('perfil.actualizar');
    Route::delete('/perfil/eliminar', [ClienteController::class, 'eliminarCuenta'])->name('perfil.eliminar');
    Route::get('/mascota/crear', [UserMascotaController::class, 'create'])->name('agregar_mascota');
    Route::post('/mascota', [UserMascotaController::class, 'store'])->name('mascota.store');
    Route::get('/mascota/{id}/editar', [UserMascotaController::class, 'edit'])->name('mascota.editar');
    Route::put('/mascota/{id}', [UserMascotaController::class, 'update'])->name('mascota.update');
    Route::delete('/mascota/{id}', [UserMascotaController::class, 'destroy'])->name('mascota.eliminar');
    Route::get('/facturas', [FacturaController::class, 'index'])->name('facturas.index');
    Route::middleware('auth')->get('/mascotas', [UserMascotaController::class, 'list'])->name('mascotas.list');
    Route::get('/mascotas/{id}', [UserMascotaController::class, 'showHistorial'])->name('historial');
    
    Route::get('/turnos', [UserTurnoController::class, 'index'])->name('turnos.index');
    Route::get('turnos/buscar', [UserTurnoController::class, 'buscar'])->name('turno.buscar');
    Route::post('turno/reservar/{fechaHora}', [UserTurnoController::class, 'reservar'])->name('turno.reservar');
    Route::delete('/turnos/{turno}', [UserTurnoController::class, 'cancelar'])->name('turno.cancelar');



    
    });

Route::get('/db-check', function () {
    try {
        return 'Conexión exitosa: ' . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return 'Error en conexión: ' . $e->getMessage();
    }
    
});

