let categoriaSeleccionadaEmpleados = 'todos';
let ordenSeleccionadoEmpleados = 'usuarios';

function cargarEmpleados(url = `/?categoria=${categoriaSeleccionadaEmpleados}&orden=${ordenSeleccionadoEmpleados}`) {
    fetch(url)
        .then(res => res.text())
        .then(html => {
            const doc = new DOMParser().parseFromString(html, 'text/html');
            document.querySelector('.empleados-cuadricula').innerHTML = doc.querySelector('.empleados-cuadricula').innerHTML;
            document.querySelector('.paginacion-empleados').innerHTML = doc.querySelector('.paginacion-empleados').innerHTML;

            document.querySelectorAll('.paginacion-empleados a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    cargarEmpleados(this.getAttribute('href'));
                });
            });
        });
}

document.querySelectorAll('.boton-ordenar-empleados').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        categoriaSeleccionadaEmpleados = this.getAttribute('data-categoria');
        cargarEmpleados();
    });
});
