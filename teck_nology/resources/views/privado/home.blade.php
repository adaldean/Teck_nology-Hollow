<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
                <li class=active><a>Home</a></li>
                <li><a href="{{ url('privado/inventario')}}">Inventario</a></li>
                <li><a href="{{ asset('/../usuarios')}}">Usuarios</a></li>
                <li><a href="#">Configuración</a></li>
                <li>                
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-logout">Cerrar Sesión</button>
                    </form>
                </li>
            </ul>
        </aside>
    <div class="header">
        <h1>Sistema web de inventarios</h1>
        <div class="user-info">Bienvenido, Admin</div>
    </div>
         @if(session('success'))
            <div id="alerta-exito"> Bienvenido,
            {{ auth()->user()->nombre }}! {{ session('success') }}
            </div>
         @endif

    <div class="fila-categorias-agregar">
        <h2 style="font-size: 1.4rem; font-weight: 600;">Resumen general</h2>
    </div>

    <div class="categorias">
        <div class="producto-card">
            <img src="/icons/ordenes.png" alt="Órdenes" style="width:40px; margin-bottom:10px;">
            <h3>Órdenes de Compra</h3>
            <p></p>
        </div>
        <div class="producto-card">
            <img src="/icons/recibidos.png" alt="Recibidos" style="width:40px; margin-bottom:10px;">
            <h3>Compras Recibidas</h3>
            <p>3 registradas</p>
        </div>
        <div class="producto-card">
            <img src="/icons/devoluciones.png" alt="Devoluciones" style="width:40px; margin-bottom:10px;">
            <h3>Devoluciones</h3>
            <p>2 registradas</p>
        </div>
        <div class="producto-card">
            <img src="/icons/ventas.png" alt="Ventas" style="width:40px; margin-bottom:10px;">
            <h3>Ventas</h3>
            <p>3 registradas</p>
        </div>
        <div class="producto-card">
            <img src="/icons/proveedores.png" alt="Proveedores" style="width:40px; margin-bottom:10px;">
            <h3>Proveedores</h3>
            <p>2 activos</p>
        </div>
        <div class="producto-card">
            <img src="/icons/productos.png" alt="Productos" style="width:40px; margin-bottom:10px;">
            <h3>Productos</h3>
            <p>3 en catálogo</p>
        </div>
        <div class="producto-card">
            <img src="/icons/usuarios.png" alt="Usuarios" style="width:40px; margin-bottom:10px;">
            <h3>Usuarios</h3>
            <p>1 administrador</p>
        </div>
    </div>
</div>
</body>
<script src="../javascript/bienvenido.js"></script>
</html>