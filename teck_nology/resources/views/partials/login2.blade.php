<div class="login-page">
    <div class="contenedor-formulario">
        <form action="{{ url('/login') }}" method="POST" class="form-login" id="form-login">
            @csrf

            <!-- (Se han eliminado los botones de rol: solo queda Iniciar Sesión y Crear Cuenta) -->

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
                <!-- overlay para transición suave al redirigir -->
                <div id="login-overlay" aria-hidden="true" class="login-overlay hidden">
                    <div class="overlay-dot"></div>
                    <div class="overlay-message">Iniciando sesión…</div>
                </div>
                <script>
                    (function(){
                        const form = document.getElementById('form-login');
                        if (!form) return;

                        const overlay = document.getElementById('login-overlay');
                        function showOverlay(){
                            overlay.classList.remove('hidden');
                            // trigger reflow then add show class for transitions
                            void overlay.offsetWidth;
                            overlay.classList.add('show');
                        }
                        function hideOverlay(){ overlay.classList.remove('show'); setTimeout(()=>overlay.classList.add('hidden'), 600); }

                        form.addEventListener('submit', function(e){
                            e.preventDefault();
                            const url = form.action;
                            const data = new FormData(form);
                            const tokenInput = form.querySelector('input[name="_token"]');
                            const csrf = tokenInput ? tokenInput.value : '';

                            // show a quick micro-animation
                            showOverlay();

                            fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': csrf
                                },
                                body: data,
                                credentials: 'same-origin'
                            }).then(async (res) => {
                                if (!res.ok) {
                                    // validation or auth error
                                    try{
                                        const body = await res.json();
                                        // show first error near form (simple behavior)
                                        const err = (body.errors && (body.errors.email || body.errors.password)) || 'Credenciales inválidas.';
                                        hideOverlay();
                                        alert(Array.isArray(err) ? err[0] : err);
                                    }catch(e){
                                        hideOverlay();
                                        alert('Error al iniciar sesión. Intenta de nuevo.');
                                    }
                                    return;
                                }
                                const body = await res.json();
                                const redirect = body.redirect || '/';

                                // small wait for the overlay animation to settle (600ms), then navigate
                                setTimeout(()=>{ window.location.href = redirect }, 600);

                            }).catch((err)=>{
                                // fallback: unhide overlay briefly and then submit normally
                                console.error(err);
                                hideOverlay();
                                // try normal submit (fallback)
                                form.submit();
                            });
                        });
                    })();
                </script>
    </div>
</div>
