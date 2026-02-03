<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Historial Médico</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user.css') }}">
</head>
<body>

  <!-- Header común -->
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
        Tel: 011 5032-0076<br>
        Lun-Vie: 10–18hs | Sáb: 10–14hs</p>
      </div> 
    </div>
  </header>

  

  <!-- Cabecera con nombre mascota -->
  <div class="user-header">
    <div class="user-header-left">
    <a href="{{ route('user.dashboard') }}">
      <img src="{{ asset('img/usuario.png') }}" alt="Ícono usuario" class="user-icon">
    </a>
  </div>
    <div class="user-header-center">
      <h1>📋 Historial médico - {{ $mascota->nombre }}</h1>
      <p>Dueño (-s): @foreach ($duenos as $dueno)
        {{ $dueno->nombre }} {{ $dueno->apellido }}@if(!$loop->last), @endif
    @endforeach</p>
    </div>
    <a href="{{ route('user.mascotas.list') }}" class="logout">Volver</a>
  </div>

  <main class="user-perfil container">
    <section class="historial-lista">
      <h2>Consultas médicas</h2>
      <table>
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Veterinario</th>
            <!-- <th>Motivo</th> -->
            <th>Diagnóstico</th>
            <th>Tratamiento/Receta</th>
          </tr>
        </thead>
         <tbody>
        @foreach ($mascota->diagnosticos as $diagnostico)
            <tr>
                <!-- Выводим дату диагноза -->
                <td>{{ \Carbon\Carbon::parse($diagnostico->fecha)->format('d/m/Y') }}</td>

                <td>{{ $diagnostico->turno->veterinario->nombre . ' ' . $diagnostico->turno->veterinario->apellido ?? 'No disponible' }}</td>

                <!-- Выводим описание диагноза -->
                <td>{{ $diagnostico->descripcion ?? 'No disponible' }}</td>

                <!-- Выводим лечение/рецепт -->
                <td>{{ $diagnostico->receta ?? 'No disponible' }}</td>
            </tr>
        @endforeach
    </tbody>
      </table>
    </section>
  </main>

</body>
</html>
