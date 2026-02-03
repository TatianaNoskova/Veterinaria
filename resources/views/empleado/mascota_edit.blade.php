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
          <a href="{{ route('empleado.dashboard') }}">
          <img src="{{ asset('img/veterinario.png') }}" alt="Vete Icono" class="vete-icon">
        </div>
        </a>
        <div class="empleado-header-center">
          <div class="empleado-header-text">
            
            <h1>Editar mascota de 
    @if($primerDueno) 
        {{ $primerDueno->nombre }} {{ $primerDueno->apellido }} 
    @else 
        - 
    @endif
</h1>
          </div>
        </div>
      
        <div class="empleado-header-right">
          <a href="{{ route('empleado.mascotas.index') }}" class="logout" title="Volver al panel de veterinario">Volver</a>

        </div>
    </div>

<main class="vet-mascota container">
  <section class="form-section">
    <h2>Modificar mascota</h2>
    <form id="perfil-form" method="POST" action="{{ route('empleado.mascotas.update', $mascota->id_mascota) }}">
    @csrf
    @method('PUT')
  <!-- Первый владелец -->
<select id="dueno" name="dueno" required>
    @foreach($clientes as $cliente)
        <option value="{{ $cliente->id_usuario }}" 
            @if($primerDueno && $primerDueno->id_usuario == $cliente->id_usuario) 
                selected 
            @endif>
            {{ $cliente->nombre }} {{ $cliente->apellido }}
        </option>
    @endforeach
</select>


  <label for="nombre">Nombre de mascota:</label>
  <input type="text" id="nombre" name="nombre" value="{{ $mascota->nombre }}" placeholder="Nombre mascota" required>

  <label for="especie">Especie:</label>
  <select id="especie" name="especie" required>
        <option value="canino" {{ $mascota->especie == 'canino' ? 'selected' : '' }}>Perro</option>
        <option value="felino" {{ $mascota->especie == 'felino' ? 'selected' : '' }}>Gato</option>
    </select>

  <label for="raza">Raza:</label>
  <input type="text" id="raza" name="raza" value="{{ $mascota->raza }}" placeholder="Raza" required>

  <label for="edad">Edad:</label>
  <input type="number" id="edad" name="edad" value="{{ $mascota->edad }}" placeholder="Edad" min="0" required>

  <label for="sexo">Sexo:</label>
  <select id="sexo" name="sexo" required>
        <option value="hembra" {{ $mascota->sexo == 'hembra' ? 'selected' : '' }}>Hembra</option>
        <option value="macho" {{ $mascota->sexo == 'macho' ? 'selected' : '' }}>Macho</option>
    </select>

 <!-- Второй владелец (опционально) -->
<div class="busqueda-clientes">
    <label for="otro-dueno">🔍 Otro dueño (opcional):</label>
    <select id="otro-dueno" name="dueno_secundario">
        <option value="">—</option> <!-- Прочерк по умолчанию -->

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
  <a href="{{ route ('empleado.mascotas.index') }}" class="btn-cancelar">Cancelar</a>
  </div>
</form>

</section>
</main>



</body>
</html>