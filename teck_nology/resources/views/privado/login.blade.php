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
        <div class="login-decor" aria-hidden="true">
              <!-- Rain of subtle dots: varied left positions, durations and delays for natural fall -->
              <span class="dot" style="left:4%; top:-6%; animation-duration:4.8s; animation-delay:0s"></span>
              <span class="dot" style="left:10%; top:-10%; animation-duration:5.6s; animation-delay:0.6s"></span>
              <span class="dot" style="left:16%; top:-8%; animation-duration:6.2s; animation-delay:0.2s"></span>
              <span class="dot" style="left:22%; top:-12%; animation-duration:5.0s; animation-delay:1.1s"></span>
              <span class="dot" style="left:28%; top:-9%; animation-duration:6.8s; animation-delay:0.9s"></span>
              <span class="dot" style="left:34%; top:-14%; animation-duration:4.4s; animation-delay:0.3s"></span>
              <span class="dot" style="left:40%; top:-6%; animation-duration:5.2s; animation-delay:1.6s"></span>
              <span class="dot" style="left:48%; top:-11%; animation-duration:5.9s; animation-delay:0.4s"></span>
              <span class="dot" style="left:56%; top:-7%; animation-duration:6.6s; animation-delay:1.0s"></span>
              <span class="dot" style="left:64%; top:-13%; animation-duration:4.9s; animation-delay:0.8s"></span>
              <span class="dot" style="left:72%; top:-5%; animation-duration:6.0s; animation-delay:1.3s"></span>
              <span class="dot" style="left:78%; top:-9%; animation-duration:5.4s; animation-delay:0.5s"></span>
              <span class="dot" style="left:84%; top:-14%; animation-duration:7.2s; animation-delay:0.7s"></span>
              <span class="dot" style="left:90%; top:-8%; animation-duration:5.1s; animation-delay:1.9s"></span>
        </div>
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
            <!-- Elegante brand block: logo grande con anillo y título -->
            <div class="brand">
                <div class="brand-mark">
                    <img src="{{ asset('imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png') }}" alt="Teck_nology logo" class="logo">
                </div>
                <h2 class="brand-title">Teck_nology</h2>
                <p class="brand-subtitle">Tecnología con estilo</p>
            </div>

            @include ('partials.login2')
        </div>
    </main>
</body>
</html>
