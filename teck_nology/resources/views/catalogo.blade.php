<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teck_nology-Hollow</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>

<body>

<header>
    <div class="header">
        <div class="logo-container">
            <img src="imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png" alt="" class="logo">
        </div>
    </div>

    <div class="header-derecha">
        <form class="buscador" action="resultados.html" method="get">
            <input type="search" name="q" placeholder="Buscar...">
        </form>

        <nav class="menu-links">
            <a href="../users/login.html" class="inicio" title="Iniciar Sesión">
                <img src="../imagenes/usuario.png" alt="Iniciar Sesión" class="icono-nav">
            </a>
            <a href="carrito.html" class="carrito" title="carrito">
                <img src="../imagenes/carrito.png" alt="carrito" class="icono-nav">
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

    <!-- BOTONES DE CATEGORÍAS -->
    <div class="opciones-clasificacion">
        <a href="{{ route('catalogo', ['categoria' => 1]) }}" class="chip-categoria">Computadoras</a>
        <a href="{{ route('catalogo', ['categoria' => 2]) }}" class="chip-categoria">Moviles</a>
        <a href="{{ route('catalogo', ['categoria' => 3]) }}" class="chip-categoria">Accesorios</a>
        <a href="{{ route('catalogo', ['categoria' => 4]) }}" class="chip-categoria">Juegos</a>
    </div>

    <!-- BOTONES DE ORDEN -->
    <div class="opciones-ordenar">
        <a href="{{ route('catalogo') }}" class="boton-ordenar">Productos</a>
        <a href="{{ route('catalogo', ['orden' => 'asc']) }}" class="boton-ordenar">Precio ascendente</a>
        <a href="{{ route('catalogo', ['orden' => 'desc']) }}" class="boton-ordenar">Precio descendiente</a>
        <a href="{{ route('catalogo', ['orden' => 'ofertas']) }}" class="boton-ordenar">Ofertas</a>
    </div>

    <!-- CUADRÍCULA DE PRODUCTOS -->
    <div class="productos-cuadricula">

        @forelse ($productos as $p)
        <div class="producto-tarjeta">
            <div class="producto-imagen">
                <img src="{{ $p->imagen ?? '/imagenes/default.jpg' }}" alt="{{ $p->nombre }}">
            </div>

            <div class="producto-info">
                <p class="producto-nombre">{{ $p->nombre }}</p>
                <p class="producto-precio">${{ $p->precio }}</p>

                @if ($p->oferta ?? false)
                    <span class="oferta-tag">Oferta</span>
                @endif
            </div>
        </div>
        @empty
            <p>No hay productos disponibles.</p>
        @endforelse

    </div>

    <!-- PAGINACIÓN -->
    <div class="paginacion">
        {{ $productos->links() }}
    </div>

</section>

</div>
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
                        loading="lazy">
                    </iframe>
                </div>

                <div class="info-contacto">
                    <p class="direccion-texto">🏢 Tecnológico Nacional de México Campus Iztapalapa.</p>
                    <p class="telefono-texto">📞 Número telefónico: 55-12-34-56-78</p>
                    <p class="horario-texto">🕒 Horario: Lunes a Viernes 9:00 AM - 6:00 PM.</p>
                </div>
            </div>

        </section>
    </div>
</div>

</body>
</html>
