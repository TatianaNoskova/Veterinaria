<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Historial médico</title>
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
          <a href="{{ route('empleado.dashboard') }}">
          <img src="{{ asset('img/veterinario.png') }}" alt="Vete Icono" class="vete-icon"></a>
        </div>
        
        <div class="empleado-header-center">
          <div class="empleado-header-text">
            <!-- Aquí irá el nombre de la mascota dinámicamente -->
            <h1>Historial médico - {{ $mascota->nombre }}</h1>
            <!-- Aquí irá el nombre del dueño dinámicamente -->
            <p>Dueño (-s): @foreach($dueños as $dueño)
            {{ $dueño->nombre }} {{ $dueño->apellido }}
            @if(!$loop->last), @endif 
        @endforeach</p>
          </div>
        </div>
      
        <div class="empleado-header-right">
          <a href="{{ route('empleado.mascotas.index') }}" class="logout" title="Volver al panel de veterinario">Volver</a>
        </div>
    </div>

 <main class="vet-mascota container">

  <!-- Sección de historial de consultas -->
  <section class="historial-lista mascotas-registrados">
    <h2>Consultas anteriores</h2>

    <!-- Tabla con consultas médicas anteriores -->
    <div class="tabla-mascotas">
      <table>
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Motivo/Diágnosis</th>
            <th>Veterinario</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($mascota->diagnosticos as $diagnostico)
          <tr>
            <td>{{ \Carbon\Carbon::parse($diagnostico->fecha)->format('d/m/Y') }}</td>
            <td>{{ $diagnostico->descripcion }}</td>
            <td>{{ $diagnostico->turno->veterinario->nombre }} {{ $diagnostico->turno->veterinario->apellido }}</td>
            <td>
              <a href="#" class="btn-action" title="Ver detalles">🔍</a>
              
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Botón para agregar nueva consulta -->
    <div class="boton-nuevo" style="margin-top: 1.5rem;">
      <a href="{{ route('empleado.mascota.historia_nueva', $mascota->id_mascota) }}" class="button new-history-button">➕ Nueva entrada médica</a>
    </div>
  </section>

</main>
</body>
</html>



