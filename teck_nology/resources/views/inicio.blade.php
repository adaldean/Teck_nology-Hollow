<!DOCTYPE html>
<html lang="es">
<head> 
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teck_nology-Hollow</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
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

  <script src="{{ asset('javascript/carritopago.js') }}"></script>
    {{-- Site menu with anchors to company sections --}}
    <nav class="site-menu">
      <a href="#quienes-somos" class="menu-item">Quiénes somos</a>
      <a href="#mision" class="menu-item">Misión</a>
      <a href="#vision" class="menu-item">Visión</a>
    </nav>

    @include('partials.tabla_catalogo', ['productos' => $productos])

    {{-- Company informational sections --}}
    <section id="quienes-somos" class="about-section">
      <div class="about-inner">
        <h2>Quiénes somos</h2>
        <p>Teck_nology-Hollow es un proyecto de ejemplo que reúne tecnología y cultura, ofreciendo una selección curada de productos electrónicos con atención local.</p>
      </div>
    </section>

    <section id="mision" class="about-section alt">
      <div class="about-inner">
        <h2>Misión</h2>
        <p>Nuestra misión es conectar a las personas con tecnología accesible, confiable y con servicio humano. Buscamos calidad y responsabilidad en cada venta.</p>
      </div>
    </section>

    <section id="vision" class="about-section">
      <div class="about-inner">
        <h2>Visión</h2>
        <p>Ser un referente local en comercio electrónico responsable, promoviendo innovación, servicio y sostenibilidad.</p>
      </div>
    </section>
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
<script src="{{ asset('javascript/catalogo-parallax.js') }}"></script>
<script src="{{ asset('javascript/button-effects.js') }}"></script>
</html>