<!DOCTYPE html>
<html lang="es">
<head> 
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teck_nology-Hollow</title>
  <link rel="icon" href="#">
  {{-- Usar la función 'asset()' para las rutas estáticas --}{{-- para que no se les olvide --}} 
  <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
</head>
<body>
  <header>
   <div class="header">
       <div class="logo-container">
           <img src="{{ asset('imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png') }}" alt="" class="logo">
       </div>
   </div>
    <div class="header-derecha">
      <form class="buscador" action="{{ url('resultados') }}" method="get">
        <input type="search" name="q" placeholder="Buscar">
      </form>

      <nav class="menu-links">
        <a href="{{ url('../../login') }}" class="inicio" title="Iniciar Sesión">
            <img src="{{ asset('imagenes/usuario.png') }}" alt="Iniciar Sesión" class="icono-nav">
        </a>
        <a href="{{ url('carrito') }}" class="carrito" title="carrito">
          <img src="{{ asset('imagenes/carrito.png') }}" alt="carrito" class="icono-nav">
          <span id="carrito-count" class="carrito-count">0</span>
        </a>
      </nav>
    </div>
  </header>

  <main>
    @include('partials.tabla_catalogo', ['productos' => $productos])
  </main>

    <div class="seccion-mapa-inferior">
  <div class="contenedor-mapa-seccion">
    <section class="ubicacion-negocio">
      <h2 class="titulo-mapa">Localiza nuestro negocio.</h2>
      <div class="contenido-mapa">
        <div class="mapa-contenedor">
          <iframe 
            src="https://maps.google.com/maps?q=Tecnol%C3%B3gico+Nacional+de+M%C3%A9xico+Campus+Iztapalapa&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
            width="100%" 
            height="100%" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
        <div class="info-contacto">
          <p class="direccion-texto">🏢 Tecnológico Nacional de México Campus Iztapalapa.</p>
          <p class="telefono-texto">📞 Número telefónico: 55-12-34-56-78</p>
          <p class="horario-texto">🕒 Horario: Lunes a Viernes 9:00 AM - 6:00 PM.</p>
        </div>

        <div class="redes-sociales">
          <a href="https://facebook.com" target="_blank">
            <img src="ruta/facebook.png" alt="Facebook" class="icono-red">
          </a>
          <a href="https://twitter.com" target="_blank">
            <img src="ruta/twitter.png" alt="Twitter" class="icono-red">
          </a>
          <a href="https://instagram.com" target="_blank">
            <img src="ruta/instagram.png" alt="Instagram" class="icono-red">
          </a>
        </div>
      </div>
    </section>
  </div>
</div>
</body>
<script src="{{ asset('javascript/ordernar.js') }}"></script>
<script src="{{ asset('javascript/carritopago.js') }}"></script>
</html>