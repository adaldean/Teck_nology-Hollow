<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teck_nology-Hollow</title>
    <link rel="icon" href="../../static/images/Tech_Icon.png"> 
    <link rel="stylesheet" href="../css/estilo_carrito.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <div class="header">
        <div class="logo-container">
            <img src="{{ asset('imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png') }}" alt="Logo de Tecknology" class="logo">
        </div>
    </div>

    <div class="main-content">

        <div class="product-grid">
            <div id="carrito-contenedor"></div>

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

        <form id="formPago">
          <label>Origen</label>
          <input type="text" placeholder="Cuenta origen" required>

          <label>Destino</label>
          <input type="text" placeholder="Cuenta destino" required>

          <label>Comisión</label>
          <input type="number" placeholder="$" required>

          <label>Concepto</label>
          <input type="text" placeholder="Motivo del pago">

          <label>Referencia</label>
          <input type="text" placeholder="Referencia o folio">

          <label>Tipo de Operación</label>
          <input type="text" placeholder="Transferencia / Depósito">

          <label>Folio</label>
          <input type="text" placeholder="Número de folio">

          <label>Fecha</label>
          <input type="date" required>

          <button type="submit" class="submit-button">Realizar pago</button>
        </form>
      </div>
    </div>

    <!-- Aquí va tu JS, al final del body -->
    <script src="../javascript/carritopago.js"></script>
</body>
</html>
