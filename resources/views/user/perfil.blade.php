<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mi Perfil y Mascotas</title>
   <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user.css') }}">
</head>
<body>
  <header>
    <div class="top-banner"> 
      <div class="logo">
        <a href="{{ route('index') }}">
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

  <div class="user-header">
  <div class="user-header-left">
    <a href="{{ route('user.dashboard') }}">
      <img src="../img/usuario.png" alt="Ícono usuario" class="user-icon">
    </a>
  </div>

  <div class="user-header-center">
    <div class="user-header-text">
      <h1>Gestión de tus datos y mascotas</h1>
    </div>
  </div>

  <div class="user-header-right">
     <a href="{{ route('user.dashboard') }}" class="logout" title="Volver al panel del usuario">Volver</a>
  </div>
</div>

<main class="user-perfil container">

  <section class="modo-registro">
    <h2>Selecciona actividad</h2>
    <ul class="modo-registro-botones">
      <li><a href="#user-datos" class="btn-link">Gestión de los datos personales</a></li>
      <li><a href="#user-mascotas" class="btn-link">Gestión de las mascotas</a></li>
    </ul>
    </section>


  <!-- Perfil de usuario -->
  <section class="user-wrapper" id="user-datos">
  <div class="user-content">
    <h2>👤 Mi Cuenta</h2>
    <form id="perfil-form" method="POST" action="{{ route('user.perfil.actualizar') }}">
    @csrf
      <label for="nombre">Nombre</label>
      <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" required>

      <label for="apellido">Apellido</label>
      <input type="text" id="apellido" name="apellido" value="{{ old('apellido', $cliente->apellido) }}" required>

      <label for="dni">DNI</label>
      <input type="text" id="dni" name="dni" value="{{ old('dni', $cliente->dni) }}" required>

      <label for="telefono">Teléfono</label>
      <input type="tel" id="telefono" name="telefono" value="{{ old('telefono', $cliente->telefono) }}">

      <label for="email">Correo electrónico</label>
      <input type="email" id="correo_electronico" name="correo_electronico" value="{{ old('correo_electronico', $cliente->correo_electronico) }}" required>

      <label for="direccion">Dirección</label>
      <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $cliente->direccion) }}">

      <label for="password">Nueva Contraseña (opcional)</label>
      <input type="password" id="password" name="password" placeholder="Nueva contraseña (opcional)">

      <label for="password_confirmation">Confirmar Contraseña</label>
      <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repite la nueva contraseña">



      <div class="botones-contenedor">
        <button type="submit" class="boton-formulario">Guardar cambios</button>
    </form>    
      <form action="{{ route('user.perfil.eliminar') }}" method="POST" style="display:inline;">
      @csrf
      @method('DELETE')
        <button type="submit" class="btn-formulario" title="Eliminar cuenta" onclick="return confirm('¿Estás seguro de que quieres eliminar tu cuenta?')">🗑️ Eliminar cuenta</button>
      </form>
      </div>
    
  </div>
  </section>




  <!-- Mascotas del usuario -->
  <section class="mascotas-registrados" id="user-mascotas">
    <h2>🐾 Mis Mascotas</h2>
    <p>Gestiona tus mascotas: agregar, editar o eliminar</p>

    <a href="{{ route('user.agregar_mascota') }}" class="btn-action" style="margin-bottom: 1rem;">➕ Agregar nueva mascota</a>

    <div class="tabla-mascotas">
      <table>
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Raza</th>
            <th>Sexo</th>
            <th>Edad</th>
            <th>Otro dueño<br><span class="sub-label">(si tiene)</span></th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse ($mascotas as $mascota)
          <tr>
            <td>{{ $mascota->nombre }}</td>
            <td>{{ ucfirst($mascota->especie) }}</td>
            <td>{{ $mascota->raza ?? '-' }}</td>
            <td>{{ ucfirst($mascota->sexo) }}</td>
            <td>{{ $mascota->edad }} años</td>
            <td>{{ $mascota->otros_duenos ?: '-' }}</td>
            <td>
              <a href="{{ route('user.mascota.editar', $mascota->id_mascota) }}" class="btn-action" title="Editar mascota">✏️</a>
              <form action="{{ route('user.mascota.eliminar', $mascota->id_mascota) }}" method="POST" style="display:inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn-action btn-delete" title="Eliminar mascota" onclick="return confirm('¿Estás seguro de que quieres eliminar a {{ $mascota->nombre }} de tu lista? Recuerda que los datos del animal permanecerán en nuestra base de datos.')">
        🗑️
    </button>
</form>



              
            </td>
        </tr>
        @empty
        <tr>
          <td colspan="7">No tienes mascotas registradas.</td>
        </tr>
      @endforelse
      </tbody>



      </table>
    </div>
  </section>
</main>
</body>
</html>



