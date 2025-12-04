document.getElementById('form-busqueda').addEventListener('submit', function(e) {
    e.preventDefault();
    let query = document.getElementById('campo-busqueda').value;

    fetch(`/inventario/buscar?query=${query}`)
        .then(res => res.text())
        .then(html => {
            document.querySelector('.tabla-contenedor').innerHTML = html;
        });
});

document.querySelectorAll('.categoria-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        let categoria = this.getAttribute('data-categoria');

        document.querySelectorAll('.categoria-btn').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');

        fetch(`/inventario/categoria?categoria=${categoria}`) // ✅ corregido
            .then(res => res.text())
            .then(html => {
                document.querySelector('.tabla-contenedor').innerHTML = html;
            });
    });
});
s