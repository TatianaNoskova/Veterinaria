<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificación de empleados</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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

   <div class="admin-header">
        <div class="admin-header-left">
          <a href="{{ route('admin.dashboard') }}">
          <img src="{{ asset('img/admin.png') }}" alt="Admin Icono" class="admin-icon">
        </div>
        </a>
        <div class="admin-header-center">
          <div class="admin-header-text">
            
            <h1>Modificación de empleados</h1>
          </div>
        </div>
      
        <div class="admin-header-right">
          <a href="{{ route('admin.empleados.index') }}" class="logout" title="Volver al panel de gestion de empleados">Volver</a>
        </div>
    </div>

    <main class="admin-usuarios-container">
  <section class="form-section">
    <h2>Modificar veterinario</h2>

    @if (isset($errors) && $errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

  
  <form id="registro-form" action="{{ route('admin.empleados.update', $empleado->id_usuario) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $empleado->nombre) }}" required>

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="apellido" value="{{ old('apellido', $empleado->apellido) }}" required>

    <label for="dni">DNI:</label>
    <input type="text" id="dni" name="dni" value="{{ old('dni', $empleado->dni) }}" required>

    <label for="correo_electronico">Correo electrónico:</label>
    <input type="email" id="correo_electronico" name="correo_electronico" value="{{ old('correo_electronico', $empleado->correo_electronico) }}" required>

    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $empleado->telefono) }}">

    <label for="direccion">Dirección:</label>
    <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $empleado->direccion) }}">

    <label for="matricula">Matrícula:</label>
    <input type="text" id="matricula" name="matricula" value="{{ old('matricula', $empleado->matricula) }}">

    <label for="especialidad">Especialidad:</label>
    <input type="text" id="especialidad" name="especialidad" value="{{ old('especialidad', $empleado->especialidad) }}">

    <label for="rol">Rol:</label>
    <select id="rol" name="rol">
        <option value="cliente" {{ $empleado->rol == 'cliente' ? 'selected' : '' }}>Cliente</option>
        <option value="empleado" {{ $empleado->rol == 'empleado' ? 'selected' : '' }}>Empleado</option>
        <option value="admin" {{ $empleado->rol == 'admin' ? 'selected' : '' }}>Administrador</option>
    </select>

    <label for="password">Nuevo password (si es necesario cambiarlo):</label>
    <input type="password" id="password" name="password">

    <button type="submit">Guardar cambios</button>
    <a href="{{ route('admin.empleados.index') }}" class="btn btn-secondary" >Volver</a>
</form>


  </section>
</main>

  
</body>
</html>
