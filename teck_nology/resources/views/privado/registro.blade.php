<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Cuenta</title>
  <link rel="stylesheet" href="{{ asset('css/estiloinve.css') }}">
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <div class="logo">
        <img src="{{ asset('imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png') }}" alt="Logo" class="logo-img">
      </div>
    </aside>

    <main class="main-content">
      <div class="header" style="display:flex;justify-content:space-between;align-items:center;"><h1>CREAR CUENTA</h1>
        @if(session('cliente_id'))
          <a href="{{ route('cliente.logout') }}" style="text-decoration:none;color:#c0392b;padding:8px 12px;border-radius:6px;background:#fff;border:1px solid #f0dede;">Cerrar sesión</a>
        @endif
      </div>

      @if(session('success'))
        <div class="flash-message success" style="max-width:900px;margin:10px auto;padding:10px;background:#e6ffed;border:1px solid #b2f5c6;color:#064e2a;">{{ session('success') }}</div>
      @endif
      @if($errors->any())
        <div class="flash-message error" style="max-width:900px;margin:10px auto;padding:10px;background:#ffe6e6;border:1px solid #f5b2b2;color:#6a0410;">
          <ul style="margin:0;padding-left:18px;">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <section class="seccion_formulario">
        <div class="card" style="max-width:700px;margin:20px auto;padding:20px;background:#fff;border-radius:8px;">
          <form action="{{ route('registro.post') }}" method="POST" class="form-grid">
            @csrf

            <div class="form-row">
              <label for="nombre">Nombre</label>
              <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required>
            </div>

            <div class="form-row">
              <label for="email">Correo electrónico</label>
              <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-row">
              <label for="telefono">Teléfono</label>
              <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}">
            </div>

            <div class="form-row">
              <label for="direccion">Dirección</label>
              <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}">
            </div>

            <div class="form-row">
              <label for="password">Contraseña</label>
              <input type="password" name="password" id="password" required>
            </div>

            <div class="form-row">
              <label for="password_confirmation">Confirmar contraseña</label>
              <input type="password" name="password_confirmation" id="password_confirmation" required>
            </div>

            <div class="form-row form-actions" style="grid-column:1/-1;display:flex;gap:12px;justify-content:flex-end;">
              <a href="{{ url('/login') }}" class="boton-cancelar" style="align-self:center;padding:8px 12px;background:#f3f3f3;border-radius:6px;text-decoration:none;color:#333;">Volver</a>
              <button type="submit" class="boton-guardar" style="padding:8px 16px;background:#1e8f4a;color:#fff;border-radius:6px;border:none;">Crear cuenta</button>
            </div>

          </form>
        </div>
      </section>
    </main>
  </div>

  <script>
    (function(){
      var css = '\n.form-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:16px;align-items:start;}\n.form-row label{display:block;margin-bottom:6px;font-weight:600;}\n.form-row input[type=text], .form-row input[type=email], .form-row input[type=password]{width:100%;padding:8px;border:1px solid #ddd;border-radius:6px;}\n@media(max-width:800px){.form-grid{grid-template-columns:1fr;} }\n';
      var s=document.createElement('style');s.innerHTML=css;document.head.appendChild(s);
    })();
  </script>
</body>
</html>
