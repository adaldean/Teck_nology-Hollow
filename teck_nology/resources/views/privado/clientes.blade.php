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
                        <a class="categoria-btn" href={{ url('privado/usuarios') }}>Empleados</a>
                        <a class="categoria-btn active">Clientes</a>
                    </div>
            </div>

            <div class="contenedor-tabla-usuarios">
                <div class="barra-herramientas">
                    <div class="busqueda">
                        <input type="text" class="campo-busqueda" placeholder="Buscar usuario...">
                        <button class="boton-buscar">Buscar</button>
                    </div>
                    <a href="{{ url('usuarios/crear') }}" class="boton-agregar"> + Agregar Usuario</a>
                </div>
                <div class="tabla-contenedor">
                    <table class="tabla-usuarios">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOMBRE</th>
                                <th>EMAIL</th>
                                <th>TELEFONO</th>
                                <th>DIRECCION</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->id_cliente }}</td>
                                    <td>{{ $cliente->nombre }}</td>
                                    <td>{{ $cliente->email }}</td>
                                    <td>{{ $cliente->telefono}}</td>
                                    <td>{{ $cliente->direccion }}</td>
                                    <td>
                                        <a href="{{ url('cliente/'.$cliente->id.'/editar') }}" class="boton-editar">Editar</a>
                                        <form action="{{ url('cliente/'.$cliente->id.'/eliminar') }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="boton-eliminar">Eliminar</button>
                                       </form>
                                    </td>
                                </tr>
                            @endforeach

                            @empty($cliente)
                                <tr>
                                    <td colspan="6" style="text-align:center;">No hay usuarios registrados.</td>
                                </tr>
                            @endempty
                        </tbody>
                    </table>
                </div>
                <div class="paginacion">
                    
                </div>
            </div>
        </main>
    </div>
</body>
</html>
