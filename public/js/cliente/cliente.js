//Función para abrir el modal y ingresar datos del cliente nuevo en datosModal
function abrirDatosModal() {
    const loginModal = document.getElementById('loginModal');
    const modalLogin = bootstrap.Modal.getInstance(loginModal) || new bootstrap.Modal(loginModal);
    modalLogin.hide();
    
    const datosModal = document.getElementById('datosModal');
    const modalDatos = bootstrap.Modal.getInstance(datosModal) || new bootstrap.Modal(datosModal);
    modalDatos.show();
}

//Función para guardar los datos del cliente del modal datosModal
function guardarDatosCliente() {
    const nombre = document.getElementById('nombre').value.trim();
    const telefono = document.getElementById('telefono').value.trim();

    if (!nombre || !telefono) {
        alert("Completa todos los campos.");
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

            alert("Inicio de sesión exitoso.");

            actualizarNavbar();

        } else {
            alert("Error al guardar datos");
        }
    })
    .catch(() => alert("Error en la petición"));
}

//Función para abrir el modal para visualizar datos del cliente perfilModal
function abrirPerfil() {
    document.getElementById('clienteNombre').value = sessionStorage.getItem('nombre') ?? '';
    document.getElementById('clienteEmail').value = sessionStorage.getItem('email') ?? '';
    document.getElementById('clienteTelefono').value = sessionStorage.getItem('telefono') ?? '';

    const perfilModal = document.getElementById('perfilModal');
    const modal = bootstrap.Modal.getInstance(perfilModal) || new bootstrap.Modal(perfilModal);
    modal.show();
}

//Función para habilitar los inputs de los datos del cliente al editar perfilModal
function habilitarDatosCliente() {
    document.getElementById('clienteNombre').disabled = false;
    document.getElementById('clienteTelefono').disabled = false;
    document.getElementById('btn-actualizar').classList.remove('d-none');
    document.getElementById('btn-habilitar').classList.add('d-none');
}

//Función para actualizar los datos del cliente perfilModal
function actualizarDatosCliente() {
    const nombre = document.getElementById('clienteNombre').value.trim();
    const telefono = document.getElementById('clienteTelefono').value.trim();
    
    if (!nombre || !telefono) {
        alert("Completa todos los campos.");
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

            alert("Perfil actualizado.");

            const perfilModal = document.getElementById('perfilModal');
            const modal = bootstrap.Modal.getInstance(perfilModal) || new bootstrap.Modal(perfilModal);
            modal.hide();

        } else {
            alert("Error al actualizar perfil.");
        }
    })
    .catch(() => alert("Error en la petición."));
}

//Función para visualizar las reservas del cliente modal reservasClienteModal
function abrirReservas() {
    const reservasClienteModal = document.getElementById('reservasClienteModal');
    const modal = bootstrap.Modal.getInstance(reservasClienteModal) || new bootstrap.Modal(reservasClienteModal);
    modal.show();
}
