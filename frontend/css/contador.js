// Funcionalidad para el contador de productos
document.addEventListener('DOMContentLoaded', function() {
    // Obtener elementos del DOM
    const contadorInput = document.querySelector('.contador-input-detalle');
    const btnDisminuir = document.querySelector('.contador-btn-detalle.disminuir');
    const btnAumentar = document.querySelector('.contador-btn-detalle.aumentar');
    const btnAgregarCarrito = document.querySelector('.btn-agregar-carrito');
    
    // Validar que los elementos existen
    if (!contadorInput || !btnDisminuir || !btnAumentar) {
        console.error('No se encontraron los elementos del contador');
        return;
    }
    
    // Función para actualizar el valor del contador
    function actualizarContador(valor) {
        // Validar que el valor sea un número positivo
        valor = parseInt(valor);
        if (isNaN(valor) || valor < 1) {
            valor = 1;
        }
        contadorInput.value = valor;
        
        // Guardar en localStorage para persistencia
        localStorage.setItem('cantidadProducto', valor);
    }
    
    // Evento para aumentar la cantidad
    btnAumentar.addEventListener('click', function() {
        let valorActual = parseInt(contadorInput.value);
        valorActual++;
        actualizarContador(valorActual);
    });
    
    // Evento para disminuir la cantidad
    btnDisminuir.addEventListener('click', function() {
        let valorActual = parseInt(contadorInput.value);
        if (valorActual > 1) {
            valorActual--;
            actualizarContador(valorActual);
        }
    });
    
    // Permitir cambiar el valor manualmente (opcional)
    contadorInput.addEventListener('change', function() {
        actualizarContador(this.value);
    });
    
    // Validar entrada manual
    contadorInput.addEventListener('input', function() {
        // Solo permitir números
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    // Cargar cantidad guardada en localStorage
    const cantidadGuardada = localStorage.getItem('cantidadProducto');
    if (cantidadGuardada) {
        actualizarContador(cantidadGuardada);
    }
    
    // Función para agregar al carrito
    if (btnAgregarCarrito) {
        btnAgregarCarrito.addEventListener('click', function() {
            const cantidad = parseInt(contadorInput.value);
            const nombreProducto = document.querySelector('.producto-nombre-detalle').textContent;
            const precioProducto = document.querySelector('.producto-precio-detalle').textContent;
            
            // Crear objeto del producto
            const producto = {
                nombre: nombreProducto,
                precio: precioProducto,
                cantidad: cantidad,
                fecha: new Date().toLocaleString()
            };
            
            // Guardar en localStorage
            let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            carrito.push(producto);
            localStorage.setItem('carrito', JSON.stringify(carrito));
            
            // Mostrar mensaje de confirmación
            alert(`✅ ${cantidad} ${cantidad === 1 ? 'unidad' : 'unidades'} de "${nombreProducto}" agregada${cantidad === 1 ? '' : 's'} al carrito.\nPrecio total: ${calcularPrecioTotal(precioProducto, cantidad)}`);
            
            // Resetear contador a 1
            actualizarContador(1);
        });
    }
    
    // Función auxiliar para calcular precio total
    function calcularPrecioTotal(precioTexto, cantidad) {
        // Extraer número del precio (eliminar $ y comas)
        const precioNumerico = parseFloat(precioTexto.replace(/[^0-9.]/g, ''));
        if (isNaN(precioNumerico)) return 'N/A';
        
        const total = precioNumerico * cantidad;
        return `$${total.toFixed(2)}`;
    }
    
    // Efectos visuales adicionales
    function agregarEfectoBoton(boton) {
        boton.addEventListener('mousedown', function() {
            this.style.transform = 'scale(0.95)';
        });
        
        boton.addEventListener('mouseup', function() {
            this.style.transform = '';
        });
        
        boton.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    }
    
    // Aplicar efectos a los botones del contador
    agregarEfectoBoton(btnDisminuir);
    agregarEfectoBoton(btnAumentar);
    
    if (btnAgregarCarrito) {
        agregarEfectoBoton(btnAgregarCarrito);
    }
    
    console.log('Contador de productos inicializado correctamente');
});