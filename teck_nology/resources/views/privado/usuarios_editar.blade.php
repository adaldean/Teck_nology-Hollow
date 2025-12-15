<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="{{ asset('css/estilo_gestionclien.css') }}">
</head>
<body>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editar Usuario</title>
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
                <li class="active"><a href="{{ url('privado/usuarios') }}">Usuarios</a></li>
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
                <h1>EDITAR USUARIO</h1>
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

                    <form action="{{ route('usuarios.actualizarAjax', $usuario->id_usuario) }}" method="POST" class="form-usuario">
                        @csrf
                        @method('PUT')

                        <div class="form-row">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" required class="input-text">
                        </div>

                        <div class="form-row">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $usuario->email) }}" required class="input-text">
                        </div>

                        <div class="form-row">
                            <label for="contrasena">Nueva Contraseña (dejar vacío para no cambiar)</label>
                            <input type="password" id="contrasena" name="contrasena" class="input-text">
                        </div>

                        <div class="form-row">
                            <label for="id_rol">Rol</label>
                            <select name="id_rol" id="id_rol" class="select">
                                @foreach(\App\Models\Rol::all() as $rol)
                                    <option value="{{ $rol->id_rol }}" {{ $usuario->id_rol == $rol->id_rol ? 'selected' : '' }}>{{ $rol->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="boton-agregar">Guardar</button>
                            <a href="{{ route('usuarios.index') }}" class="boton">Volver</a>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <script src="{{ asset('javascript/toggle-usuarios-clientes.js') }}"></script>
</body>
</html>
</body>
</html>
