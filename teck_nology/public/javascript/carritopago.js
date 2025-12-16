// --- Inicializar carrito desde localStorage (fallback) ---
let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

// Try to add product to server-side cart via AJAX; fall back to localStorage
async function agregarAlCarrito(nombre, precio, id = null) {
    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const body = new FormData();
    if (id) body.append('id', id);
    body.append('nombre', nombre);
    body.append('precio', precio);
    // Ensure CSRF token is sent both as header and form field for maximum compatibility
    if (token) body.append('_token', token);

        const headers = token ? { 'X-CSRF-TOKEN': token, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } : { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' };
        const resp = await fetch('/carrito/agregar', {
            method: 'POST',
            headers,
            body,
            credentials: 'same-origin'
        });

        if (resp.ok) {
            const json = await resp.json().catch(()=>null);
            // Update badge with server count when available
            if (json && json.count !== undefined) {
                actualizarIndicadorCarrito(json.count);
            }
            // If the user is on the carrito page, re-render the cart using returned data
            if (window.location.pathname.includes('/carrito')) {
                const container = document.getElementById('carrito-contenedor');
                if (container && json && Array.isArray(json.cart)) {
                    renderCartFromData(json.cart, container);
                }
                try {
                    const lastItem = (json && Array.isArray(json.cart) && json.cart.length) ? json.cart[json.cart.length-1] : { nombre, precio, cantidad: 1 };
                    showMiniCartNotification(lastItem);
                } catch (e) {}
                return;
            }

            // Otherwise, redirect to the carrito page so the user sees the added product and price
            window.location.href = '/carrito';
        }
    } catch (e) {
        console.warn('Carrito servidor no disponible, usando localStorage', e);
    }

    // Fallback localStorage
    let item = carrito.find(p => p.nombre === nombre);
    if (item) {
        item.cantidad++;
    } else {
        carrito.push({ nombre, precio, cantidad: 1 });
    }

    localStorage.setItem("carrito", JSON.stringify(carrito));
    actualizarIndicadorCarrito();
    // If on cart page, re-render from localStorage fallback
    if (window.location.pathname.includes('/carrito')) {
        const container = document.getElementById('carrito-contenedor');
        if (container) renderCartFromData(carrito, container);
    }
    // Show mini notification for local fallback too
    showMiniCartNotification({ nombre, precio, cantidad: 1 });
}


// --- MOSTRAR CARRITO ---
function mostrarCarrito() {
    let contenedor = document.getElementById("carrito-contenedor");
    contenedor.innerHTML = "";
    // If server-side cart is present, the page will render it; otherwise show from localStorage
    if (!contenedor) return;

    // If server rendered the cart, don't overwrite it. Only render fallback when empty
    if (contenedor.innerHTML.trim() === "") {
        if (carrito.length === 0) {
            contenedor.innerHTML = "<p>Tu carrito está vacío.</p>";
            return;
        }

        carrito.forEach((item, index) => {
            let div = document.createElement("div");
            div.classList.add("carrito-item");
            div.innerHTML = `
                <h3>${item.nombre}</h3>
                <p>
                  <button onclick="cambiarCantidad(${index}, -1)">-</button>
                  ${item.cantidad}
                  <button onclick="cambiarCantidad(${index}, 1)">+</button>
                  x $${item.precio} = $${item.cantidad * item.precio}
                </p>
                <button onclick="eliminarDelCarrito(${index})">Eliminar</button>
            `;
            contenedor.appendChild(div);
        });

        // Calcular total general
        let total = carrito.reduce((acc, item) => acc + item.precio * item.cantidad, 0);
        let totalDiv = document.createElement("div");
        totalDiv.classList.add("carrito-total");
        totalDiv.innerHTML = `<h3>Total: $${total}</h3>`;
        contenedor.appendChild(totalDiv);
    }
}

// --- CAMBIAR CANTIDAD (+ / -) ---
function cambiarCantidad(index, delta) {
    carrito[index].cantidad += delta;
    if (carrito[index].cantidad <= 0) {
        carrito.splice(index, 1);
    }
    localStorage.setItem("carrito", JSON.stringify(carrito));
    mostrarCarrito();
}

// --- ELIMINAR PRODUCTO ---
function eliminarDelCarrito(index) {
    carrito.splice(index, 1);
    localStorage.setItem("carrito", JSON.stringify(carrito));
    mostrarCarrito();
}

