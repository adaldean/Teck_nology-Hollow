<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tr.sneakers - Inventario</title>
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
                <li><a href="#">Home</a></li>
                <li class="active"><a href="#">Inventario</a></li>
                <li><a href="{{ asset('usuarios')}}">Usuarios</a></li>
                <li><a href="#">Configuración</a></li>
                <li><a href="#">Cerrar Sesión</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="header">
                <h1>INVENTARIO</h1>
                <div class="user-info">
                    <span>Administrador</span>
                </div>
            </div>

            {{-- Mensaje de login exitoso --}}
            @if(session('success'))
                <div class="alerta-exito">
                    {{ session('success') }}
                </div>
            @endif

            <section class="seccion_inventario" id="contenido">
                <div class="fila-categorias-agregar">
                    <div class="categorias">
                        <a class="categoria-btn active">Computadoras</a>
                        <a class="categoria-btn">Moviles</a>
                        <a class="categoria-btn">Videojuegos</a>
                        <a class="categoria-btn">Accesorios</a>
                    </div>
                    <div class="contenedor-boton-agregar"></div>
                </div>

                <div class="contenedor-tabla-productos">
                    <div class="barra-herramientas">
                        <div class="busqueda">
                            <input type="text" class="campo-busqueda" placeholder="Buscar producto...">
                            <button class="boton-buscar">Buscar</button>
                        </div>
                        <a href="{{ url('inventario/crear') }}" class="boton-agregar"> + Agregar Producto</a>
                    </div>

                    <div class="tabla-contenedor">
                        <table class="tabla-productos">
                            <thead>
                                <tr>
                                    <th class="columna-checkbox"><input type="checkbox" class="checkbox-todos"></th>
                                    <th class="columna-id">ID</th>
                                    <th class="columna-nombre">NOMBRE</th>
                                    <th class="columna-descripcion">DESCRIPCIÓN</th>
                                    <th class="columna-precio">PRECIO</th>
                                    <th class="columna-stock">STOCK</th>
                                    <th class="columna-categoria">CATEGORIA</th>
                                    <th class="columna-proveedor">PROVEEDOR</th>
                                    <th class="columna-acciones">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $producto)
                                <tr class="fila-producto">
                                    <td class="columna-checkbox"><input type="checkbox" class="checkbox-producto"></td>
                                    <td class="columna-id">{{ $producto->id_producto }}</td>
                                    <td class="columna-nombre">{{ $producto->nombre }}</td>
                                    <td class="columna-descripcion">{{ Str::limit($producto->descripcion, 80) }}</td>
                                    <td class="columna-precio">${{ number_format($producto->precio, 2) }}</td>
                                    <td class="columna-stock">{{ $producto->stock }}</td>
                                    <td class="columna-categoria">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                                    <td class="columna-proveedor">{{ $producto->proveedor->nombre ?? 'Sin proveedor' }}</td>
                                    <td class="columna-acciones">
                                        <a href="{{ route('inventario.show', $producto->id_producto) }}" class="boton-ver">Ver</a>
                                        <a href="{{ url('inventario/editar/' . $producto->id_producto) }}" class="boton-editar">Editar</a>
                                        <button class="boton-eliminar">Eliminar</button>
                                    </td>
                                </tr>
                                @endforeach

                                @empty($productos)
                                <tr>
                                    <td colspan="9" style="text-align:center;">
                                        No hay productos registrados en este momento. Utilice el botón "Agregar Producto" para comenzar.
                                    </td>
                                </tr>
                                @endempty
                            </tbody>
                        </table>
                    </div>
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
</html>
