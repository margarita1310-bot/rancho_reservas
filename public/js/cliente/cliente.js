
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

            cargarDatosEvento();
            goToStep(3);
        } else {
            alert('Error al guardar datos');
        }
    })
    .catch(() => alert('Error en la petición'));
}

function loginExitoso(cliente) {

    document.getElementById('nombre').value = cliente?.nombre ?? '';
    document.getElementById('telefono').value = cliente?.telefono ?? '';

    sessionStorage.setItem('id_cliente', cliente.id_cliente);
    sessionStorage.setItem('nombre', cliente?.nombre ?? '');
    sessionStorage.setItem('email', cliente?.email ?? '');
    sessionStorage.setItem('telefono', cliente?.telefono ?? '');
    
    goToStep(2);
}