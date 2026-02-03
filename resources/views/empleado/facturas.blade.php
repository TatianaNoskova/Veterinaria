<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Facturas</title>
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
    <h1>Facturación</h1>
    <p>Crear y consultar facturas</p>
  </div>
  <div class="empleado-header-right">
    <a href="{{ route('empleado.dashboard') }}" class="logout">Volver</a>
  </div>
</header>

<main class="vet-mascota container">

<section class="modo-registro">
    <h2>Selecciona acción</h2>
    <ul class="modo-registro-botones">
      <li><a href="#nueva-factura" class="btn-link">Crear nueva factura</a></li>
      <li><a href="#factura-existente" class="btn-link">Ver y editar facturas emitidas</a></li>
    </ul>

  </section>

<section class="form-section" id="nueva-factura">
    <h2>Crear nueva factura</h2>

    <div class="busqueda-clientes">
        <!-- Paso 1: Seleccionar cliente -->
        @if(!request()->has('cliente'))
            <form method="GET" action="{{ route('empleado.facturas.index') }}#form-mascota-cliente">
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

        <!-- Paso 2: Seleccionar mascota --}} -->
        @elseif(!request()->has('mascota'))
        <div id="form-mascota-cliente">
            <form method="GET" action="{{ route('empleado.facturas.index') }}#form-turno">
                <input type="hidden" name="cliente" value="{{ request('cliente') }}">

                <p><strong>Cliente:</strong> {{ $cliente->nombre }} {{ $cliente->apellido }}</p>

                <label>Seleccionar mascota:</label>
                <select class="select-mascota" name="mascota" required>
                    <option value="">Seleccione una mascota</option>
                    @foreach($mascotas as $mascota)
                        <option value="{{ $mascota->id_mascota }}">
                            {{ $mascota->nombre }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="boton-secundario">Siguiente</button>
            </form>
        </div>

        <!-- Paso 3: Seleccionar turno -->
        @elseif(!request()->has('turno'))
          <div id="form-turno">
            <form method="GET" action="{{ route('empleado.facturas.index') }}#form-servicios">
                <input type="hidden" name="cliente" value="{{ request('cliente') }}">
                <input type="hidden" name="mascota" value="{{ request('mascota') }}">

                <p><strong>Cliente:</strong> {{ $cliente->nombre }} {{ $cliente->apellido }}</p>
                <p><strong>Mascota:</strong> {{ $mascotaSeleccionada->nombre ?? 'Mascota no encontrada' }}</p>

                <label>Seleccionar turno:</label>
                <select class="select-turno" name="turno" required>
                    <option value="">Seleccione un turno</option>
                    @foreach($turnos as $turno)
                    <option value="{{ $turno->id_turno }}">
                      {{ \Carbon\Carbon::parse($turno->fecha_hora)->format('d/m/Y H:i') }}
                      — {{ $turno->motivo }}
                      ({{ ucfirst($turno->estado) }})
                    </option>
                    @endforeach

                </select>

                <button type="submit" class="boton-secundario">Siguiente</button>
            </form>
          </div>

        <!-- Paso 4: Formulario final -->
        @else
        <div id="form-servicios">
            <form action="{{ route('empleado.facturas.store') }}" method="POST" class="formulario-vet">
                @csrf

                <input type="hidden" name="cliente_id" value="{{ request('cliente') }}">
                <input type="hidden" name="mascota_id" value="{{ request('mascota') }}">
                <input type="hidden" name="turno_id" value="{{ request('turno') }}">

                <p><strong>Cliente:</strong> {{ $cliente->nombre }} {{ $cliente->apellido }}</p>
                <p><strong>Mascota:</strong> {{ $mascotaSeleccionada->nombre ?? 'Mascota no encontrada' }}</p>
                <p><strong>Turno:</strong>
                  {{ \Carbon\Carbon::parse($turnoSeleccionado->fecha_hora)->format('d/m/Y H:i') ?? '' }}
                  — {{ $turnoSeleccionado->motivo ?? '' }}
                  ({{ ucfirst($turnoSeleccionado->estado) }})
                </p>


                <fieldset class="servicios-fieldset">
                    <legend>Seleccionar servicios</legend>
                    <div class="servicios-container">
                        @foreach($servicios as $servicio)
                            <label class="servicio-item">
                                <input type="checkbox" name="servicios[]" value="{{ $servicio->id_servicio }}" data-precio="{{ $servicio->precio }}">
                                <span class="nombre-servicio">{{ $servicio->nombre }} — ${{ number_format($servicio->precio, 2) }}</span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>

                <button type="submit" class="boton-formulario">Crear factura</button>
            </form>
          </div>
        @endif
    </div>
</section>




 

<!-- Facturas creadas -->
<section class="tabla-mascotas" id="factura-existente">
  <h2>📋 Mis facturas emitidas</h2>
  <table class="facturas-table">
    <thead>
      <tr>
        <th> No.</th>
        <th>Fecha</th>
        <th>Cliente</th>
        <th>Mascota</th>
        <th>Motivo</th>
        <th>Importe</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
  @forelse($facturas as $factura)
    <tr>
      <td>{{ $factura->id_factura }}</td>
      <td>{{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}</td>

      <td>
        {{ optional($factura->turno->mascota->clientes->first())->nombre ?? '-' }}
        {{ optional($factura->turno->mascota->clientes->first())->apellido ?? '' }}
      </td>

      <td>{{ $factura->turno->mascota->nombre ?? '-' }}</td>
      <td>{{ $factura->turno->motivo ?? '-' }}</td>
      <td>${{ number_format($factura->total, 2) }}</td>
      <td>{{ ucfirst($factura->estado) }}</td>
      <td>
 <div class="action-buttons">
  @if ($factura->estado === 'pendiente')
    {{-- Редактировать --}}
    <a href="{{ route('empleado.factura.edit', $factura->id_factura) }}" class="btn-action" title="Editar factura">✏️</a>

    {{-- Удалить --}}
    <form action="{{ route('empleado.factura.destroy', $factura->id_factura) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta factura?');" style="display:inline;">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn-action btn-delete" title="Eliminar factura">🗑️</button>
    </form>

  @elseif ($factura->estado === 'pagado')
    {{-- Просмотреть/изменить статус --}}
    <a href="{{ route('empleado.factura.show', $factura->id_factura) }}" class="btn-action" title="Ver factura">🔍</a>
  @endif
</div>


</td>

    </tr>
  @empty
    <tr>
      <td colspan="7" style="text-align: center;">No hay facturas emitidas aún.</td>
    </tr>
  @endforelse
</tbody>

  </table>
</section>




</main>

</body>
</html>
