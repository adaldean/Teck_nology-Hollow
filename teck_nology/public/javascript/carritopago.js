    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    // --- AGREGAR AL CARRITO ---
    function agregarAlCarrito(nombre, precio) {
        let item = carrito.find(p => p.nombre === nombre);

        if (item) {
            item.cantidad++;
        } else {
            carrito.push({ nombre, precio, cantidad: 1 });
        }

        localStorage.setItem("carrito", JSON.stringify(carrito));
        alert("Producto agregado al carrito");
    }

    function pagar() {
        let usuario = localStorage.getItem("usuario");

        if (!usuario) {
            abrirModal("modalLogin");
        } else {
            abrirModal("modalPago");
        }
    }


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


    function abrirModal(id) {
        document.getElementById(id).style.display = "flex";
    }

    function cerrarModal(id) {
        document.getElementById(id).style.display = "none";
    }