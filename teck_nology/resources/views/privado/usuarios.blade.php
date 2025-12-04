<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="{{ asset('css/estilo_gestionclien.css') }}">
</head>
<body>
    <div class="container">
        <aside class="sidebar"> 
            <div class="logo">
                <img src="{{ asset('imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png') }}" alt="Teck_Nology-Hollow" class="logo-img">
            </div>
            <ul class="nav-links">
                <li><a href="{{ url('privado/home') }}">Home</a></li>                
                <li><a href="{{ url('privado/inventario') }}">Inventario</a></li>               
                <li class="active"><a href="{{ url('usuarios') }}">Usuarios</a></li>
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
                <h1>USUARIOS DEL SISTEMA</h1>
                <div class="info-usuario">
                    <span>Administrador</span>
                </div>
            </div>
                <section class="seccion_inventario" id="contenido">
                <div class="fila-categorias-agregar">
                    <div class="categorias">
                        <a class="categoria-btn" data-usuario="usuarios">Empleados</a>
                        <a class="categoria-btn" data-cliente="cliente">Clientes</a>
                    </div>
            </div>

            <div class="contenedor-tabla-usuarios">
                <div class="barra-herramientas">
                    <div class="busqueda">
                         <form id="form-busqueda-usuarios" data-url="/usuarios/buscar" data-target=".tabla-contenedor">
                             <input type="text" name="query" class="campo-busqueda" placeholder="Buscar usuario...">
                            <button type="submit" class="boton-buscar">Buscar</button>
                        </form>
                    </div>
                    <a href="{{ url('usuarios/crear') }}" class="boton-agregar"> + Agregar Usuario</a>
                </div>
                <div class="tabla-contenedor">
                    @include('partials.tabla_usuario', ['usuarios' => $usuarios])
                    @include('partials.tabla_clientes', ['clientes' => $clientes])
                   
                </div>
                <div class="paginacion">
                    {{ $usuarios->links() }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>
