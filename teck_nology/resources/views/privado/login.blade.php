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
            {{-- Mostrar errores generales --}}
            @if ($errors->any())
                <div class="alert-error">
                    <ul>
                        <li class="list-none">{{ $errors->first() }}</li>
                    </ul>
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf
                
                <div class="grupo-input">
                    <label for="email">Correo</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           class="@error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grupo-input">
                    <label for="password">Contraseña</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required
                           class="@error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>                

                <button type="submit" class="boton-login">Iniciar Sesión</button>
            </form>
        </div>
    </main>
</body>
</html>
