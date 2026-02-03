<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Nueva entrada médica</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/vete.css') }}">
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

<div class="empleado-header">
  <div class="empleado-header-left">
          <a href="{{ route('empleado.dashboard') }}">
          <img src="{{ asset('img/veterinario.png') }}" alt="Vete Icono" class="vete-icon">
          </a>
    </div>

  <div class="empleado-header-center">
   
    <h1>Nueva entrada médica - {{ $mascota->nombre }}</h1>
    <p>Dueño(-s): 
        @foreach($dueños as $dueño)
            {{ $dueño->nombre }} {{ $dueño->apellido }}
            @if(!$loop->last), @endif 
        @endforeach
    </p>
  </div>

  <div class="empleado-header-right">
    <a href="{{ route('empleado.mascotas.index') }}" class="logout">Volver</a>
  </div>
</div>

<main class="vet-mascota container ">

  <section class="form-section">
    <h2>Registrar nueva consulta</h2>

    <form method="POST" action="{{ route('empleado.mascota.store_historia_nueva', $mascota->id_mascota) }}" id="nueva-consulta-form">
    @csrf

    <label for="fecha">Fecha</label>
    <input type="date" id="fecha" name="fecha" required>

    <label for="descripcion">Descripción/Diagnóstico</label>
    <textarea id="descripcion" name="descripcion" required></textarea>

    <label for="receta">Tratamiento/Receta</label>
    <textarea id="receta" name="receta"></textarea>

    <label for="id_turno">Selecciona un Turno:</label>
    <select name="id_turno" required>
    @foreach($mascota->turnos as $turno)
        @if($turno->id_veterinario == auth()->user()->id_usuario)  <!-- Фильтрация по текущему ветеринару -->
            <option value="{{ $turno->id_turno }}">
                {{ \Carbon\Carbon::parse($turno->fecha_hora)->format('d/m/Y H:i') }} - 
                {{ $turno->veterinario->nombre }} {{ $turno->veterinario->apellido }}
            </option>
        @endif
    @endforeach
</select>

    <button type="submit">Guardar entrada médica</button>
</form>

  </section>

</main>

</body>
</html>
