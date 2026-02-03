<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Mascota</title>
     <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
</head>
<body>
     <header>
    <div class="top-banner"> 
      <div class="logo">
        <a href="{{ route('index') }}">
          <img src="{{ asset('/img/logovete.png') }}" alt="Logo Veterinaria">
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
      <h1>Gestión de mascotas</h1>
    </div>
  </div>

  <div class="user-header-right">
    <a href="{{ route('user.perfil.index') }}" class="logout" title="Volver al panel">Volver</a>
  </div>
</div>

<main class="user-perfil container">
  <section class="user-wrapper">
    <div class="user-content">
      <h2>✏️ Modificar Mascota</h2>

      <form id="perfil-form" method="POST" action="{{ route('user.mascota.update', $mascota->id_mascota) }}">
      @csrf
      @method('PUT')
        <label for="dueno">Nombre completo de dueño:</label>
        <input type="text" id="dueno" name="dueno" value="{{ $cliente->nombre }} {{ $cliente->apellido }}" placeholder="Nombre completo de dueño" readonly>

        <label for="nombre">Nombre de mascota:</label>
        <input type="text" id="nombre" name="nombre" value="{{ $mascota->nombre }}" placeholder="Nombre mascota" required>

        <label for="especie">Especie:</label>
        <select id="especie" name="especie" required>
          <option value="Perro" {{ $mascota->especie == 'canino' ? 'selected' : '' }}>Perro</option>
          <option value="Gato" {{ $mascota->especie == 'felino' ? 'selected' : '' }}>Gato</option>
        </select>

        <label for="raza">Raza:</label>
        <input type="text" id="raza" name="raza" value="{{ $mascota->raza }}" placeholder="Raza" required>

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" value="{{ $mascota->edad }}" placeholder="Edad (años)" min="0" required>

        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo" required>
          <option value="Hembra" {{ $mascota->sexo == 'hembra' ? 'selected' : '' }}>Hembra</option>
          <option value="Macho" {{ $mascota->sexo == 'macho' ? 'selected' : '' }}>Macho</option>
        </select>

 <div class="busqueda-clientes">
    <label for="otro-dueno">🔍 Otro dueño (opcional):</label>
    <select id="otro-dueno" name="dueno_secundario">
        <option value=""></option>

        @foreach($clientes as $cliente)
            <option value="{{ $cliente->id_usuario }}" 
                @if($segundoDueno && $segundoDueno->id_usuario == $cliente->id_usuario) 
                    selected 
                @endif>
                {{ $cliente->nombre }} {{ $cliente->apellido }}
            </option>
        @endforeach
    </select>

    @if($segundoDueno)
        <p>Segundo dueño seleccionado: {{ $segundoDueno->nombre }} {{ $segundoDueno->apellido }}</p>
    @endif
</div>







        <div class="botones-contenedor">
          <button type="submit" class="boton-formulario">Guardar cambios</button>
          <a href="{{ route('user.dashboard') }}" class="btn-formulario">Cancelar</a>
        </div>
      </form>
    </div>
  </section>
</main>






    
</body>
</html>
