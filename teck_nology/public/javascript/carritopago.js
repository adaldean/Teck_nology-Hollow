// --- Inicializar carrito desde localStorage ---
let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

function agregarAlCarrito(nombre, precio) {
    let item = carrito.find(p => p.nombre === nombre);

    if (item) {
        item.cantidad++;
    } else {
        carrito.push({ nombre, precio, cantidad: 1 });
    }

    localStorage.setItem("carrito", JSON.stringify(carrito));
    actualizarIndicadorCarrito(); // 👈 aquí
}


// --- MOSTRAR CARRITO ---
function mostrarCarrito() {
    let contenedor = document.getElementById("carrito-contenedor");
    contenedor.innerHTML = "";

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
    let usuario = localStorage.getItem("usuario");

    if (!usuario) {
        abrirModal("modalLogin");
    } else {
        abrirModal("modalPago");
    }
}

// --- INICIAR SESIÓN ---
function iniciarSesion() {
    let correo = document.getElementById("correoLogin").value;
    let pass = document.getElementById("passwordLogin").value;

    if (correo.trim() === "" || pass.trim() === "") {
        alert("Completa todos los campos");
        return;
    }

    localStorage.setItem("usuario", correo);
    alert("Inicio de sesión exitoso");

    cerrarModal("modalLogin");
    abrirModal("modalPago");
}

// --- MODALES ---
function abrirModal(id) {
    document.getElementById(id).style.display = "flex";
}

function cerrarModal(id) {
    document.getElementById(id).style.display = "none";
}

function actualizarIndicadorCarrito() {
    let count = carrito.reduce((acc, item) => acc + item.cantidad, 0);
    let countSpan = document.getElementById("carrito-count");
    if (countSpan) {
        countSpan.textContent = count;
    }
}


document.addEventListener("DOMContentLoaded", () => {
    mostrarCarrito();              // si existe #carrito-contenedor
    actualizarIndicadorCarrito();  // si existe #carrito-count
});


