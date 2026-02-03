<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de mascotas</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vete.css') }}">
</head>
<body>

    <header>
    <div class="top-banner"> 
      <div class="logo">
        <a href="{{ route('index') }}">
          <img src="{{ asset('img/logovete.png') }}" alt="Logo Veterinaria">
        </a>
        <div> 
          <h1>Amigos son los amigos</h1>
          <p>VETERINARIA</p>
        </div>
      </div> 
      <div class="contact-info"> 
        <p>Av. Corrientes 2037<br>
        CABA - C1001<br>
        Teléfono: 011 5032-0076<br>
        Lunes a Viernes - 10 a 18hrs<br>
        Sábado - 10 a 14hrs</p>
      </div> 
    </div>
  </header>

   <div class="empleado-header">
        <div class="empleado-header-left">
          <a href="{{ route ('empleado.dashboard') }}">
          <img src="{{ asset('img/veterinario.png') }}" alt="Vete Icono" class="vete-icon">
        </div>
        </a>
        <div class="empleado-header-center">
          <div class="empleado-header-text">
            
            <h1>Modificar factura no.{{ $factura->id_factura }}</h1>
          </div>
        </div>
      
        <div class="empleado-header-right">
          <a href="{{ route('empleado.facturas.index') }}" class="logout" title="Volver a facturas">Volver</a>
        </div>
    </div>

<main class="vet-mascota container">
  <section class="form-section">









<h2>Factura Nº {{ $factura->id_factura }}</h2>

<p><strong>Cliente:</strong>
   {{ optional($factura->turno->mascota->clientes->first())->nombre }} {{ optional($factura->turno->mascota->clientes->first())->apellido }}
</p>

<p><strong>Mascota:</strong> {{ $factura->turno->mascota->nombre }}</p>
<p><strong>Motivo:</strong> {{ $factura->turno->motivo }}</p>
<p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}</p>
<p><strong>Servicios incluidos:</strong></p>
<ul>
  @foreach ($factura->servicios as $servicio)
    <li>
      {{ $servicio->nombre }} : ${{ number_format($servicio->pivot->subtotal, 2) }} 
    </li>
  @endforeach
  @if($factura->servicios->isEmpty())
    <li>No hay servicios asociados a esta factura.</li>
  @endif
</ul>
<p><strong>Total:</strong> ${{ number_format($factura->total, 2) }}</p>

<h3>Cambiar estado:</h3>
<form action="{{ route('empleado.factura.update_estado', $factura->id_factura) }}" method="POST">
   
    @csrf
    @method('PUT')

    <select name="estado" required>
        <option value="pendiente" {{ $factura->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
        <option value="pagado" {{ $factura->estado === 'pagado' ? 'selected' : '' }}>Pagado</option>
    </select>

    <button type="submit" class="boton-formulario">Actualizar estado</button>
</form>
