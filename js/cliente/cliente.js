function abrirDatosCliente() {
    const modalDatosCliente = document.getElementById('modalDatosCliente');
    const modal = bootstrap.Modal.getInstance(modalDatosCliente) || new bootstrap.Modal(modalDatosCliente);
    modal.show();
}

function cerrarDatosCliente() {
    const modalDatosCliente = document.getElementById('modalDatosCliente');
    const modal = bootstrap.Modal.getInstance(modalDatosCliente) || new bootstrap.Modal(modalDatosCliente);
    modal.hide();
}

function guardarDatosCliente() {
    const nombre = document.getElementById('nombreCliente').value.trim();
    const telefono = document.getElementById('telefonoCliente').value.trim();

    const errorTelefono = document.getElementById('errorTelefonoCliente');
    const errorNombre = document.getElementById('errorNombreCliente');

    errorTelefono.textContent = '';
    errorNombre.textContent = '';

    let error = false;

    if (!/^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/.test(nombre)) {
        errorNombre.textContent = 'El nombre solo puede contener letras y espacios.';
        error = true;
    }

    if (!nombre) {
        errorNombre.textContent = 'El nombre es obligatorio.';
        error = true;
    }

    if (!/^[0-9]{10}$/.test(telefono)) {
        errorTelefono.textContent = 'El teléfono debe tener 10 dígitos.';
        error = true;
    }

    if (!telefono) {
        errorTelefono.textContent = 'El teléfono es obligatorio.';
        error = true;
    }

    const formData = new FormData();

    formData.append('nombre', nombre);
    formData.append('telefono', telefono);

    fetch(BASE_URL + 'cliente?action=guardarDatosCliente', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success && data.cliente) {
            cerrarDatosCliente();
            successLogin(data.cliente);
        } else {
            mostrarToast(data.msg || 'Error al guardar datos.', 'error');
        }
    })
    .catch(() => mostrarToast('Error en la petición.', 'error'));
}

function abrirReservasCliente() {
    const modalReservasCliente = document.getElementById('modalReservasCliente');
    const modal = bootstrap.Modal.getInstance(modalReservasCliente) || new bootstrap.Modal(modalReservasCliente);
    modal.show();
}

function cerrarReservasCliente() {
    const modalReservasCliente = document.getElementById('modalReservasCliente');
    const modal = bootstrap.Modal.getInstance(modalReservasCliente) || new bootstrap.Modal(modalReservasCliente);
    modal.hide();
}

function abrirPerfilCliente() {
    document.getElementById('emailPerfil').value = sessionStorage.getItem('email_cliente') ?? '';
    document.getElementById('nombrePerfil').value = sessionStorage.getItem('nombre_cliente') ?? '';
    document.getElementById('telefonoPerfil').value = sessionStorage.getItem('telefono_cliente') ?? '';

    const modalPerfilCliente = document.getElementById('modalPerfilCliente');
    const modal = bootstrap.Modal.getInstance(modalPerfilCliente) || new bootstrap.Modal(modalPerfilCliente);
    modal.show();
}

function habilitarDatosCliente() {
    document.getElementById('nombrePerfil').disabled = false;
    document.getElementById('telefonoPerfil').disabled = false;
    document.getElementById('btn-actualizar').classList.remove('d-none');
    document.getElementById('btn-habilitar').classList.add('d-none');
    document.getElementById('btn-eliminar').classList.add('d-none');
}

function actualizarDatosCliente() {
    const nombre = document.getElementById('nombrePerfil').value.trim();
    const telefono = document.getElementById('telefonoPerfil').value.trim();

    const errorTelefono = document.getElementById('errorTelefonoPerfil');
    const errorNombre = document.getElementById('errorNombrePerfil');

    errorTelefono.textContent = '';
    errorNombre.textContent = '';

    let error = false;

    if (!/^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/.test(nombre)) {
        errorNombre.textContent = 'El nombre solo puede contener letras y espacios.';
        error = true;
    }

    if (!nombre) {
        errorNombre.textContent = 'El nombre es obligatorio.';
        error = true;
    }

    if (!/^[0-9]{10}$/.test(telefono)) {
        errorTelefono.textContent = 'El teléfono debe tener 10 dígitos.';
        error = true;
    }

    if (!telefono) {
        errorTelefono.textContent = 'El teléfono es obligatorio.';
        error = true;
    }

    const formData = new FormData();

    formData.append('nombre', nombre);
    formData.append('telefono', telefono);

    fetch(BASE_URL + 'cliente?action=actualizarDatosCliente', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            sessionStorage.setItem('nombre_cliente', nombre);
            sessionStorage.setItem('telefono_cliente', telefono);

            actualizarNavbar();

            mostrarToast('Perfil actualizado.', 'success');

            const modalPerfilCliente = document.getElementById('modalPerfilCliente');
            const modal = bootstrap.Modal.getInstance(modalPerfilCliente) || new bootstrap.Modal(modalPerfilCliente);
            modal.hide();

        } else {
            mostrarToast(data.msg || 'Error al actualizar perfil.', 'error');
        }
    })
    .catch(() => mostrarToast('Error en la petición.', 'error'));
}

function eliminarDatosCliente() {
    if (!confirm('¿Estás seguro de eliminar tu cuenta? Esta acción no se puede deshacer.')) {
        return;
    }

    const formData = new FormData();

    formData.append('id_cliente', sessionStorage.getItem('id_cliente'));
    
    fetch(BASE_URL + 'cliente?action=eliminarDatosCliente', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            sessionStorage.removeItem('id_cliente');
            sessionStorage.removeItem('email_cliente');
            sessionStorage.removeItem('nombre_cliente');
            sessionStorage.removeItem('telefono_cliente');

            actualizarNavbar();

            mostrarToast('Cuenta eliminada.', 'success');

            const modalPerfilCliente = document.getElementById('modalPerfilCliente');
            const modal = bootstrap.Modal.getInstance(modalPerfilCliente) || new bootstrap.Modal(modalPerfilCliente);
            modal.hide();
        } else {
            mostrarToast(data.msg || 'Error al eliminar cuenta.', 'error');
        }
    })
    .catch(() => mostrarToast('Error en la petición.', 'error'));
}
