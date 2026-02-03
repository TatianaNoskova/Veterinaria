<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro - Veterinaria</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/loginregistro.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <header>
    <div class="top-banner"> 
      <div class="logo">
        <a href="../index.html">
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

  <main class="container mt-5">
    <h2 class="text-center">Crear cuenta</h2>
    <div class="row justify-content-center">
      <div class="col-md-6">
           @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        <form action="{{ route('registro') }}" method="POST">

           @csrf
          
          <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="correo_electronico"  required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password"required>
          </div>
          <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirmar contraseña</label>
            <input type="password" class="form-control" id="confirm_password" name="password_confirmation" required>
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Registrarse</button>
          </div>
        </form>
        <div class="text-center mt-3">
          <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
        </div>
      </div>
    </div>
  </main>

  <footer>
    <p>Av. Corrientes 2037, Balvanera - C1001<br>
    Ciudad Autónoma de Buenos Aires<br>
    Tel: (011) 5032-0076</p>
  </footer>

</body>
</html>
