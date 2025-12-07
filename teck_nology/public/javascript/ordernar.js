let categoriaSeleccionada = 'todos';
let ordenSeleccionado = 'productos';
function cargarProductos(url = `/?categoria=${categoriaSeleccionada}&orden=${ordenSeleccionado}`) {
    fetch(url)
        .then(res => res.text())
        .then(html => {
            const doc = new DOMParser().parseFromString(html, 'text/html');
            document.querySelector('.productos-cuadricula').innerHTML = doc.querySelector('.productos-cuadricula').innerHTML;
            document.querySelector('.paginacion').innerHTML = doc.querySelector('.paginacion').innerHTML;

            // Reasignar eventos a los links de paginación
            document.querySelectorAll('.paginacion a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    cargarProductos(this.getAttribute('href'));
                });
            });
        });
}

document.querySelectorAll('.chip-categoria').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        categoriaSeleccionada = this.getAttribute('data-categoria');

        document.querySelectorAll('.chip-categoria').forEach(b => b.classList.remove('activo'));
        this.classList.add('activo');

        cargarProductos();
    });
});


document.querySelectorAll('.boton-ordenar').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        ordenSeleccionado = this.getAttribute('data-orden');

        document.querySelectorAll('.boton-ordenar').forEach(b => b.classList.remove('activo'));
        this.classList.add('activo');

        cargarProductos();
    });
});
