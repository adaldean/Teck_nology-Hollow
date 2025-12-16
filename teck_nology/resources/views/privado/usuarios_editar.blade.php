<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="{{ asset('css/estiloinve.css') }}">
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
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-logout btn-admin">Cerrar Sesión</button>
                    </form>
                </li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="header">
                <h1>EDITAR USUARIO</h1>
            </div>

            <section class="seccion_inventario">
                <div class="card" style="max-width:950px;margin:20px auto;padding:20px;background:#fff;border-radius:8px;">
                    @if ($errors->any())
                        <div class="alert-error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('usuarios.actualizarAjax', $usuario->id_usuario) }}" method="POST" class="form-grid">
                        @csrf
                        @method('PUT')

                        <div class="form-row">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" required>
                        </div>

                        <div class="form-row">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
                        </div>

                        <div class="form-row">
                            <label for="contrasena">Nueva Contraseña (dejar vacío para no cambiar)</label>
                            <input type="password" id="contrasena" name="contrasena">
                        </div>

                        <div class="form-row">
                            <label for="id_rol">Rol</label>
                            <select name="id_rol" id="id_rol">
                                @foreach(\App\Models\Rol::all() as $rol)
                                    <option value="{{ $rol->id_rol }}" {{ $usuario->id_rol == $rol->id_rol ? 'selected' : '' }}>{{ $rol->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-row form-row-full form-actions" style="grid-column:1/-1;display:flex;gap:12px;justify-content:flex-end;">
                            <a href="{{ route('usuarios.index') }}" class="boton-cancelar btn-admin btn-ghost" style="align-self:center;padding:8px 12px;background:#f3f3f3;border-radius:6px;text-decoration:none;color:#333;">Volver</a>
                            <button type="submit" class="boton-guardar btn-admin" style="padding:8px 16px;background:#1e8f4a;color:#fff;border-radius:6px;border:none;">Guardar</button>
                        </div>
                    </form>
                    @if ($errors->any())
                        <div class="errors" style="margin-top:12px;color:#a00;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                </div>
            </section>
        </main>
    </div>

    <script src="{{ asset('javascript/toggle-usuarios-clientes.js') }}"></script>
    <script>
        (function(){
            var css = '\n.form-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:16px;align-items:start;}\n.form-row label{display:block;margin-bottom:6px;font-weight:600;}\n.form-row input[type=text], .form-row input[type=number], .form-row select, .form-row textarea{width:100%;padding:8px;border:1px solid #ddd;border-radius:6px;}\n.form-row-full{grid-column:1/-1;}\n.img-preview{max-width:220px;}\n@media(max-width:800px){.form-grid{grid-template-columns:1fr;} }\n';
            var s=document.createElement('style');s.innerHTML=css;document.head.appendChild(s);
        })();
    </script>
</body>
</html>
</body>
</html>
