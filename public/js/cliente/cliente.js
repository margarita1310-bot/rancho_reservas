function guardarDatosCliente() {
    const nombre = document.getElementById('nombre').value.trim();
    const telefono = document.getElementById('telefono').value.trim();

    if (!nombre || !telefono) {
        alert('Completa todos los campos');
        return;
    }

    const formData = new FormData();

    formData.append('nombre', nombre);
    formData.append('telefono', telefono);

    fetch('index.php?action=guardarDatosCliente', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(r => {
        if (r.success) {

            sessionStorage.setItem('nombre', nombre);
            sessionStorage.setItem('telefono', telefono);

            const datosModal = document.getElementById('datosModal');

            const modal = bootstrap.Modal.getInstance(datosModal) || new bootstrap.Modal(datosModal);
            modal.hide();

            actualizarNavbar();

        } else {
            alert('Error al guardar datos');
        }
    })
    .catch(() => alert('Error en la petición'));
}

function habilitarDatosCliente() {
    document.getElementById('clienteNombre').disabled = false;
    document.getElementById('clienteTelefono').disabled = false;
    document.getElementById('btn-actualizar').classList.remove('d-none');
    document.getElementById('btn-habilitar').classList.add('d-none');
}

function actualizarDatosCliente() {
    const nombre = document.getElementById('clienteNombre').value.trim();
    const telefono = document.getElementById('clienteTelefono').value.trim();
    
    if (!nombre || !telefono) {
        alert('Completa todos los campos');
        return;
    }

    const formData = new FormData();

    formData.append('nombre', nombre);
    formData.append('telefono', telefono);
    formData.append('id_cliente', sessionStorage.getItem('id_cliente'));

    fetch('index.php?action=guardarDatosCliente', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(r => {
        if (r.success) {

            sessionStorage.setItem('nombre', nombre);
            sessionStorage.setItem('telefono', telefono);

            actualizarNavbar();

            alert('Perfil actualizado');

            const perfilModal = document.getElementById('perfilModal');

            const modal = bootstrap.Modal.getInstance(perfilModal) || new bootstrap.Modal(perfilModal);
            modal.hide();

        } else {
            alert('Error al actualizar perfil');
        }
    })
    .catch(() => alert('Error en la petición'));
}

function abrirPerfil() {
    document.getElementById('clienteNombre').value = sessionStorage.getItem('nombre') ?? '';
    document.getElementById('clienteEmail').value = sessionStorage.getItem('email') ?? '';
    document.getElementById('clienteTelefono').value = sessionStorage.getItem('telefono') ?? '';

    const perfilModal = document.getElementById('perfilModal');

    const modal = bootstrap.Modal.getInstance(perfilModal) || new bootstrap.Modal(perfilModal);
    modal.show();
}

function abrirReservas() {
    const reservasClienteModal = document.getElementById('reservasClienteModal');

    const modal = bootstrap.Modal.getInstance(reservasClienteModal) || new bootstrap.Modal(reservasClienteModal);
    modal.show();
}
