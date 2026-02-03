<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Turnos</title>
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

  <div class="user-header">
    <div class="user-header-left">
    <a href="{{ route ('user.dashboard') }}">
      <img src="{{ asset('img/usuario.png') }}" alt="Ícono usuario" class="user-icon">
    </a>
  </div>
  <div class="user-header-center">
    <h1>Turno</h1>
  </div>
    <a href="{{ route('user.dashboard') }}" class="logout">Volver</a>
  </div>

  <main class="user-perfil container">

  <section class="modo-registro">
    <h2>Selecciona actividad</h2>
    <ul class="modo-registro-botones">
      <li><a href="#user-nuevo-turno" class="btn-link">Solicitar turno</a></li>
      <li><a href="#user-turnos-registrados" class="btn-link">Ver turnos ya registrados</a></li>
    </ul>
  </section>

  <section class="solicitar-turno-wrapper user-wrapper" id="user-nuevo-turno">
  <h2>Solicitar Turno</h2>

  @if($errors->any())
  <div id="errores" class="alert alert-danger" style="background-color: #f8d7da; padding: 10px; border-radius: 4px; color: #721c24; margin-top: 10px;">
    @foreach($errors->all() as $error)
      <p>{{ $error }}</p>
    @endforeach
  </div>
  @endif

  <div class="usuario-info">
    <p><strong>Dueño:</strong> {{ $usuario->nombre }} {{ $usuario->apellido }}</p>
  <form action="{{ route('user.turno.buscar') }}#lista-turnos" method="GET">
  
    <label for="mascota-select">Seleccionar mascota:</label>
      <select id="mascota-select" name="id_mascota" required>
        <option value="">--Seleccione mascota--</option>
          @foreach($mascotas as $mascota)
        <option value="{{ $mascota->id_mascota }}">
          {{ $mascota->nombre }} 
          ({{ $mascota->especie === 'canino' ? 'perro' : ($mascota->especie === 'felino' ? 'gato' : $mascota->especie) }})
        </option>
          @endforeach
      </select>

    <label for="motivo-select">Motivo de la consulta:</label>
      <select id="motivo-select" name="motivo" required>
        <option value="">--Seleccione motivo--</option>
        <option value="chequeo">Chequeo general / chequeo anual</option>
        <option value="vacunacion">Vacunación / revacunación</option>
        <option value="piel">Problemas de piel / alergias</option>
        <option value="digestivo">Problemas digestivos (vómitos, diarrea)</option>
        <option value="oido_ojo">Infección de oído o de ojos</option>
        <option value="dental">Problemas dentales / boca</option>
        <option value="urinario">Infección urinaria / problemas urinarios</option>
        <option value="dolor_movilidad">Dolor / movilidad / artrosis</option>
        <option value="post_op">Control post-operatorio / esterilización</option>
        <option value="otro">Otro</option>
      </select>
  </div>
    
  <div id="perfil-form"> 
    <fieldset  >
      <legend>Buscar turno (seleccione un solo filtro)</legend>
        <label for="veterinario-select">Por Veterinario:</label>
          <select id="veterinario-select" name="veterinario">
            <option value="">--Seleccionar veterinario--</option>
              @foreach($veterinarios as $vet)
            <option value="{{ $vet->id_usuario }}">
              {{ $vet->sexo === 'femenino' ? 'Dra.' : 'Dr.' }} {{ $vet->apellido }}
            </option>
              @endforeach
          </select>

        <label for="especialidad-select">Por Especialidad:</label>
          <select id="especialidad-select" name="especialidad">
            <option value="">--Seleccionar especialidad--</option>
              @foreach($especialidades as $especialidad)
            <option value="{{ $especialidad }}">{{ ucfirst($especialidad) }}</option>
              @endforeach
          </select>

        <label for="fecha-turno">Por Fecha:</label>
          <input  type="date" id="fecha-turno" name="fecha_turno" min="{{ (\Carbon\Carbon::now()->hour > 17 || (\Carbon\Carbon::now()->hour === 17 && \Carbon\Carbon::now()->minute >= 30))
          ? \Carbon\Carbon::tomorrow()->toDateString()
          : \Carbon\Carbon::today()->toDateString()
          }}"
          max="{{ \Carbon\Carbon::now('America/Argentina/Buenos_Aires')->addDays(7)->toDateString() }}"/>
    </fieldset>
  <button type="submit" class="boton-formulario">Buscar disponibilidad</button>
  </div>
  </form>

  @if($turnosDisponibles->isNotEmpty())
  <section class="disponibilidad-turnos" id="lista-turnos">
    <h3>Horarios disponibles</h3>
    
    <p class="info-text">Seleccione un turno disponible para reservar:</p>
    <ul id="lista-turnos" class="lista-turnos">
      @foreach ($turnosDisponibles as $turno)
        <li class="turno-item">
          <span class="veterinario-nombre">
            {{ $turno->veterinario->nombre }} {{ $turno->veterinario->apellido }} — {{ $turno->veterinario->especialidad }}
          </span> —
          <time datetime="{{ $turno->fecha_hora }}">
            {{ \Carbon\Carbon::parse($turno->fecha_hora)->setTimezone(config('app.timezone'))->format('d/m/Y, H:i') }}
          </time>
          <form method="POST" action="{{ route('user.turno.reservar', \Carbon\Carbon::parse($turno->fecha_hora)->format('Y-m-d_H-i')) }}">
            @csrf
            <input type="hidden" name="id_mascota" value="{{ request('id_mascota') }}">
            <input type="hidden" name="id_veterinario" value="{{ $turno->veterinario->id_usuario }}">
            <input type="hidden" name="fecha_hora" value="{{ \Carbon\Carbon::parse($turno->fecha_hora)->format('Y-m-d H:i:s') }}">
            <input type="hidden" name="motivo" value="{{ request('motivo') }}">
            <button class="btn-reservar" type="submit">Reservar</button>
          </form>
        </li>
      @endforeach
    </ul>
  </section>
@endif

<section class="mis-turnos" id="user-turnos-registrados">
  <h3>Mis turnos reservados</h3>
  <p class="info-text">Puede cancelar un turno si ya no puede asistir:</p>

  @if($turnosReservados->isEmpty())
    <p>No tienes turnos reservados actualmente.</p>
  @else
    <ul class="lista-turnos">
      @foreach ($turnosReservados as $turno)
        <li class="turno-item reservado">
          <span class="veterinario-nombre">
            {{ $turno->veterinario->sexo === 'femenino' ? 'Dra.' : 'Dr.' }}
            {{ $turno->veterinario->apellido }}
          </span> —
          <time datetime="{{ $turno->fecha_hora }}">
            {{ \Carbon\Carbon::parse($turno->fecha_hora)->setTimezone(config('app.timezone'))->format('d/m/Y, H:i') }}
          </time>

          <form method="POST" action="{{ route('user.turno.cancelar', $turno->id_turno) }}" style="display:inline">
          @csrf
          @method('DELETE')
          <button class="btn-cancelar" type="submit" onclick="return confirm('¿Estás seguro que deseas cancelar este turno?')">Cancelar</button>
          </form>
        </li>
      @endforeach
    </ul>
  @endif
</section>




</main>

</body>
</html>