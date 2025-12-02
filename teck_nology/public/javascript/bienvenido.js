    window.addEventListener('DOMContentLoaded', () => {
        const alerta = document.getElementById('alerta-exito');
        if (alerta) {
            alerta.style.top = '20px';

            setTimeout(() => {
                alerta.style.top = '-100px';
            }, 3000);
        }
    });