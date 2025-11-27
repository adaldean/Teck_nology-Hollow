<!DOCTYPE html>
<html lang="es">
<head> 
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teck_nology-Hollow</title>
  <link rel="icon" href="#">
  {{-- Usar la función 'asset()' para las rutas estáticas --}}
  <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
</head>
<body>
    <header>
   <div class="header">
       <div class="logo-container">
           {{-- Usar la función 'asset()' para la ruta de la imagen --}}
           <img src="{{ asset('imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png') }}" alt="" class="logo">
       </div>
   </div>
    <div class="header-derecha">
      <form class="buscador" action="{{ url('resultados') }}" method="get">
        <input type="search" name="q" placeholder="Buscar...">
      </form>

      <nav class="menu-links">
        {{-- Ajustar rutas a URLs de Laravel si corresponden --}}
        <a href="{{ url('privado/login') }}" class="inicio" title="Iniciar Sesión">
            <img src="{{ asset('imagenes/usuario.png') }}" alt="Iniciar Sesión" class="icono-nav">
        </a>
        <a href="{{ url('carrito') }}" class="carrito" title="carrito">
          <img src="{{ asset('imagenes/carrito.png') }}" alt="carrito" class="icono-nav">
        </a>
      </nav>
    </div>
  </header>

  <main>
    <h1>Filtrar y ordenar</h1>
    
    <div class="contenido-principal">
      <aside class="panel-filtros">
          
          <div class="filtro-grupo">
              <label>Palabras clave</label>
              <div class="chips-container">
                  <span class="chip">Az <span class="cerrar-chip">x</span></span>
                  <span class="chip">A <span class="cerrar-chip">x</span></span>
                  <span class="chip">S <span class="cerrar-chip">x</span></span>
              </div>
          </div>
              
          <div class="filtro-grupo desplegable">
              <input type="checkbox" id="filtro-color" class="filtro-checkbox">
              <label for="filtro-color" class="filtro-header">
                  <span>Color</span>
                  <span class="flecha">▼</span>
              </label>
              <div class="filtro-contenido">
                  <div><input type="checkbox" checked>*</div>
                  <div><input type="checkbox" checked>*</div>
                  <div><input type="checkbox" checked>*</div>
              </div>
          </div>
              
          <div class="filtro-grupo desplegable">
              <input type="checkbox" id="filtro-marca" class="filtro-checkbox">
              <label for="filtro-marca" class="filtro-header">
                  <span>Marca</span>
                  <span class="flecha">▼</span>
              </label>
              <div class="filtro-contenido">
                  <div><input type="checkbox" checked>*</div>
                  <div><input type="checkbox">*</div>
                  <div><input type="checkbox" checked>*</div>
              </div>
          </div>
              
          <div class="filtro-grupo desplegable">
              <input type="checkbox" id="filtro-precio" class="filtro-checkbox">
              <label for="filtro-precio" class="filtro-header">
                  <span>Precio</span>
                  <span class="flecha">▼</span>
              </label>
              <div class="filtro-contenido">
                  <div class="rango-precio-valor">$0-$100</div>
                  <input type="range" min="0" max="100" value="30" class="slider"> 
              </div>
          </div>
      </aside>
        
        <section class="area-productos">
        <div class="opciones-clasificacion">
          {{-- Estos chips ahora son útiles para navegar o filtrar --}}
          <a href="{{ url('categoria/computadoras') }}" class="chip-categoria">Computadoras</a>
          <a href="{{ url('categoria/moviles') }}" class="chip-categoria">Moviles</a>
          <a href="{{ url('categoria/accesorios') }}" class="chip-categoria">Accesorios</a>
          <a href="{{ url('categoria/consolas') }}" class="chip-categoria">Juegos</a>         
        </div>
          
          <div class="opciones-ordenar">
            <button class="boton-ordenar activo">Productos</button>
            <button class="boton-ordenar">Precio ascendente</button>
            <button class="boton-ordenar">Precio descendiente</button>
            <button class="boton-ordenar">Ofertas </button>
          </div>
          
          {{-- INTEGRACIÓN DEL FOREACH Y LA SOLUCIÓN AL ERROR --}}
          <div class="productos-cuadricula">
            {{-- La directiva @foreach ahora envuelve la tarjeta de producto --}}
            @foreach($productos as $producto)
            <div class="producto-tarjeta">
              {{-- Se asume que 'producto-imagen' debe mostrar una imagen --}}
              <div class="producto-imagen">
                {{-- Esto asume que tienes un campo 'imagen' en tu objeto producto --}}
                <img src="{{ asset('imagenes/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
              </div>
              <div class="producto-info">
                {{-- Mostrar nombre y precio usando la sintaxis de Blade {{ ... }} --}}
                <p class="producto-nombre">{{ $producto->nombre }}</p>
                <p class="producto-precio">${{ $producto->precio }}</p>
              </div>
            </div>
            @endforeach
          </div>
          {{-- FIN DE LA INTEGRACIÓN DEL FOREACH --}}
          
          <div class="paginacion">
            <a href="#">← Anterior</a>
            <a href="#" class="pagina-actual">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <span>...</span>
            <a href="#">67</a>
            <a href="#">68</a>
            <a href="#">Siguiente →</a>
          </div>
        </section>
      </div>
    </main>
</body>
</html>