<div class="login-page">
    <div class="contenedor-formulario">
        <form action="{{ url('/login') }}" method="POST" class="form-login">
            @csrf

            <!-- Botones de rol -->
            <div class="tipo-login">
                <button type="submit" name="role" value="empleado" class="boton-empleado">Empleados</button>
                <button type="submit" name="role" value="cliente" class="boton-cliente">Clientes</button>
            </div>

            <!-- Campos de usuario -->
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

            <!-- Botones de acción -->
            <div class="acciones">
                <button type="submit" class="boton-login">Iniciar Sesión</button>
                <button type="button" class="boton-cuenta" onclick="window.location.href='{{ url('/registro') }}'">
                    Crear Cuenta
                </button>
            </div>

            <!-- Enlace opcional -->
            <a href="{{ url('/forgot-password') }}" class="enlace-secundario">¿Olvidaste tu contraseña?</a>
        </form>
    </div>
</div>
