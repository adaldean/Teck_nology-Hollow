<!DOCTYPE html>
<html lang="es">
<head> 
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio de sesión</title>
  <link rel="icon" href="">
  <link rel="stylesheet" href="{{ asset('/css/estilo_login.css') }}">
</head>
<body class="login">
   <div class="header">
       <div class="logo-container">
           <img src="{{ asset('imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png') }}"
                alt="Logo de Zapatilla" 
                class="logo">
       </div>
   </div>

    <main class="login-page">
        <div class="contenedor-formulario">
                @if(session('cliente_id'))
                    <div style="text-align:right;margin-bottom:8px;">
                        <a href="{{ route('cliente.logout') }}" style="text-decoration:none;color:#c0392b;">Cerrar sesión (cliente)</a>
                    </div>
                @endif
            @if ($errors->any())
                <div class="alert-error">
                    <ul>
                        <li class="list-none">{{ $errors->first() }}</li>
                    </ul>
                </div>
            @endif
            @include ('partials.login2')
        </div>
    </main>
</body>
</html>
