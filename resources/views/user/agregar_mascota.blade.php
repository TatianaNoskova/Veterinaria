<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Agregar mascota</title>
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
      <h1>Agregá tu nueva mascota</h1>
    </div>
  </div>

  <div class="user-header-right">
    <a href="{{ route('user.perfil.index') }}" class="logout" title="Volver al panel">Volver</a>
  </div>
</div>

<main class="user-perfil container">
  <div class="user-wrapper">
    <div class="user-content">
      <h2>Agregar Mascota</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="list-style-type: none; padding-left: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

      <form id="perfil-form" action="{{ route('user.mascota.store') }}" method="POST">
    @csrf

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="especie">Especie:</label>
        <select id="especie" name="especie" required>
          <option value="">Seleccionar</option>
          <option value="canino">Perro</option>
          <option value="felino">Gato</option>
        </select>

        <label for="raza">Raza:</label>
        <input type="text" id="raza" name="raza">

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" placeholder="Edad (años)" min="0" required>

        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo" required>
          <option value="">Seleccionar</option>
          <option value="macho">Macho</option>
          <option value="hembra">Hembra</option>
        </select>

        <label for="dueno_secundario">Dueño secundario (opcional):</label>
        <select name="dueno_secundario" id="dueno_secundario">
          <option value="">-- Ninguno --</option>
          @foreach ($clientes as $cliente)
          <option value="{{ $cliente->id_usuario }}">
            {{ $cliente->nombre }} {{ $cliente->apellido }} ({{ $cliente->correo_electronico }})
          </option>
          @endforeach
        </select>


        <div class="botones-contenedor">
          <button type="submit" class="boton-formulario">Guardar Mascota</button>
          <a href="perfil_usuario.html" class="btn-formulario">Cancelar</a>
        </div>

      </form>
    </div>
  </div>
</main>


</body>