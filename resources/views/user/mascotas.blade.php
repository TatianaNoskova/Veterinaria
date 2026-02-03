<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Mascotas</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user.css') }}">
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

  <div class="user-header">
  <div class="user-header-left">
    <a href="{{ route('user.dashboard') }}">
      <img src="{{ asset('img/usuario.png') }}" alt="Ícono usuario" class="user-icon">
    </a>
  </div>

  <div class="user-header-center">
    <div class="user-header-text">
      <h1>Mis mascotas</h1>
    </div>
  </div>

  <div class="user-header-right">
    <a href="{{ route('user.dashboard') }}" class="logout" title="Volver al panel">Volver</a>
  </div>
</div>

<main class="user-perfil container">
  <main class="user-perfil container">
  <section class="mis-mascotas-lista container">
    <h2>🐾 Mis Mascotas</h2>
    <p>Hacé clic en el icono 📋 para ver el historial médico de tu mascota</p>

    <ul class="lista-mascotas">
      @foreach($mascotas as $mascota)
        <li class="mascota-item">
          <div class="nombre-mascota">{{ $mascota->nombre }}</div>
          <div class="mascota-info">
            <p><strong>Especie:</strong> {{ $mascota->especie }}</p>
            <p><strong>Raza:</strong> {{ $mascota->raza }}</p>
            <p><strong>Edad:</strong> {{ $mascota->edad }} años</p>
            <p><strong>Sexo:</strong> {{ $mascota->sexo }}</p>
          </div>
          <!-- Ссылка на страницу с историей болезни питомца -->
          <a href="{{ route('user.historial', ['id' => $mascota->id_mascota]) }}" class="btn-historial" title="Ver historial médico">📋</a>
        </li>
      @endforeach
    </ul>
  </section>
</main>
</main>


</body>
</html>