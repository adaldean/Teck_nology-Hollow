let categoriaSeleccionadaClientes = 'todos';
let ordenSeleccionadoClientes = 'clientes';

function cargarClientes(url = `/?categoria=${categoriaSeleccionadaClientes}&orden=${ordenSeleccionadoClientes}`) {
    fetch(url)
        .then(res => res.text())
        .then(html => {
            const doc = new DOMParser().parseFromString(html, 'text/html');
            document.querySelector('.clientes-cuadricula').innerHTML = doc.querySelector('.clientes-cuadricula').innerHTML;
            document.querySelector('.paginacion-clientes').innerHTML = doc.querySelector('.paginacion-clientes').innerHTML;

            document.querySelectorAll('.paginacion-clientes a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    cargarClientes(this.getAttribute('href'));
                });
            });
        });
}

document.querySelectorAll('.boton-ordenar-clientes').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        categoriaSeleccionadaClientes = this.getAttribute('data-categoria');
        
        cargarClientes();
    });
});
