<!DOCTYPE html>
<html lang="es">
<head> 
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teck_nology-Hollow</title>
  <link rel="stylesheet" href="css/estiloinve.css">
</head>
<body>

<header>
   <div class="header">
       <div class="logo-container">
           <img src="imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png" class="logo">
       </div>
   </div>

   <div class="header-derecha">
      <form class="buscador" action="#" method="get">
        <input type="search" name="q" placeholder="Buscar...">
      </form>

      <nav class="menu-links">
        <a href="#"><img src="../imagenes/usuario.png" class="icono-nav"></a>
        <a href="#"><img src="../imagenes/carrito.png" class="icono-nav"></a>
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
</aside>

<section class="area-productos">

    <div class="opciones-clasificacion">
        <a href="#" class="chip-categoria">Computadoras</a>
        <a href="#" class="chip-categoria">Moviles</a>
        <a href="#" class="chip-categoria">Accesorios</a>
        <a href="#" class="chip-categoria">Juegos</a>         
    </div>

    <div class="opciones-ordenar">
        <button class="boton-ordenar activo">Productos</button>
        <button class="boton-ordenar">Precio ascendente</button>
        <button class="boton-ordenar">Precio descendente</button>
        <button class="boton-ordenar">Ofertas</button>
    </div>

    <div class="productos-cuadricula">

        @foreach($productos as $p)
        <div class="producto-tarjeta">
            <div class="producto-imagen"></div>
            <div class="producto-info">
                <h3 class="producto-nombre">{{ $p->nombre }}</h3>
                <p class="producto-descripcion">{{ $p->descripcion }}</p>
                <p class="producto-precio">${{ $p->precio }}</p>
            </div>
        </div>
        @endforeach

    </div>

</section>

</div>
</main>

</body>
</html>
