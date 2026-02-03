<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Veterinaria - Amigos son los amigos</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  

 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  


</head>
<body>

<header>
  

  <div class="top-banner">
    <div class="logo-area">
      <div class="logo">
        <img src="{{ asset ('img/logovete.png') }}" alt="Logo Veterinaria">
        <div> 
          <h1>Amigos son los amigos</h1>
          <p>VETERINARIA</p>
        </div>
      </div> 
    </div>

  <div class="contact-info">
      <p>
        Av. Corrientes 2037<br>
        CABA - C1001<br>
        Teléfono: 011 5032-0076<br>
        Lunes a Viernes - 10 a 18hrs<br>
        Sábado - 10 a 14hrs
      </p>
    </div>
  </div>
</header>


  



  <div class="sub-header-links">
   <a href="#" class="btn-link">Ver Reseñas</a>
  
    <div class="login-block text-end">
      <a href="{{ route ('login') }}" class="btn-link">Login</a>
      <div>
        <small>¿No tienes cuenta? <a href="{{ route ('registro') }}">Regístrate aquí</a></small>
      </div>
    </div>
  </div>

  <main>

@if(Auth::check())
    <p class="text-success">¡Estás conectado como {{ Auth::user()->correo_electronico }}!</p>
    <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-danger">Logout</button>
</form>
@endif


  
    <div class="grid-cards">
      
      <div class="card card-vertical">
        <img src="img/atencion.jpg" alt="Atención especializada">
        <div class="card-text">
          <h2>Atención especializada</h2>
          <p>Ofrecemos servicios profesionales de calidad a mascotas caninas y felinas, mediante un
            trato personalizado, la permanente capacitación de sus profesionales, la incorporación de nuevas tecnologías
            y sobre todo, el amor a las mascotas</p>
          <!-- <a href="#">Conoce nuestro trabajo</a> -->
        </div>
      </div>
    
      
      <div class="card card-horizontal">
        <img src="img/control.jpg" alt="Control clínico">
        <div class="card-text">
          <h2>Control clínico</h2>
          <p>Contamos con todas las herramientas para prevenir y curar. Desde revisión rutinaria
            hasta emergencias</p>
          <!-- <a href="#">Conoce más sobre el servicio</a> -->
        </div>
      </div>
    
      
      <div class="card card-horizontal">
        <img src="img/analisis.jpg" alt="Laboratorio">
        <div class="card-text">
          <h2>Laboratorio</h2>
          <p>Tenemos laboratorio propio, lo que nos permite procesar análisis rápidamente.</p>
         <!-- <a href="#">Más información</a> -->
        </div>
      </div>
    </div>
    
    <!-- <div class="text-center my-4">
      <a href="pages/contacto.html" class="btn-contact">Contáctanos</a>
    </div> --> 

  </main>

  
 
  <footer>
    <p>Av. Corrientes 2037, Balvanera - C1001<br>
    Ciudad Autónoma de Buenos Aires<br>
    Tel: (011) 5032-0076</p>
  </footer>

</body>
</html>


