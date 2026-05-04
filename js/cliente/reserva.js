function botonReservar(btn) {
    const id_evento = btn.dataset.id;

    fetch(BASE_URL + "cliente?action=verificarMesas&id_evento=" + id_evento)
    .then(res => res.json())
    .then(data => {
        if (data.status === "error") {
            btn.disabled = true;
            btn.textContent = "Sin disponibilidad";
            return;
        }
        
        sessionStorage.setItem('id_evento', btn.dataset.id);
        sessionStorage.setItem('nombre_evento', btn.dataset.nombre);
        sessionStorage.setItem('fecha_evento', btn.dataset.fecha);
        sessionStorage.setItem('hora_evento', btn.dataset.hora);
        sessionStorage.setItem('hora_fin_evento', btn.dataset.hora_fin);
        sessionStorage.setItem('precio_evento', btn.dataset.precio);

        abrirTyC();
    });
}

function abrirTyC() {
    const modalTyC = document.getElementById('modalTyC');
    const modal = bootstrap.Modal.getInstance(modalTyC) || new bootstrap.Modal(modalTyC);
    modal.show();
}

function cerrarTyC() {
    const modalTyC = document.getElementById('modalTyC');
    const modal = bootstrap.Modal.getInstance(modalTyC) || new bootstrap.Modal(modalTyC);
    modal.hide();
}

function abrirDatosReserva() {
    cerrarTyC();
    const id_cliente = sessionStorage.getItem('id_cliente');
    const nombre = sessionStorage.getItem('nombre_cliente');
    const telefono = sessionStorage.getItem('telefono_cliente');

    if(!id_cliente) {
        sessionStorage.setItem('accion_post', 'reservar');
        abrirAdP();
        return;
    } else if (!nombre || !telefono) {
        abrirDatosCliente();
        return;
    }

    const modalReservar = document.getElementById('modalReservar');
    const modal = bootstrap.Modal.getInstance(modalReservar) || new bootstrap.Modal(modalReservar);
    cargarDatosEvento();
    
    modal.show();
}

function cerrarDatosReserva() {
    const modalReservar = document.getElementById('modalReservar');
    const modal = bootstrap.Modal.getInstance(modalReservar) || new bootstrap.Modal(modalReservar);
    modal.hide();
}

function cargarDatosEvento() {
    document.getElementById('nombreEvento').value = sessionStorage.getItem('nombre_evento');
    document.getElementById('fechaEvento').value = sessionStorage.getItem('fecha_evento');
    document.getElementById('precioEvento').value = sessionStorage.getItem('precio_evento');

    const horaEvento = sessionStorage.getItem('hora_evento');
    const horaFinEvento = sessionStorage.getItem('hora_fin_evento');

    const eventoInicio = aMinutos(horaEvento);
    let eventoFin = aMinutos(horaFinEvento);

    if (eventoFin < eventoInicio) {
        eventoFin += 24 * 60;
    }

    const inicioLlegada = eventoInicio - (4 * 60);
    const finLlegada = eventoInicio;

    const inicioHora = minutosAHora(inicioLlegada);
    const finHora = minutosAHora(finLlegada);

    const infoHora = document.getElementById('info-hora');
    const infoPersonas = document.getElementById('info-personas');

    infoHora.innerHTML = `Puedes llegar entre ${inicioHora} y ${finHora}`;
    infoPersonas.innerHTML = `Ingrese de 4 a 10 personas.`;
}

