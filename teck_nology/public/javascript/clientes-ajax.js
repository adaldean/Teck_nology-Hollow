document.addEventListener('DOMContentLoaded', () => {
  const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  function updateClientesTable() {
    const tabla = document.getElementById('tabla-clientes');
    if (!tabla) return;
    fetch('/clientes/listar', { credentials: 'same-origin' })
      .then(r => r.text())
      .then(html => { tabla.innerHTML = html; })
      .catch(err => console.error('Error actualizando tabla de clientes:', err));
  }

  // Attach to any form that wants AJAX behaviour
  document.querySelectorAll('form[data-ajax="clientes"]').forEach(form => {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      const action = form.getAttribute('action');
      const methodInput = form.querySelector('input[name="_method"]');
      const method = (methodInput && methodInput.value) ? methodInput.value.toUpperCase() : (form.method || 'POST');
      const formData = new FormData(form);

      fetch(action, {
        method: method,
        body: formData,
        headers: token ? { 'X-CSRF-TOKEN': token } : {},
        credentials: 'same-origin'
      }).then(async resp => {
        if (resp.ok) {
          // Try JSON first
          const ct = resp.headers.get('content-type') || '';
          if (ct.includes('application/json')) {
            const json = await resp.json();
            if (json.success === false) {
              alert(json.message || 'Error en la operación');
              return;
            }
          }
          // actualizar tabla si está en la página
          updateClientesTable();
          // Si el formulario está dentro de un modal, podríamos cerrarlo; aquí redirigimos si es necesario
          // Mostrar mensaje y, si hay un contenedor principal que no es la tabla, regresar a la lista
          alert('Operación exitosa');
          // If current page is the create/edit page, redirect back to clientes index
          if (window.location.pathname.includes('/clientes/crear') || window.location.pathname.includes('/clientes/editar')) {
            // Redirect back to the clients admin page so the user sees the updated list
            window.location.href = '/privado/clientes';
          }
        } else if (resp.status === 422) {
          const json = await resp.json().catch(()=>null);
          const errors = json?.errors || {};
          let msg = 'Errores:\n';
          for (let k in errors) { msg += (errors[k]||[]).join('\n') + '\n'; }
          alert(msg);
        } else {
          const text = await resp.text().catch(()=>null);
          console.error('Error en respuesta:', resp.status, text);
          alert('Error al procesar la solicitud. Ver consola para más detalles.');
        }
      }).catch(err => {
        console.error('Error enviando formulario AJAX:', err);
        alert('No se pudo conectar con el servidor.');
      });
    });
  });
});
