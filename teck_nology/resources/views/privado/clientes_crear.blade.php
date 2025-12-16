<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Crear Cliente</title>
    <link rel="stylesheet" href="{{ asset('css/estiloinve.css') }}">
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
                <h1>CREAR CLIENTE</h1>
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

                    <form action="{{ route('clientes.store') }}" method="POST" class="form-grid" data-ajax="clientes">
                        @csrf
                        <div class="form-row">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                        </div>

                        <div class="form-row">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                        </div>

                        <div class="form-row">
                            <label for="contrasena">Contraseña</label>
                            <input type="password" id="contrasena" name="contrasena">
                        </div>

                        <div class="form-row">
                            <label for="telefono">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}">
                        </div>

                        <div class="form-row">
                            <label for="direccion">Dirección</label>
                            <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}">
                        </div>

                        <div class="form-row form-row-full form-actions" style="grid-column:1/-1;display:flex;gap:12px;justify-content:flex-end;">
                            <a href="{{ route('clientes.index') }}" class="boton-cancelar btn-admin btn-ghost" style="align-self:center;padding:8px 12px;background:#f3f3f3;border-radius:6px;text-decoration:none;color:#333;">Volver</a>
                            <button type="submit" class="boton-guardar btn-admin" style="padding:8px 16px;background:#1e8f4a;color:#fff;border-radius:6px;border:none;">Crear</button>
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
            </section>
        </main>
    </div>

    <script src="{{ asset('javascript/toggle-usuarios-clientes.js') }}"></script>
    <script src="{{ asset('javascript/clientes-ajax.js') }}"></script>
    <script>
        (function(){
            var css = '\n.form-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:16px;align-items:start;}\n.form-row label{display:block;margin-bottom:6px;font-weight:600;}\n.form-row input[type=text], .form-row input[type=number], .form-row select, .form-row textarea{width:100%;padding:8px;border:1px solid #ddd;border-radius:6px;}\n.form-row-full{grid-column:1/-1;}\n.img-preview{max-width:220px;}\n@media(max-width:800px){.form-grid{grid-template-columns:1fr;} }\n';
            var s=document.createElement('style');s.innerHTML=css;document.head.appendChild(s);
        })();
    </script>
</body>
</html>
