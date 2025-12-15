<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editar Cliente</title>
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
                <li class="active"><a href="{{ url('privado/clientes') }}">Clientes</a></li>
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
                <h1>EDITAR CLIENTE</h1>
            </div>

            <section class="seccion_inventario">
                <div class="form-crear">
                    @if ($errors->any())
                        <div class="alert-error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('clientes.actualizarAjax', $cliente->id_cliente) }}" method="POST" class="form-usuario" data-ajax="clientes">
                        @csrf
                        @method('PUT')

                        <div class="form-row">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" required class="input-text">
                        </div>

                        <div class="form-row">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $cliente->email) }}" required class="input-text">
                        </div>

                        <div class="form-row">
                            <label for="contrasena">Nueva Contraseña (dejar vacío para no cambiar)</label>
                            <input type="password" id="contrasena" name="contrasena" class="input-text">
                        </div>

                        <div class="form-row">
                            <label for="telefono">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" class="input-text">
                        </div>

                        <div class="form-row">
                            <label for="direccion">Dirección</label>
                            <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $cliente->direccion) }}" class="input-text">
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="boton-agregar">Guardar</button>
                            <a href="{{ route('clientes.index') }}" class="boton">Volver</a>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <script src="{{ asset('javascript/toggle-usuarios-clientes.js') }}"></script>
    <script src="{{ asset('javascript/clientes-ajax.js') }}"></script>
</body>
</html>
