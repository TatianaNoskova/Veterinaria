<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Mis Facturas</title>
   <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
</head>
<body>

  <header>
    <div class="top-banner"> 
      <div class="logo">
        <a href="{{ route('index') }}" >
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
        Tel: 011 5032-0076<br>
        Lun–Vie 10–18hs | Sáb 10–14hs</p>
      </div> 
    </div>
  </header>

  <div class="user-header">
    <div class="user-header-left">
    <a href="{{ route('user.dashboard') }}">
      <img src="{{ asset('img/usuario.png') }}" alt="Ícono usuario" class="user-icon">
    </a>
  </div>
    <div class="user-header-center">
      <h1>💳 Mis Facturas</h1>
      <p>Revisa tus pagos y deudas pendientes</p>
    </div>
    <a href="{{ route('user.dashboard') }}" class="logout">Volver</a>
  </div>

  <main class="user-perfil container">
  <section class="total-deuda">
     <h3>Total Deuda Pendiente: <span>${{ number_format($totalDeudaPendiente, 2, ',', '.') }}</span></h3>
    <a href="#" class="btn-pagar">💳 Pagar ahora</a>
  </section>

<section class="facturas-lista">
    <h2>Resumen de facturación</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Veterinario</th>
                <th>Mascota</th>
                <th>Motivo</th>
                <th>Importe</th>
                <th>Estado</th>
                <th>Ver</th>
            </tr>
        </thead>
        <tbody>
            @foreach($facturas as $factura)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($factura->fecha)) }}</td> 
                    <td>{{ $factura->turno->veterinario->nombre }} {{ $factura->turno->veterinario->apellido }}</td> <!-- Имя и фамилия ветеринара -->
                    <td>{{ $factura->turno->mascota->nombre }}</td> <!-- Имя питомца -->
                    <td>{{ $factura->turno->motivo }}</td> <!-- Причина визита -->
                    <td>${{ number_format($factura->total, 2) }}</td> <!-- Форматируем сумму -->
                    <td>
                        <span class="estado {{ $factura->estado }}">{{ ucfirst($factura->estado) }}</span> <!-- Статус -->
                    </td>
                    <td><a href="#">📄</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>

</main>


</body>
</html>
