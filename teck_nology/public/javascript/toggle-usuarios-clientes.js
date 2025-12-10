document.addEventListener('DOMContentLoaded', () => {
    const botones = document.querySelectorAll('.categoria-btn');
    const tablaUsuarios = document.getElementById('tabla-usuarios');
    const tablaClientes = document.getElementById('tabla-clientes');
    const pagUsuarios = document.getElementById('paginacion-usuarios');
    const pagClientes = document.getElementById('paginacion-clientes');

    botones.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            botones.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const tipo = this.dataset.tipo;

            if (tipo === 'usuarios') {
                tablaUsuarios.style.display = 'block';
                tablaClientes.style.display = 'none';
                pagUsuarios.style.display = 'block';
                pagClientes.style.display = 'none';
            } else {
                tablaUsuarios.style.display = 'none';
                tablaClientes.style.display = 'block';
                pagUsuarios.style.display = 'none';
                pagClientes.style.display = 'block';
            }
        });
    });
});
