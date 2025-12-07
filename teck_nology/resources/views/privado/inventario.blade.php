<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="icon" href="#">
    <link rel="stylesheet" href="{{ asset('css/estiloinve.css') }}">
</head>
<body>
    
    <div class="container">
        <aside class="sidebar">
            <div class="logo">
                <img src="{{ asset('imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png') }}" alt="Tr.sneakers Logo" class="logo-img">
            </div>
            <ul class="nav-links">
                <li><a href="{{ url('privado/home') }}">Home</a></li> 
                <li class="active"><a href="#">Inventario</a></li>
                <li><a href="{{ asset('privado/usuarios')}}">Usuarios</a></li>
                <li><a href="#">Configuración</a></li>
                <li>                
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-logout">Cerrar Sesión</button>
                    </form>
                </li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="header">
                <h1>INVENTARIO</h1>
                <div class="user-info">
                    <span>Administrador</span>
                </div>
            </div>
            <section class="seccion_inventario" id="contenido">
                <div class="fila-categorias-agregar">
                    <div class="categorias">
                        <a  class="categoria-btn" data-categoria="todos">Todos</a>
                        <a  class="categoria-btn" data-categoria="computadoras">Computadoras</a>
                        <a  class="categoria-btn" data-categoria="moviles">Moviles</a>
                        <a  class="categoria-btn" data-categoria="consolas">Videojuegos</a>
                        <a  class="categoria-btn" data-categoria="accesorios">Accesorios</a>
                    </div>
                    <div class="contenedor-boton-agregar"></div>
                </div>

                <div class="contenedor-tabla-productos">
                    <div class="barra-herramientas">
                        <div class="busqueda">
                            <form id="form-busqueda">
                                <input type="text" name="query" id="campo-busqueda" class="campo-busqueda" placeholder="Buscar producto...">
                                <button type="submit" class="boton-buscar">Buscar</button>
                            </form>
                        </div>

                        <a href="{{ url('inventario/crear') }}" class="boton-agregar"> + Agregar Producto</a>
                    </div>

                    <div class="tabla-contenedor">
                        @include('partials.tabla_productos', ['productos' => $productos])
                    </div>


                <div class="paginacion">
                    <a href="#" class="pagina-btn">1</a>
                    <a href="#" class="pagina-btn active">2</a>
                    <span class="puntos">...</span>
                    <a href="#" class="siguiente-btn">Siguiente →</a>
                </div>
            </section>
        </main>
    </div>
</body>
<script src="{{ asset('javascript/busqueda.js') }}"></script>

</html>
