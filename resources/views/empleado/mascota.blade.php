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
        <a href="{{ ('index') }}"> 
          <img src="../img/logovete.png" alt="Logo Veterinaria">
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
          <img src="../img/veterinario.png" alt="Vete Icono" class="vete-icon"></a>
        </div>
        
        <div class="empleado-header-center">
          <div class="empleado-header-text">
            
            <h1>Gestión de mascotas</h1>
          </div>
        </div>
      
        <div class="empleado-header-right">
          <a href="{{ route('empleado.dashboard') }}" class="logout" title="Volver al panel de administrador">Volver</a>
        </div>
    </div>

<main class="vet-mascota container">

  <section class="modo-registro">
    <h2>Selecciona el modo de registro</h2>
    <ul class="modo-registro-botones">
      <li><a href="#nueva-mascota" class="btn-link">Registrar nueva mascota</a></li>
      <li><a href="#mascota-existente" class="btn-link">Agregar mascota existente</a></li>
      <li><a href="#mascota-del-veterinario" class="btn-link">Ver lista de mis mascotas</a></li>
    </ul>

  </section>

<section class="mascota-wrapper" id="nueva-mascota">
  <h2>Registrar nueva mascota</h2>

  <!-- Seleccionar el primer dueño -->
  @if(!request()->has('cliente1'))
    <form method="GET" action="{{ route('empleado.mascotas.index') }}#form-segundo-cliente">
      <label for="cliente1">Seleccione el primer dueño:</label>
      <select name="cliente1" id="cliente1" required>
        <option value="" disabled selected>Seleccione un cliente</option>
        @foreach($clientes as $cliente)
          <option value="{{ $cliente->id_usuario }}">
            {{ $cliente->nombre }} {{ $cliente->apellido }}
          </option>
        @endforeach
      </select>

      <button type="submit" class="boton-secundario">Siguiente</button>

    </form>

  <!-- La 2 etapa de registro -->
  @else
    <form action="{{ route('empleado.mascotas.store') }}" method="POST" class="formulario-vet" id="form-segundo-cliente">
      @csrf

      
      <input type="hidden" name="clientes_ids[]" value="{{ request('cliente1') }}">

      <!-- Mostrar 1 dueño seleccionado -->
      <p><strong>Dueño 1:</strong>
        @php
          $cliente1 = $clientes->firstWhere('id_usuario', request('cliente1'));
        @endphp
        {{ $cliente1->nombre }} {{ $cliente1->apellido }}
      </p>

      <!-- El 2 dueño (opcional) -->
      <label for="cliente2">Cliente 2 (opcional):</label>
      <select name="clientes_ids[]" id="cliente2">
        <option value="" disabled selected>Seleccione otro cliente (opcional)</option>
        @foreach($clientes->where('id_usuario', '!=', request('cliente1')) as $cliente)
          <option value="{{ $cliente->id_usuario }}">
            {{ $cliente->nombre }} {{ $cliente->apellido }}
          </option>
        @endforeach
      </select>

      <!-- Datos de la mascota -->
      <input type="text" name="nombre" placeholder="Nombre de la mascota" required>

      <select name="especie" required>
        <option value="">Especie</option>
        <option value="canino">Perro</option>
        <option value="felino">Gato</option>
      </select>

      <select name="sexo" required>
        <option value="">Sexo</option>
        <option value="hembra">Hembra</option>
        <option value="macho">Macho</option>
      </select>

      <input type="text" name="raza" placeholder="Raza">
      <input type="number" name="edad" placeholder="Edad (años)">

      <button type="submit" class="boton-formulario">Registrar Mascota</button>
    </form>
  @endif
</section>

<section class="mascota-wrapper" id="mascota-existente">
    <h2>Agregar mascota ya registrada en el sistema</h2>

      <form id="registro-mascota-existente-form" class="formulario-vet" method="POST" action="{{ route('empleado.mascota.agregar') }}">
      @csrf
    
    <div class="busqueda-clientes">
      <label for="buscar-cliente-existente">🔍 Buscar mascota:</label>
      <select id="mascota-existente" name="mascota_id" required>
      <option value="">Seleccione una mascota</option>
      @foreach($mascotasNoAsignadas as $mascota)
      <option value="{{ $mascota->id_mascota }}">
        {{ $mascota->nombre }} ({{ $mascota->especie }}), Propietario: 
        @foreach($mascota->clientes as $cliente)
          {{ $cliente->nombre }} {{ $cliente->apellido }}
          @if(!$loop->last), @endif
        @endforeach
      </option>
      @endforeach
    </select>
  </div>


    <button type="submit" class="boton-formulario">Agregar a mi lista</button>
  </form>
</section>

<section class="mascotas-registrados" id="mascota-del-veterinario">
  <h2>Mascotas asignadas</h2>

  <div class="tabla-mascotas">
      <table>
          <thead>
              <tr>
                  <th>Dueño</th>
                  <th>Nombre</th>
                  <th>Especie</th>
                  <th>Raza</th>
                  <th>Edad</th>
                  <th>Sexo</th>
                  <th>Acciones</th>
              </tr>
          </thead>
          <tbody>
              @foreach($mascotasAsignadas as $mascota)
                  <tr>
                      <td>
                          @foreach($mascota->clientes as $cliente)
                          {{ $cliente->nombre }} {{ $cliente->apellido }}
                          @if(!$loop->last), @endif
                          @endforeach
                      </td>

                      <td>{{ $mascota->nombre }}</td>
                      <td>{{ ucfirst($mascota->especie) }}</td>
                      <td>{{ $mascota->raza ?? 'N/A' }}</td>
                      <td>{{ $mascota->edad }}</td>
                      <td>{{ ucfirst($mascota->sexo) }}</td>
                      <td>
    <div class="action-buttons">
        <a href="{{ route('empleado.mascota.edit', $mascota->id_mascota) }}" class="btn-action edit-button">✏️</a>
        <form action="{{ route('empleado.mascota.destroy', $mascota->id_mascota) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-action btn-delete delete-button" title="Eliminar mascota" onclick="return confirm('¿Seguro que quieres eliminar esta mascota?')">🗑️</button>
        </form>
      
        <a href="{{ route('empleado.mascota_historial', ['id' => $mascota->id_mascota]) }}"class="btn-action" title="Ver historial médico">📋</a>

        <a href="{{ route('empleado.mascota.historia_nueva', $mascota->id_mascota) }}" class="btn-action new-history-button">➕</a>
    </div>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</section>



</main>

</body>
</html>