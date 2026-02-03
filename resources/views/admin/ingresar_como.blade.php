<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impersonal</title>
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
            
            <h1>Ingresar como otro usuario</h1>
          </div>
        </div>
      
        <div class="admin-header-right">
          <a href="{{ route('admin.empleados.index') }}" class="logout" title="Volver al panel de gestion de empleados">Volver</a>
        </div>
    </div>

    <main class="admin-usuarios-container">
  <section class="form-section">
    <h2>Ingresar como</h2>

    <table class="admin-table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($usuarios as $usuario)
        <tr>
            <td>{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
            <td>{{ $usuario->correo_electronico }}</td>
            <td>{{ $usuario->rol }}</td>
            <td>
                <form method="POST" action="{{ route('admin.impersonate.start', $usuario->id_usuario) }}" class="impersonate-form">
                    @csrf
                    <button type="submit" class="btn-ingresar">
                        Ingresar como {{ $usuario->rol }}
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>



    
</main>

  
</body>
</html>