function guardarDatosReserva() {
    const hora = document.getElementById('horaEvento').value;
    const personas = document.getElementById('personasEvento').value;
    const personasInt = Number(personas);

    const fechaEvento = sessionStorage.getItem('fecha_evento');
    const horaEvento = sessionStorage.getItem('hora_evento');
    const horaFinEvento = sessionStorage.getItem('hora_fin_evento');

    const errorHoraEvento = document.getElementById('errorHoraEvento');
    const errorPersonasEvento = document.getElementById('errorPersonasEvento');

    errorHoraEvento.textContent = '';
    errorPersonasEvento.textContent = '';

    let error = false;

    const llegada = aMinutos(hora);
    const eventoInicio = aMinutos(horaEvento);
    const eventoFin = aMinutos(horaFinEvento);
    
    let eventoFinAjustado = eventoFin;
    if (eventoFin < eventoInicio) {
        eventoFinAjustado += 24 * 60;
    }
    
    const inicioLlegada = eventoInicio - (4 * 60);
    const finLlegada = eventoInicio;

    let llegadaAjustada = llegada;

    if (llegada < inicioLlegada) {
        llegadaAjustada += 24 * 60;
    }

    if (llegadaAjustada < inicioLlegada || llegadaAjustada > finLlegada) {
        errorHoraEvento.textContent = 'La hora de llegada es incorrecta.';
        error = true;
    }

    const inicioEvento = new Date(`${fechaEvento}T${horaEvento}:00`);
    const ahora = new Date();
    
    const finReserva = new Date(inicioEvento);
    finReserva.setHours(finReserva.getHours() + 1);

    if (ahora > finReserva) {
        mostrarToast("Ya no es posible reservar, el evento inició hace más de 1 hora.", 'error');
        return;
    }

    if (!hora) {
        errorHoraEvento.textContent = 'La hora de llegada es obligatoria.';
        error = true;
    }

    if (!personas) {
        errorPersonasEvento.textContent = 'El número de personas es obligatorio.';
        error = true;
    }

    if (!Number.isInteger(personasInt) || personasInt < 4 || personasInt > 10) {
        errorPersonasEvento.textContent = 'El número de personas es incorrecto.';
        error = true;
    }
    
    if (error) {
        mostrarToast('Completa los campos correctamente.', 'error');
        return;

    } else {     
        sessionStorage.setItem('hora_evento', hora);
        sessionStorage.setItem('personas_evento', personasInt);

        cargarDatosReserva();
        goToStep(2);
    }
}

function cargarDatosReserva() {
    document.getElementById('confirmarNombre').textContent =
        sessionStorage.getItem('nombre_cliente') ?? '';

    document.getElementById('confirmarEmail').textContent =
        sessionStorage.getItem('email_cliente') ?? '';

    document.getElementById('confirmarTelefono').textContent =
        sessionStorage.getItem('telefono_cliente') ?? '';

    document.getElementById('confirmarEvento').textContent =
        sessionStorage.getItem('nombre_evento') ?? '';

    document.getElementById('confirmarFecha').textContent =
        sessionStorage.getItem('fecha_evento') ?? '';

    document.getElementById('confirmarPrecio').textContent =
        sessionStorage.getItem('precio_evento') ?? '';

    document.getElementById('confirmarHora').textContent =
        sessionStorage.getItem('hora_evento') ?? '';

    document.getElementById('confirmarPersonas').textContent =
        sessionStorage.getItem('personas_evento') ?? '';
}

let reservaID = null;
function crearReserva() {
    if (reservaID) {
        const paypalDiv = document.getElementById('paypal-button');
        paypalDiv.dataset.reserva = reservaID;

        goToStep(3);
        renderPayPal();
        return;
    }

    const formData =  new FormData();

    const id_evento = sessionStorage.getItem('id_evento');
    const mesas_reservadas = 1;
    const personas = sessionStorage.getItem('personas_evento');
    const precio = sessionStorage.getItem('precio_evento');

    formData.append('id_evento', id_evento);
    formData.append('mesas_reservadas', mesas_reservadas);
    formData.append('personas', personas);
    formData.append('total', precio);

    fetch(BASE_URL + "cliente?action=guardarReserva", {
        method:"POST",
        body: formData
    })
    .then(r => r.json())
    .then(r => {
        if(r.status === "ok") {
            reservaID = r.id_reserva;

            const paypalDiv = document.getElementById('paypal-button');
            paypalDiv.dataset.reserva = reservaID;

            goToStep(3);

            renderPayPal();
        } else {
            mostrarToast(r.msg || 'Error al crear la reserva.', 'error');
        }
    })
    .catch(() => mostrarToast('Error en la petición.', 'error'));
}

function cancelarReserva(id_reserva) {
    if (!confirm("¿Seguro que quieres cancelar esta reserva?")) {
        return;
    }

    fetch(BASE_URL + "cliente?action=cancelarReserva", {
        method:"POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id_reserva=' + id_reserva
    })
    .then(r => r.json())
    .then(r => {
        if (r.status === "ok") {
            mostrarToast("Reserva cancelada correctamente.", 'success');
            location.reload();
        } else {
            mostrarToast(r.msg || 'Error al cancelar la reserva.', 'error');
        }
    })
    .catch(() => mostrarToast('Error en la conexión.', 'error'));
}

function verComprobante(id_reserva) {
    window.open(`cliente?action=comprobante&id_reserva=${id_reserva}`, '_blank');
}
