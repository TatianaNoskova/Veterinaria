<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Turnos</title>
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
        Tel: 011 5032-0076<br>
        Lun–Vie 10–18hs | Sáb 10–14hs</p>
      </div> 
    </div>
  </header>

<header class="empleado-header">
  <div class="empleado-header-left">
          <a href="{{ route('empleado.dashboard') }}">
          <img src="{{ asset('img/veterinario.png') }}" alt="Vete Icono" class="vete-icon">
          </a>
  </div>
  <div class="empleado-header-center">
    <h1>Turno</h1>
    <p>Asignar turno</p>
  </div>
  <div class="empleado-header-right">
    <a href="{{ route('empleado.dashboard') }}" class="logout">Volver</a>
  </div>
</header>

<main class="vet-mascota container">

<h2>

 @if($fecha_hora)
  <h2>
    Asignar turno para {{ \Carbon\Carbon::parse($fecha_hora)->format('d-m-Y') }}
    a las {{ \Carbon\Carbon::parse($fecha_hora)->format('H:i') }}
  </h2>
@else
  <h2 style="color:red;">Error: fecha_hora no recibida correctamente</h2>
@endif



</h2>



<section class="form-section" id="form-turno">

    {{-- Шаг 1: Выбор клиента --}}
    @if(!request()->has('cliente'))

    
        <form method="GET" action="{{ route('empleado.turno.create', ['fecha' => $fecha, 'hora' => $hora]) }}">

        <input type="hidden" name="fecha" value="{{ $fecha }}">
        <input type="hidden" name="hora" value="{{ $hora }}">
            <label>🔍 Buscar cliente:</label>
            <select class="select-cliente" name="cliente" required>
                <option value="">Seleccione un cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id_usuario }}">
                        {{ $cliente->nombre }} {{ $cliente->apellido }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="boton-secundario">Siguiente</button>
        </form>

    @elseif(request()->has('cliente'))
        <div id="form-mascota-cliente">
            <form method="POST" action="{{ route('empleado.turno.store') }}">
                @csrf

                
                <input type="hidden" name="fecha_hora" value="{{ $fecha_hora }}">
                
                <input type="hidden" name="cliente_id" value="{{ request('cliente') }}">

                <p><strong>Cliente:</strong> {{ $cliente->nombre }} {{ $cliente->apellido }}</p>

                <label>Seleccionar mascota:</label>
                <select class="select-mascota" name="mascota_id" required>
                    <option value="">Seleccione una mascota</option>
                    @foreach($mascotas as $mascota)
                        <option value="{{ $mascota->id_mascota }}">{{ $mascota->nombre }}</option>
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

                <button type="submit" class="boton-secundario">Asignar turno</button>
            </form>
        </div>
    @endif

</section>


</main>
</html>