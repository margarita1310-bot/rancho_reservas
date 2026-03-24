function reservarEvento(btn) {
    sessionStorage.setItem('id_evento', btn.dataset.id);
    sessionStorage.setItem('nombre_evento', btn.dataset.nombre);
    sessionStorage.setItem('fecha_evento', btn.dataset.fecha);
    sessionStorage.setItem('precio_evento', btn.dataset.precio);

    abrirReserva();
}

function abrirReserva() {
    const id_cliente = sessionStorage.getItem('id_cliente');

    if(!id_cliente) {
        const loginModal = document.getElementById('loginModal');

        const modal = bootstrap.Modal.getInstance(loginModal) || new bootstrap.Modal(loginModal);
        modal.show();
        return;
    }

    const nombre = sessionStorage.getItem('nombre');
    const telefono = sessionStorage.getItem('telefono');

    if (!nombre || !telefono) {
        const datosModal = document.getElementById('datosModal');

        const modal = bootstrap.Modal.getInstance(datosModal) || new bootstrap.Modal(datosModal);
        modal.show();
        return;
    }

    const reservaModal = document.getElementById('reservaModal');

    const modal = bootstrap.Modal.getInstance(reservaModal) || new bootstrap.Modal(reservaModal);
    cargarDatosEvento();
    modal.show();
}

function guardarDatosReserva() {
    const hora = document.getElementById('eventoHora').value;
    const personas = document.getElementById('eventoPersonas').value;

    if (!hora) {
        alert("Por favor selecciona una hora");
        return;
    }

    if (hora < "18:00" || hora > "23:00") {
        alert("La hora debe estar entre 6:00 PM y 11:00 PM");
        return;
    }

    if (!personas || personas < 1 || personas > 20) {
        alert("El número de personas debe ser entre 1 y 20");
        return;
    }

    sessionStorage.setItem('hora', hora);
    sessionStorage.setItem('personas', personas);

    cargarConfirmacion();
    goToStep(2);
}

function cargarConfirmacion() {
    document.getElementById('confirmarNombre').textContent =
        sessionStorage.getItem('nombre') ?? '';

    document.getElementById('confirmarEmail').textContent =
        sessionStorage.getItem('email') ?? '';

    document.getElementById('confirmarTelefono').textContent =
        sessionStorage.getItem('telefono') ?? '';

    document.getElementById('confirmarEvento').textContent =
        sessionStorage.getItem('nombre_evento') ?? '';

    document.getElementById('confirmarFecha').textContent =
        sessionStorage.getItem('fecha_evento') ?? '';

    document.getElementById('confirmarPrecio').textContent =
        sessionStorage.getItem('precio_evento') ?? '';

    document.getElementById('confirmarHora').textContent =
        sessionStorage.getItem('hora') ?? '';

    document.getElementById('confirmarPersonas').textContent =
        sessionStorage.getItem('personas') ?? '';
}

let reservaID = null;

function crearReserva() {
    const formData =  new FormData();

    const id_cliente = sessionStorage.getItem('id_cliente');
    const id_evento = sessionStorage.getItem('id_evento');
    const mesas_reservadas = 1;
    const personas = sessionStorage.getItem('personas');
    const precio = sessionStorage.getItem('precio_evento');

    formData.append('id_cliente', id_cliente);
    formData.append('id_evento', id_evento);
    formData.append('mesas_reservadas', mesas_reservadas);
    formData.append('personas', personas);
    formData.append('total', precio);
    formData.append('estado', 'pendiente');


    fetch("index.php?action=guardarReserva", {
        method:"POST",
        body: formData
    })

    .then(r => r.json())
    .then(r => {
        if(r.status === "ok") {
            reservaID = r.id_reserva;
            iniciarPayPal();
            goToStep(3);
        } else {
            alert("Error al crear la reserva")
        }
    })
    .catch(() => alert('Error en la petición'));
}

function goToStep(step) {
    document.querySelectorAll('.step').forEach(s => s.classList.add('d-none'));
    document.getElementById('step' + step).classList.remove('d-none');
}

function cargarDatosEvento() {
    document.getElementById('eventoNombre').value = sessionStorage.getItem('nombre_evento');
    document.getElementById('eventoFecha').value = sessionStorage.getItem('fecha_evento');
    document.getElementById('eventoPrecio').value = sessionStorage.getItem('precio_evento');
}
