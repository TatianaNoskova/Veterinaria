<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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
         
          <img src="{{ asset('img/admin.png') }}" alt="Admin Icono" class="admin-icon">
          </a>
        </div>

        
        <div class="admin-header-center">
          <div class="admin-header-text">
            
            <h1>Bienvenido, Admin</h1>
            <p>Gestión general de pacientes, empleados y acceso a estadisticas</p>
          </div>
        </div>
      
        <div class="admin-header-right">
          <form method="POST" action="{{ route('logout') }}" style="display: inline;">
    @csrf
    <button type="submit" class="logout" title="Volver al panel index">Logout</button>
</form>

        </div>
    </div>


    <main class="admin-dashboard">
    <section class="card-grid">
      <a href="{{ route('admin.usuarios.index') }}" class="card">
        <h2>👥 Usuarios</h2>
        <p>Gestiona los usuarios</p>
      </a>
  
      <a href="{{ route('admin.empleados.index') }}" class="card">
        <h2>👩‍⚕️ Empleados</h2>
        <p>Gestiona el personal veterinario</p>
      </a>

      <!--
      <a href="admin_servicios.html" class="card">
        <h2>🔬 Servicios</h2>
        <p>Gestiona los servicios</p>
      </a> 

      <a href="admin_horarios.html" class="card">
        <h2>📅 Horarios </h2>
        <p>Gestiona los horarios de los empleados</p>
      </a>-->
    
      <a href="{{ route('admin.estadisticas.index') }}" class="card">
        <h2>📊 Reportes</h2>
        <p>Accede a estadísticas y análisis</p>
      </a>

      
      <a href="{{ route('admin.ingresar_como') }}" class="card">
        <h2>🔄 Modo Impersonal</h2>
        <p>Actuar como otro usuario</p>
      </a>
    
    </section>

  </main>
   
</body>
</html>