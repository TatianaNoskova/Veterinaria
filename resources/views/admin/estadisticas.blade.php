<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadística</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
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

   <div class="admin-header">
        <div class="admin-header-left">
          <a href="{{ route('admin.dashboard') }}">
          <img src="{{ asset('img/admin.png') }}" alt="Admin Icono" class="admin-icon">
        </div>
        </a>
        <div class="admin-header-center">
          <div class="admin-header-text">
            
            <h1>Estadisticas Administrativas</h1>
          </div>
        </div>
      
        <div class="admin-header-right">
          <a href="{{ route('admin.dashboard') }}" class="logout" title="Volver al panel de administrador">Volver</a>
        </div>
    </div>

   <main class="admin-reportes">

  

  <form class="date-filter-form" method="GET" action="{{ route('admin.estadisticas.index') }}">
    <label for="fecha_inicio">Desde:</label>
    <input type="date" id="fecha_inicio" name="fecha_inicio" required>

    <label for="fecha_fin">Hasta:</label>
    <input type="date" id="fecha_fin" name="fecha_fin" required>

    <button type="submit">Ver estadísticas</button>
  </form>

  <!-- 1 -->
  @if($fechaInicio && $fechaFin)
  <section class="stats-block">
    <h2>🩺 Diagnósticos más frecuentes del {{ $fechaInicio }} al {{ $fechaFin }}</h2>
    <ul>
      @forelse ($diagnosticos as $diag)
        <li>{{ $diag->descripcion }} — {{ $diag->total }} casos</li>

      @empty
        <li>No hay diagnósticos en este período.</li>
      @endforelse
    </ul>
  </section>
@endif


  <!-- 2 -->
  @if($fechaInicio && $fechaFin)
  <section class="stats-block">
    <h2>💉 Servicios más solicitados</h2>
    <ul>
        @foreach($servicios as $servicio)
            <li>{{ $servicio->nombre }} ({{ $servicio->total }})</li>
        @endforeach
    </ul>
</section>
@endif

  <!-- 3 -->
 <section class="stats-block">
  <h2>💰 Total facturado / pagado</h2>
  <div class="resultado-facturas">
    <p><strong>Total facturado:</strong> ${{ number_format($totalFacturado, 2) }}</p>
    <p><strong>Total pagado:</strong> ${{ number_format($totalPagado, 2) }}</p>
  </div>
</section>



  <!-- 4 -->
  <section class="stats-block">
    <h2>📋 Estado de facturas</h2>
    <ul>
      <li>Facturas pagadas: {{ $facturasPagadas }}</li>
      <li>Facturas pendientes: {{ $facturasPendientes }}</li>
    </ul>
</section>


    <!-- 6 -->
  <section class="stats-block">
    <h2>👨‍⚕️ Consultas por veterinario</h2>
    <div class="bar-chart">
        @foreach($consultasPorVet as $vet)
            @php
                
                $max = $consultasPorVet->max('total_consultas') ?: 1;
                $widthPercent = intval(($vet->total_consultas / $max) * 80);
            @endphp
            <div class="bar" style="--width: {{ $widthPercent }}%">
                {{ $vet->nombre }} {{ $vet->apellido }} — {{ $vet->total_consultas }} consultas
            </div>
        @endforeach
    </div>
</section>


</main> 
  
    
  
</body>
</html>