// --- PAGAR ---
function pagar() {
    // Prefer server-side session check when available
    try {
        const isCliente = window.__isClienteLogged === true || window.__isClienteLogged === 'true';
        if (!isCliente) {
            abrirModal("modalLogin");
        } else {
            abrirModal("modalPago");
        }
    } catch (e) {
        // Fallback to localStorage-based check
        let usuario = localStorage.getItem("usuario");
        if (!usuario) abrirModal("modalLogin"); else abrirModal("modalPago");
    }
}

// --- INICIAR SESIÓN ---
function iniciarSesion() {
    const correo = document.getElementById("correoLogin").value || '';
    const pass = document.getElementById("passwordLogin").value || '';
    const errEl = document.getElementById('login-error');
    if (errEl) { errEl.style.display = 'none'; errEl.textContent = ''; }

    if (correo.trim() === "" || pass.trim() === "") {
        if (errEl) { errEl.textContent = 'Completa todos los campos'; errEl.style.display = 'block'; }
        return;
    }

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const body = new FormData();
    body.append('email', correo);
    body.append('password', pass);
    if (token) body.append('_token', token);

    fetch('/login', { method: 'POST', body, credentials: 'same-origin', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': token } })
    .then(async res => {
        if (!res.ok) {
            const j = await res.json().catch(()=>null);
            const msg = (j && j.errors && (j.errors.email || j.errors.password)) ? (Array.isArray(j.errors.email) ? j.errors.email[0] : j.errors.email) : 'Credenciales inválidas';
            if (errEl){ errEl.textContent = msg; errEl.style.display = 'block'; }
            return;
        }
        const j = await res.json().catch(()=>null);
        // decide whether logged-in actor is a cliente based on redirect target
    const redirectUrl = (j && j.redirect) ? String(j.redirect) : '';
    // If redirect contains /privado (admin area) treat as system user; otherwise treat as cliente
    const isCliente = redirectUrl && !redirectUrl.includes('/privado');
        window.__isClienteLogged = isCliente;
        // close login modal
        cerrarModal('modalLogin');
        if (isCliente) {
            abrirModal('modalPago');
        } else {
            // if it's an admin/empleado, navigate to their destination
            window.location.href = redirectUrl || '/';
        }
    }).catch(e => {
        console.error('Login fetch failed', e);
        if (errEl){ errEl.textContent = 'Error de red. Intenta de nuevo.'; errEl.style.display = 'block'; }
    });
}

// --- REGISTRAR CLIENTE DESDE EL CARRITO ---
function registrarCliente() {
    const nombre = document.getElementById('regNombre').value || '';
    const correo = document.getElementById('regCorreo').value || '';
    const telefono = document.getElementById('regTelefono').value || '';
    const direccion = document.getElementById('regDireccion').value || '';
    const pass = document.getElementById('regPassword').value || '';
    const pass2 = document.getElementById('regPasswordConf').value || '';
    const errEl = document.getElementById('reg-error');
    if (errEl) { errEl.style.display = 'none'; errEl.textContent = ''; }

    if (!nombre.trim() || !correo.trim() || !pass.trim() || !pass2.trim()) {
        if (errEl){ errEl.textContent = 'Completa todos los campos obligatorios.'; errEl.style.display = 'block'; }
        return;
    }
    if (pass !== pass2) {
        if (errEl){ errEl.textContent = 'Las contraseñas no coinciden.'; errEl.style.display = 'block'; }
        return;
    }

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const body = new FormData();
    body.append('nombre', nombre);
    body.append('email', correo);
    body.append('telefono', telefono);
    body.append('direccion', direccion);
    body.append('password', pass);
    body.append('password_confirmation', pass2);
    if (token) body.append('_token', token);

    fetch('/register', { method: 'POST', body, credentials: 'same-origin', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': token } })
    .then(async res => {
        if (!res.ok) {
            const j = await res.json().catch(()=>null);
            const msg = (j && j.errors) ? Object.values(j.errors).flat()[0] : 'Error en el registro';
            if (errEl){ errEl.textContent = msg; errEl.style.display = 'block'; }
            return;
        }
        const j = await res.json().catch(()=>null);
        // mark client session client-side
        window.__isClienteLogged = true;
        cerrarModal('modalRegistro');
        cerrarModal('modalLogin');
        abrirModal('modalPago');
    }).catch(e => {
        console.error('Register fetch failed', e);
        if (errEl){ errEl.textContent = 'Error de red. Intenta de nuevo.'; errEl.style.display = 'block'; }
    });
}

// --- MODALES ---
function abrirModal(id) {
    document.getElementById(id).style.display = "flex";
}

function cerrarModal(id) {
    document.getElementById(id).style.display = "none";
}

function actualizarIndicadorCarrito() {
    // if countArg provided, use it; otherwise compute from localStorage
    let count = 0;
    if (arguments.length && typeof arguments[0] === 'number') {
        count = arguments[0];
    } else {
        count = carrito.reduce((acc, item) => acc + item.cantidad, 0);
    }
    let countSpan = document.getElementById("carrito-count");
    if (countSpan) {
        countSpan.textContent = count;
    }
}


document.addEventListener("DOMContentLoaded", () => {
    mostrarCarrito();              // si existe #carrito-contenedor
    // Request current server-side cart count on load so badge starts at 0/client value
    (async function fetchCount(){
        try {
            const resp = await fetch('/carrito/count', { credentials: 'same-origin', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
            if (resp.ok) {
                const json = await resp.json().catch(()=>null);
                if (json && typeof json.count === 'number') {
                    actualizarIndicadorCarrito(json.count);
                } else {
                    actualizarIndicadorCarrito();
                }
            } else {
                actualizarIndicadorCarrito();
            }
        } catch (e) {
            actualizarIndicadorCarrito();
        }
    })();

    // Attach click handlers to catalog add-to-cart buttons
    document.querySelectorAll('.agregar-carrito').forEach(btn => {
        btn.addEventListener('click', function (e) {
            const nombre = this.dataset.nombre || this.getAttribute('data-nombre');
            const precio = this.dataset.precio || this.getAttribute('data-precio');
            const id = this.dataset.id || this.getAttribute('data-id');
            agregarAlCarrito(nombre, precio, id);
        });
    });
    // Attach control handlers to any server-rendered cart controls
    const container = document.getElementById('carrito-contenedor');
    if (container) attachCartControls(container);
});


function renderCartFromData(cartArray, container) {
        if (!container) return;
        if (!Array.isArray(cartArray) || cartArray.length === 0) {
                container.innerHTML = '<p>Tu carrito está vacío.</p>';
                return;
        }

        let html = '<div class="productos-cuadricula">';
        cartArray.forEach(item => {
                const img = item.imagen_url ? item.imagen_url : '/imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png';
                const nombre = item.nombre || '';
                const precio = Number(item.precio || 0).toFixed(2);
                const cantidad = Number(item.cantidad || 0);
                const subtotal = (Number(item.precio || 0) * cantidad).toFixed(2);

                const dataIdAttr = item.id ? `data-id="${item.id}"` : '';
                const dataNombreAttr = `data-nombre="${escapeHtml(nombre)}"`;
                html += `
                    <div class="producto-tarjeta" ${dataIdAttr} ${dataNombreAttr}>
                        <div class="producto-imagen">
                            <img class="producto-imagen" src="${img}" alt="${escapeHtml(nombre)}">
                        </div>
                        <div class="producto-info">
                            <p class="producto-nombre">${escapeHtml(nombre)}</p>
                            <p class="producto-precio">$${precio}</p>
                            <p>Cantidad: <span class="cart-quantity">${cantidad}</span></p>
                            <p>
                              <button class="card-qty-btn btn-decrement" ${dataIdAttr} ${dataNombreAttr}>−</button>
                              <button class="card-qty-btn btn-increment" ${dataIdAttr} ${dataNombreAttr}>+</button>
                              <button class="card-remove-btn btn-remove" ${dataIdAttr} ${dataNombreAttr}>Eliminar</button>
                            </p>
                            <p>Subtotal: $${subtotal}</p>
                        </div>
                    </div>
                `;
        });
        html += '</div>';

        // total
        const total = cartArray.reduce((acc, it) => acc + (Number(it.precio || 0) * Number(it.cantidad || 0)), 0).toFixed(2);
        html += `<div class="carrito-total"><h3>Total: $${total}</h3></div>`;

        container.innerHTML = html;
        // attach event listeners for the newly rendered controls
        attachCartControls(container);
}

// Attach increment/decrement/remove handlers inside a container
function attachCartControls(container) {
    if (!container) return;

    container.querySelectorAll('.btn-increment').forEach(btn => {
        btn.removeEventListener('click', onIncrementClick);
        btn.addEventListener('click', onIncrementClick);
    });
    container.querySelectorAll('.btn-decrement').forEach(btn => {
        btn.removeEventListener('click', onDecrementClick);
        btn.addEventListener('click', onDecrementClick);
    });
    container.querySelectorAll('.btn-remove').forEach(btn => {
        btn.removeEventListener('click', onRemoveClick);
        btn.addEventListener('click', onRemoveClick);
    });
}

function onIncrementClick(e) {
    const id = this.dataset.id || null;
    const nombre = this.dataset.nombre || null;
    // find current quantity in same card
    const card = this.closest('.producto-tarjeta');
    if (!card) return;
    const qtySpan = card.querySelector('.cart-quantity');
    let current = Number(qtySpan ? qtySpan.textContent : 0);
    const newQty = current + 1;
    actualizarCantidadServer(id, nombre, newQty);
}

function onDecrementClick(e) {
    const id = this.dataset.id || null;
    const nombre = this.dataset.nombre || null;
    const card = this.closest('.producto-tarjeta');
    if (!card) return;
    const qtySpan = card.querySelector('.cart-quantity');
    let current = Number(qtySpan ? qtySpan.textContent : 0);
    const newQty = current - 1;
    // if newQty <= 0, server will remove the item
    actualizarCantidadServer(id, nombre, newQty);
}

function onRemoveClick(e) {
    const id = this.dataset.id || null;
    const nombre = this.dataset.nombre || null;
    eliminarItemServer(id, nombre);
}

// Send updated quantity to server
async function actualizarCantidadServer(id, nombre, cantidad) {
    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const body = new FormData();
        if (id) body.append('id', id);
        if (!id && nombre) body.append('nombre', nombre);
        body.append('cantidad', cantidad);
        if (token) body.append('_token', token);

        const headers = token ? { 'X-CSRF-TOKEN': token, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } : { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' };

        const resp = await fetch('/carrito/actualizar', { method: 'POST', headers, body, credentials: 'same-origin' });
        if (resp.ok) {
            const json = await resp.json().catch(()=>null);
            if (json && json.count !== undefined) actualizarIndicadorCarrito(json.count);
            const container = document.getElementById('carrito-contenedor');
            if (container && json && Array.isArray(json.cart)) renderCartFromData(json.cart, container);
            return;
        }
        console.warn('Actualización de cantidad falló', resp.status);
    } catch (e) {
        console.error('Error actualizando cantidad', e);
    }
}

// Send delete request to server
async function eliminarItemServer(id, nombre) {
    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const body = new FormData();
        if (id) body.append('id', id);
        if (!id && nombre) body.append('nombre', nombre);
        if (token) body.append('_token', token);

        const headers = token ? { 'X-CSRF-TOKEN': token, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } : { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' };
        const resp = await fetch('/carrito/eliminar', { method: 'POST', headers, body, credentials: 'same-origin' });
        if (resp.ok) {
            const json = await resp.json().catch(()=>null);
            if (json && json.count !== undefined) actualizarIndicadorCarrito(json.count);
            const container = document.getElementById('carrito-contenedor');
            if (container && json && Array.isArray(json.cart)) renderCartFromData(json.cart, container);
            return;
        }
        console.warn('Eliminar item falló', resp.status);
    } catch (e) {
        console.error('Error eliminando item', e);
    }
}

// Small floating notification to show last added product (visible on any page)
function showMiniCartNotification(item) {
    try {
        const img = item.imagen_url ? item.imagen_url : '/imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png';
        const nombre = item.nombre || '';
        const precio = Number(item.precio || 0).toFixed(2);

        // Remove existing notification if present
        const existing = document.getElementById('mini-cart-notif');
        if (existing) existing.remove();

        const div = document.createElement('div');
        div.id = 'mini-cart-notif';
        div.style.position = 'fixed';
        div.style.right = '20px';
        div.style.bottom = '90px';
        div.style.zIndex = 2000;
        div.style.background = 'rgba(255,255,255,0.97)';
        div.style.border = '1px solid #ddd';
        div.style.padding = '10px';
        div.style.borderRadius = '8px';
        div.style.boxShadow = '0 6px 18px rgba(0,0,0,0.12)';
        div.style.display = 'flex';
        div.style.gap = '10px';
        div.style.alignItems = 'center';

        div.innerHTML = `
            <img src="${img}" alt="${escapeHtml(nombre)}" style="width:56px;height:56px;object-fit:cover;border-radius:6px;border:1px solid #eee">
            <div style="min-width:160px">
                <div style="font-weight:600">${escapeHtml(nombre)}</div>
                <div style="color:#444">$${precio} • Agregado</div>
                <a href="/carrito" style="display:inline-block;margin-top:6px;color:#087efc;text-decoration:none">Ver carrito</a>
            </div>
        `;

        document.body.appendChild(div);

        setTimeout(() => {
            const el = document.getElementById('mini-cart-notif');
            if (el) el.remove();
        }, 3500);
    } catch (e) { console.warn('mini notif failed', e); }
}

function escapeHtml(text) {
        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
}


