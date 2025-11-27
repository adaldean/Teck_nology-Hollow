<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tr.sneakers - Inventario</title>
    <link rel="icon" href="#">
    {{-- Ruta corregida para el CSS --}}
    <link rel="stylesheet" href="{{ asset('css/estiloinve.css') }}">
</head>
<body>
    
    <div class="container">
        <aside class="sidebar">
            <div class="logo">
                {{-- Ruta corregida para el logo --}}
                <img src="{{ asset('imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png') }}" alt="Tr.sneakers Logo" class="logo-img">
            </div>
            
            <ul class="nav-links">
                <li><a href="">Home</a></li>

                <li class="dropdown active">
                    <a href="#">Inventario</a>
                    <ul class="submenu">
                        <li><a href="{{ url('inventario/computadoras') }}">Computadoras</a></li>
                        <li><a href="{{ url('inventario/moviles') }}">Móviles</a></li>
                        <li><a href="{{ url('inventario/accesorios') }}">Juegos y accesorios</a></li>
                    </ul>
                </li>
                <li><a href="#">Usuarios</a></li>
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

            <section class="seccion_inventario" id="contenido">
                
                <div class="fila-categorias-agregar">
                    <div class="categorias">
                        {{-- Muestra el total de productos --}}
                        <span class="categoria-btn active">{{ $productos->count() }} Productos</span>
                        <a href="#" class="categoria-btn">Ofertas</a>
                        <a href="#" class="categoria-btn">Sin Stock</a>
                    </div>
                    
                    <div class="contenedor-boton-agregar">
                        {{-- Enlace para crear un nuevo producto (debería apuntar a una ruta 'create') --}}
                        <a href="{{ url('inventario/crear') }}" class="boton-agregar">
                            + Agregar Nuevo Producto
                        </a>
                    </div>
                </div>

                <div class="divisor"></div>

                {{-- Contenedor principal para las tarjetas de productos --}}
                <div class="productos-listado">
                    
                    @foreach($productos as $producto)
                    <div class="producto-tarjeta">
                        <div class="encabezado-p">
                            {{-- Muestra el nombre del producto --}}
                            <span class="nombre-producto">{{ $producto->nombre }}</span>
                            {{-- Muestra el ID del producto (puede ser útil para referencia) --}}
                            <span style="font-size:0.9em; color:#7f8c8d;">ID: {{ $producto->id_producto }}</span>
                        </div>
                        
                        <div class="producto-detalles">
                            <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
                            <p><strong>Stock:</strong> {{ $producto->stock }}</p>
                            <p><strong>Descripción:</strong> {{ Str::limit($producto->descripcion, 80) }}</p>

                        </div>
                        
                        <div class="producto-acciones">
                            {{-- Enlace para editar el producto --}}
                            <a href="{{ url('inventario/editar/' . $producto->id_producto) }}" class="actualizar-btn">
                                Actualizar
                            </a>
                            {{-- Botón o enlace para eliminar (usar formulario POST/DELETE) --}}
                            <button style="background: #e74c3c;" class="actualizar-btn">Eliminar</button>
                        </div>
                    </div>
                    @endforeach

                    @empty($productos)
                    <div class="producto-tarjeta">
                        <p>No hay productos registrados en este momento. Utilice el botón "Agregar Nuevo Producto" para comenzar.</p>
                    </div>
                    @endempty
                </div>
                
                {{-- Paginación (si usas Producto::paginate() en el controlador) --}}
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