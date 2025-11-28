// public/js/productos.js

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.chip-categoria').forEach(chip => {
        chip.addEventListener('click', function(e) {
            e.preventDefault(); // Evita que cambie de página
            let categoria = this.dataset.categoria;

            fetch(`/productos/${categoria}`)
                .then(res => res.json())
                .then(data => {
                    let contenedor = document.querySelector('.productos-cuadricula');
                    contenedor.innerHTML = ''; // Limpia productos actuales

                    data.forEach(producto => {
                        contenedor.innerHTML += `
                            <div class="producto-tarjeta">
                              <div class="producto-imagen">
                                <img src="/imagenes/${producto.imagen}" alt="${producto.nombre}">
                              </div>
                              <div class="producto-info">
                                <p class="producto-nombre">${producto.nombre}</p>
                                <p class="producto-precio">$${producto.precio}</p>
                              </div>
                            </div>
                        `;
                    });
                });
        });
    });
});
