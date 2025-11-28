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
           <!-- Placeholder de logo. Cambia la URL por tu imagen real. -->
           <img src="{{ asset('imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png') }}"
                alt="Logo de Zapatilla" 
                class="logo">
       </div>
   </div>

    <main class="login-page">
        <div class="contenedor-formulario">
            <!-- Bloque para mostrar errores generales de la sesión (ej. credenciales inválidas) -->
            @if ($errors->any())
                <div class="alert-error">
                    <ul>
                        <!-- Solo mostramos el error del campo 'correo' si falla Auth::attempt -->
                        @if ($errors->has('correo'))
                            <li class="list-none">{{ $errors->first('correo') }}</li>
                        @endif
                    </ul>
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf
                
                <div class="grupo-input">
                    <label for="correo">Correo</label>
                    <input type="email" 
                           id="correo" 
                           name="correo" 
                           value="{{ old('correo') }}" 
                           required 
                           class="@error('correo') border-red-500 @enderror">
                    <!-- Muestra error de validación del correo -->
                    @error('correo')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grupo-input">
                    <label for="contraseña">Contraseña</label>
                    <input type="password" 
                           id="contraseña" 
                           name="contraseña" 
                           required
                           class="@error('contraseña') border-red-500 @enderror">
                    <!-- Muestra error de validación de la contraseña -->
                    @error('contraseña')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>                
                <a href="{{asset('privado/inventario') }}">
                <button type="submit" class="boton-login">Iniciar Sesión</button>
                </a>

            </form>
        </div>
    </main>
</body>
</html>
</html>