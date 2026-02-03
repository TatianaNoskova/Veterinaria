<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de empleados</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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

   <div class="admin-header">
        <div class="admin-header-left">
          <a href="{{ route('admin.dashboard') }}">
          <img src="../img/admin.png" alt="Admin Icono" class="admin-icon">
        </div>
        </a>
        <div class="admin-header-center">
          <div class="admin-header-text">
            
            <h1>Gestión de empleados</h1>
          </div>
        </div>
      
        <div class="admin-header-right">
          <a href="{{ route('admin.dashboard') }}" class="logout" title="Volver al panel de administrador">Volver</a>
        </div>
    </div>

<main class="admin-usuarios-container">

  <section class="modo-registro">
    <h2>Selecciona actividad</h2>
    <ul class="modo-registro-botones">
      <li><a href="#nuevo-empleado" class="btn-link">Registrar nuevo veterinario</a></li>
      <li><a href="#empleados-registrados" class="btn-link">Ver y gestionar empleados</a></li>
    </ul>
    </section>

  <section class="form-section" id="nuevo-empleado">
    <h2>Registrar nuevo veterinario</h2>

<form id="registro-form" method="POST" action="{{ route('admin.empleados.store') }}" class="formulario-registro">
          @csrf
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif 


        <input id="nombre" name="nombre" placeholder="Nombre" type="text" required>
        <input id="apellido" name="apellido" placeholder="Apellido" type="text" required>
        <input id="dni" name="dni" placeholder="DNI" type="text" required>
        <input id="correo_electronico" name="correo_electronico" placeholder="Correo electrónico" type="email" required>
        <input id="telefono" name="telefono" placeholder="Teléfono" type="text">
        <input id="direccion" name="direccion" placeholder="Dirección" type="text">
        <input type="text" name="matricula" placeholder="Matrícula profesional" required>
        <input type="text" name="especialidad" placeholder="Especialidad">
        <input id="password" name="password" placeholder="Contraseña" type="password" required>
        <input id="password_confirmation" name="password_confirmation" placeholder="Confirmar contraseña" type="password" required>
        <button type="submit">Agregar veterinario</button>
    </form>
  </section>

  <section class="usuarios-registrados" id="empleados-registrados">
    <h2>Veterinarios registrados</h2>
    <div class="tabla-usuarios">
      <table>
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Matrícula</th>
            <th>Especialidad</th>
            <th>Acciones</th>
          </tr>
        </thead>
       <tbody>
  @foreach ($empleados as $empleado)
    <tr>
      <td>{{ $empleado->nombre }}</td>
      <td>{{ $empleado->apellido }}</td>
      <td>{{ $empleado->dni ?? '—' }}</td>
      <td>{{ $empleado->correo_electronico ?? '—' }}</td>
      <td>{{ $empleado->telefono ?? '—' }}</td>
      <td>{{ $empleado->direccion ?? '—' }}</td>
      <td>{{ $empleado->matricula ?? '—' }}</td>
      <td>{{ $empleado->especialidad ?? '—' }}</td>
      <td class="acciones">
        <a href="{{ route('admin.empleados.edit', $empleado->id_usuario) }}" class="btn-action" title="Modificar">✏️</a>
        <form action="{{ route('admin.empleados.destroy', $empleado->id_usuario) }}" method="POST" style="display:inline-block;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn-action btn-delete" title="Eliminar" onclick="return confirm('¿Eliminar el empleado?')">🗑️</button>
        </form>
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