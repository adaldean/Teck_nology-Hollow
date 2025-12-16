<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teck_nology-Hollow</title>
  <link rel="icon" href="{{ asset('favicon.ico') }}"> 
  <meta name="csrf-token" content="{{ csrf_token() }}">
  {{-- Main site styles (keep product card look consistent with catalog) --}} 
  <link rel="stylesheet" href="{{ asset('css/estilo.css') }}"> 
  <link rel="stylesheet" href="{{ asset('css/estilo_carrito.css') }}"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="{{ auth()->check() && optional(auth()->user())->id_rol == 1 ? 'admin-theme' : '' }}">

    <div class="header">
        <div class="logo-container">
            <img src="{{ asset('imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png') }}" alt="Logo de Tecknology" class="logo">
        </div>
    </div>

    <div class="main-content">

    <div class="product-grid">
  <div id="carrito-contenedor" class="carrito-contenedor">
        @if(!empty($cart) && count($cart) > 0)
          <div class="productos-cuadricula">
            @foreach($cart as $item)
              <div class="producto-tarjeta" data-id="{{ $item['id'] ?? '' }}" data-nombre="{{ $item['nombre'] ?? '' }}">
                <div class="producto-imagen">
                  @php
                    $img = $item['imagen_url'] ?? null;
                    if (!$img) {
                      $img = asset('imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png');
                    }
                  @endphp
                  <img src="{{ $img }}" alt="{{ $item['nombre'] ?? '' }}">
                </div>
                <div class="producto-info">
                  <p class="producto-nombre">{{ $item['nombre'] ?? '' }}</p>
                  <p class="producto-precio">${{ number_format($item['precio'] ?? 0, 2) }}</p>
                  <p>Cantidad: <span class="cart-quantity">{{ $item['cantidad'] ?? 1 }}</span></p>
                  <p>
                    <button class="card-qty-btn btn-decrement" data-id="{{ $item['id'] ?? '' }}" data-nombre="{{ $item['nombre'] ?? '' }}">−</button>
                    <button class="card-qty-btn btn-increment" data-id="{{ $item['id'] ?? '' }}" data-nombre="{{ $item['nombre'] ?? '' }}">+</button>
                    <button class="card-remove-btn btn-remove" data-id="{{ $item['id'] ?? '' }}" data-nombre="{{ $item['nombre'] ?? '' }}">Eliminar</button>
                  </p>
                  <p>Subtotal: ${{ number_format( ($item['precio'] ?? 0) * ($item['cantidad'] ?? 1), 2) }}</p>
                </div>
              </div>
            @endforeach
          </div>

          @php
            $total = 0;
            foreach($cart as $it) {
              $total += ($it['precio'] ?? 0) * ($it['cantidad'] ?? 1);
            }
          @endphp
          <div class="carrito-total"><h3>Total: ${{ number_format($total, 2) }}</h3></div>
        @else
          <p class="carrito-vacio">Tu carrito está vacío.</p>
        @endif
      </div>

    </div>

        <button type="button" class="pay-button" onclick="pagar()">Pagar</button>

    </div>

    <div class="footer-navigation">
        <a href="{{ url('/') }}" class="nav-link">
            <i class="fas fa-home"></i>
            <span>Inicio</span>
        </a>
        <a href="{{ url('login') }}" class="nav-link">
            <i class="fas fa-user"></i>
            <span>Cuenta</span>
        </a>
    </div>


    <div id="modalLogin" class="modal" style="display:none;">
      <div class="modal-content">
        <span class="close" onclick="cerrarModal('modalLogin')">&times;</span>
        <h2>Inicia sesión</h2>

        <label>Correo</label>
        <input type="email" id="correoLogin">

        <label>Contraseña</label>
        <input type="password" id="passwordLogin">

        <button type="button" class="submit-button" onclick="iniciarSesion()">Iniciar sesión</button>
      </div>
    </div>


    <div id="modalPago" class="modal" style="display:none;">
      <div class="modal-content">
        <span class="close" onclick="cerrarModal('modalPago')">&times;</span>
        <h2>Datos de la transacción</h2>

        <form id="formPago" method="POST" action="{{ route('carrito.checkout') }}">
          @csrf
          <label>Origen</label>
          <input type="text" name="origen" placeholder="Cuenta origen" required>

          <label>Destino</label>
          <input type="text" name="destino" placeholder="Cuenta destino" required>

          <label>Comisión</label>
          <input type="number" name="comision" placeholder="$" required>

          <label>Concepto / Método</label>
          <input type="text" name="concepto" placeholder="Motivo / método del pago">

          <label>Referencia</label>
          <input type="text" name="referencia" placeholder="Referencia o folio">

          <label>Tipo de Operación</label>
          <input type="text" name="tipo_operacion" placeholder="Transferencia / Depósito">

          <label>Folio</label>
          <input type="text" name="folio" placeholder="Número de folio">

          <label>Fecha</label>
          <input type="date" name="fecha" required>

          <button type="submit" class="submit-button">Realizar pago</button>
        </form>
      </div>
    </div>

  <!-- Aquí va tu JS, al final del body -->
  <script src="{{ asset('javascript/carritopago.js') }}"></script>
</body>
</html>
