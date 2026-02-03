<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel Principal del Usuario</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user.css') }}">
</head>

<body>

  <header>
    <div class="top-banner"> 
      <div class="logo">
       <a href="{{ route('index') }}"> 
          <img src="../img/logovete.png" alt="Logo Veterinaria">
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

  <!-- Шапка для панели пользователя -->
  <header class="user-header">
    <div class="user-header-left">
      <img src="../img/usuario.png" alt="Ícono de usuario" class="user-icon">
    </div>
    <div class="user-header-center">
      <h1>Bienvenido a tu Panel de Usuario</h1>
      <p>Gestión de tus mascotas y otros servicios</p>
    </div>
    <div class="admin-header-right">
      <form method="POST" action="{{ route('logout') }}" style="display: inline;">
        @csrf
      <button type="submit" class="logout" title="Volver al panel index">Logout</button>
      </form>
  </header>
  
  

  
  <main class="user-dashboard">
    <section class="card-grid">

        <!-- Profile -->
    <a href="{{ route('user.perfil.index') }}" class="card">
        <h2>👤 Mi Cuenta</h2>
        <p>Gestión de los datos personales y mascotas</p>
    </a>

    <!-- Карточка для просмотра историй болезни -->
    <a href="{{ route('user.mascotas.list') }}" class="card">
        <h2>📋 Historiales</h2>
        <p>Consultar historiales de mascotas</p>
    </a> 
  

      

      <!-- Facturas -->
      <a href="{{ route('user.facturas.index') }}" class="card">
        <h2>💳 Facturas</h2>
        <p>Revisa tus pagos y deudas pendientes</p>
      </a>

      <!-- Карточка для записи на прием -->
      <a href="{{ route('user.turnos.index') }}" class="card">
        <h2>📅 Turnos</h2>
        <p>Solicita una cita veterinaria</p>
      </a>

      

      <!-- Карточка для отзывов 
      <a href="user_resenas.html" class="card">
        <h2>💬 Reseñas</h2>
        <p>Tu voz nos ayuda a mejorar cada día </p>
      </a> -->

    </section>
  </main>

</body>
</html>






