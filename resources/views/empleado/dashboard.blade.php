<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Veterinario</title>
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
      <img src="{{ asset('img/veterinario.png') }}" alt="Vet Icono" class="empleado-icon">
    </div>
  
    <div class="empleado-header-center">
      <div class="empleado-header-text">
        <h1>Bienvenido, {{ $usuario->nombre }} {{ $usuario->apellido }} !</h1>
        <p>Gestión general de pacientes y facturación</p>
      </div>
    </div>
  
    <div class="empleado-header-right">
      <form method="POST" action="{{ route('logout') }}" style="display: inline;">
    @csrf
    <button type="submit" class="logout" title="Volver al panel index">Logout</button>
</form>
    </div>
</div>


<main class="vet-dashboard">
    <section class="card-grid">

      <!-- Mascotas -->
      <a href="{{ route ('empleado.mascotas.index') }}" class="card">
        <h2>🐾 Mascotas</h2>
        <p>Gestiona mascotas</p>
      </a>

            <!-- Facturación -->
      <a href="{{ route('empleado.facturas.index') }}" class="card">
        <h2>💰 Facturación</h2>
        <p>Administra facturas</p>
      </a>

      <!-- Horario -->
      <a href="{{ route('empleado.horario.index') }}" class="card">
        <h2>📅 Horario </h2>
        <p>Consulta su horario</p>
      </a>

      <!-- Historial u otras funciones futuras 
      <a href="vet_historial_todos.html" class="card">
        <h2>🩺 Historial</h2>
        <p>Consulta tratamientos anteriores</p>-->
      </a>

    </section>
  </main>

</body>
</html>


    
  
    
  </main>
  
</body>
</html>