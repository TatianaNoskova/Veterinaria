<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Horario</title>
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
          <img src="{{ asset('img/veterinario.png') }}" alt="Vete Icono" class="vete-icon"></a>
        </div>
        
        <div class="empleado-header-center">
          <div class="empleado-header-text">
           
            <h1>Horario de: {{ $veterinario->nombre }} {{ $veterinario->apellido }}</h1>
            
          </div>
        </div>
      
        <div class="empleado-header-right">
          <a href="{{ route('empleado.dashboard') }}" class="logout" title="Volver al panel de veterinario">Volver</a>
        </div>
    </div>

<main class="vet-mascota container">
  <div class="mascota-wrapper">
    

  <form method="GET" action="{{ route('empleado.horario.index') }}" id="schedule-form" class="form-horario-inline">
  <label for="schedule-date">Seleccione una fecha (lunes a sábado):</label>

  <input
    type="date"
    id="schedule-date"
    name="schedule-date"
    min="{{ $minDate }}"
    max="{{ $maxDate }}"
    value="{{ old('schedule-date', $selectedDate) }}"
    required
  />

  @error('schedule-date')
   <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-top: 10px;">
    {{ $message }}
</div>

  @enderror

  <button type="submit" class="boton-horario">Actualizar</button>
</form>


<br>
<h2>Horario para el {{ $fecha }}</h2>

<ul class="schedule-list" id="schedule-list">
  @foreach ($slots as $slot)
    <li>
      <span class="hora">{{ $slot['hora'] }}</span>

      @if ($slot['estado_texto'] === 'Disponible')
        <span class="estado disponible">
          {{ $slot['estado_texto'] }}

          {{-- Иконка "Добавить запись" --}}
          <a href="{{ route('empleado.turno.create', ['fecha' => $fecha, 'hora' => $slot['hora']]) }}" 
   class="btn-action new-history-button" 
   title="Asignar turno">➕</a>

<form action="{{ route('empleado.slot.bloquear') }}" method="POST" style="display:inline;">
    @csrf
    <input type="hidden" name="fecha" value="{{ $fecha }}">
    <input type="hidden" name="hora" value="{{ $slot['hora'] }}">
    <button type="submit" class="btn-action btn-delete delete-button" title="Bloquear slot" onclick="return confirm('¿Seguro que deseas bloquear este slot?')">❌</button>
</form>

        </span>
      @else
        <span class="estado {{ $slot['estado_css'] }}">{{ $slot['estado_texto'] }}</span>
      @endif
    </li>
  @endforeach
</ul>




</main>


</body>
</html>