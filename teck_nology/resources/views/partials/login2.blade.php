<form action="{{ url('/login') }}" method="POST">
                @csrf
    <button class="boton-empleado">Empleados</button>
    <button class="boton-cliente">Clientes</button>
        <div class="botones">
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
            <div class="logins">
                <button type="submit" class="boton-login">Iniciar Sesión</button>
                <button type="button" class="boton-cuenta" onclick="window.location.href='{{ url('/registro') }}'">Crear Cuenta</button>
            </div>
          
</form>