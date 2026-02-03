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
          <a href="{{ route ('empleado.dashboard') }}">
          <img src="{{ asset('img/veterinario.png') }}" alt="Vete Icono" class="vete-icon">
        </div>
        </a>
        <div class="empleado-header-center">
          <div class="empleado-header-text">
            
            <h1>Modificar factura no.{{ $factura->id_factura }}</h1>
          </div>
        </div>
      
        <div class="empleado-header-right">
          <a href="{{ route('empleado.facturas.index') }}" class="logout" title="Volver a facturas">Volver</a>
        </div>
    </div>

<main class="vet-mascota container">
  <section class="form-section">
    <h2>Modificar factura</h2>

    
    <!-- Форма редактирования фактуры -->
    <form action="{{ route('empleado.factura.update', $factura->id_factura) }}" method="POST">
    @csrf
    @method('PUT')

      <!-- Клиент (только отображение, без возможности изменить) -->
    <label>Cliente:</label>
      <h3 class="cliente-nombre">
      {{ optional($factura->turno->mascota->clientes->first())->nombre ?? '-' }}
      {{ optional($factura->turno->mascota->clientes->first())->apellido ?? '' }}
      </h3>
      <input type="hidden" name="cliente_id" value="{{ optional($factura->turno->mascota->clientes->first())->id ?? '' }}">

      <!-- Выбор питомца -->
    <label>Mascota:</label>
      <h3 class="mascota-nombre">{{ $factura->turno->mascota->nombre ?? '-' }}</h3>
      <input type="hidden" name="mascota_id" value="{{ $factura->turno->mascota->id ?? '' }}">

      <!-- Дата фактуры -->
    <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" value="{{ \Carbon\Carbon::parse($factura->fecha)->format('Y-m-d') }}" required>


      <!-- Мотив -->
    <label>Motivo de la factura:</label>
      <h3 class="cliente-nombre">{{ $factura->turno->motivo ?? '-' }}</h3>
      <input type="hidden" name="motivo" value="{{ $factura->turno->motivo }}">


      <!-- Услуги (с уже выбранными чекбоксами) -->
      <!-- Servicios -->
    <fieldset class="servicios-fieldset">
    <legend>Seleccionar servicios</legend>
    <div class="servicios-container">
        @foreach($servicios as $servicio)
            <label class="servicio-item">
                <input 
                    type="checkbox" 
                    name="servicios[]" 
                    value="{{ $servicio->id_servicio }}" 
                    data-precio="{{ $servicio->precio }}"
                    {{ $factura->servicios->contains('id_servicio', $servicio->id_servicio) ? 'checked' : '' }}
                >
                <span class="nombre-servicio">
                    {{ $servicio->nombre }} — ${{ number_format($servicio->precio, 2) }}
                </span>
            </label>
        @endforeach
    </div>
</fieldset>


      <!-- Estado -->
    <label for="estado">Estado de la factura:</label>
      <select name="estado" id="estado" required>
        <option value="pendiente" {{ $factura->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
        <option value="pagado" {{ $factura->estado === 'pagado' ? 'selected' : '' }}>Pagado</option>
      </select>


      <!-- Кнопка сохранения -->
      <button type="submit" class="boton-formulario">Guardar cambios</button>
    </form>
  </section>
</main>




</body>
</html>