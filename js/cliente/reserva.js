//Función para navegar por el modal reservaModal
function goToStep(step) {
    document.querySelectorAll('.step').forEach(s => s.classList.add('d-none'));
    document.getElementById('step' + step).classList.remove('d-none');

    document.querySelectorAll('.step-indicator').forEach(s => {
        s.classList.remove('active', 'completed');
    });

    for (let i = 1; i <= 3 ; i++) {
        const indicator = document.getElementById('indicator' + i);

        if (i < step) {
            indicator.classList.add('completed');
            indicator.innerHTML = '<i class="bi bi-check"></i>';
        } else if (i === step) {
            indicator.classList.add('active');
            indicator.innerHTML = i;
        } else {
            indicator.innerHTML = i;
        }
    }
}

function aMinutos(hhmm) {
    const [h, m] = hhmm.split(":").map(Number);
    return h * 60 + m;
}

function minutosAHora(min) {
    min = min % (24 * 60);

    const h = Math.floor(min / 60);
    const m = min % 60;

    return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;
}

//Funcion para cargar los datos del evento en el modal
function cargarDatosEvento() {
    document.getElementById('eventoNombre').value = sessionStorage.getItem('nombre_evento');
    document.getElementById('eventoFecha').value = sessionStorage.getItem('fecha_evento');
    document.getElementById('eventoPrecio').value = sessionStorage.getItem('precio_evento');
}

//Funcion del boton reservar
function reservarEvento(btn) {

    const id_evento = btn.dataset.id;

    fetch(BASE_URL + "cliente?action=verificarMesas&id_evento=" + id_evento)
    .then(r => r.json())
    .then(r => {
        if (r.status === "error") {
            btn.disabled = true;
            btn.textContent = "Sin disponibilidad";
            return;
        }
        
        sessionStorage.setItem('id_evento', btn.dataset.id);
        sessionStorage.setItem('nombre_evento', btn.dataset.nombre);
        sessionStorage.setItem('fecha_evento', btn.dataset.fecha);
        sessionStorage.setItem('precio_evento', btn.dataset.precio);
        sessionStorage.setItem('hora_evento', btn.dataset.hora);
        sessionStorage.setItem('hora_fin_evento', btn.dataset.hora_fin);
        
        const horaEvento = btn.dataset.hora;
        const horaFinEvento = btn.dataset.hora_fin;
        
        const eventoInicio = aMinutos(horaEvento);
        let eventoFin = aMinutos(horaFinEvento);
    
        if (eventoFin < eventoInicio) {
            eventoFin += 24 * 60;
        }
    
        const inicioLlegada = eventoInicio - (2 * 60);
        const finLlegada = eventoFin - (2 * 60);
    
        const inicioHora = minutosAHora(inicioLlegada);
        const finHora = minutosAHora(finLlegada);
    
        
        document.getElementById('info-hora').innerHTML =
        `Puedes llegar entre ${inicioHora} y ${finHora}`;
    
        document.getElementById('info-personas').innerHTML =
        `Ingrese de 1 a 20 personas.`;
        
        abrirReserva();
    });
}

//Función que abre el modal para insertar los datos faltantes de la reserva reservaModal
function abrirReserva() {
    const id_cliente = sessionStorage.getItem('id_cliente');

    if(!id_cliente) {
        alert("Inicia sesión primero.");

        const loginModal = document.getElementById('loginModal');
        const modal = bootstrap.Modal.getInstance(loginModal) || new bootstrap.Modal(loginModal);
        modal.show();

        return;
    }

    const nombre = sessionStorage.getItem('nombre');
    const telefono = sessionStorage.getItem('telefono');

    if (!nombre || !telefono) {
        alert("Asegúrate de ingresar los siguientes datos correctamente.");

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

//Función para guardar los datos de la reserva en reservaModal
function guardarDatosReserva() {
    const hora = document.getElementById('eventoHora').value;
    const personas = document.getElementById('eventoPersonas').value;

    const fechaEvento = sessionStorage.getItem('fecha_evento');
    const horaEvento = sessionStorage.getItem('hora_evento');
    const horaFinEvento = sessionStorage.getItem('hora_fin_evento');

    if (!hora) {
        alert("Por favor selecciona una hora.");
        return;
    }

    if (!horaEvento || !horaFinEvento) {
        alert("Error con horarios del evento.");
        return;
    }

    const llegada = aMinutos(hora);
    const eventoInicio = aMinutos(horaEvento);
    const eventoFin = aMinutos(horaFinEvento);
    
    let eventoFinAjustado = eventoFin;
    if (eventoFin < eventoInicio) {
        eventoFinAjustado += 24 * 60;
    }
    
    const inicioLlegada = eventoInicio - (2 * 60);
    const finLlegada = eventoFinAjustado - (2 * 60);

    let llegadaAjustada = llegada;
    if (llegada < inicioLlegada) {
        llegadaAjustada += 24 * 60;
    }

    if (llegadaAjustada < inicioLlegada || llegadaAjustada > finLlegada) {
        alert("La hora de llegada debe ser entre 2 horas antes de iniciar y 2 horas antes de terminar el evento.");
        return;
    }

    const inicioEvento = new Date(`${fechaEvento}T${horaEvento}:00`);
    const ahora = new Date();
    
    const finReserva = new Date(inicioEvento);
    finReserva.setHours(finReserva.getHours() + 1);

    if (ahora > finReserva) {
        alert("Ya no es posible reservar, el evento inició hace más de 1 hora.");
        return;
    }

    if (!personas || personas < 1 || personas > 20) {
        alert("El número de personas debe ser entre 1 y 20.");
        return;
    }

    sessionStorage.setItem('hora', hora);
    sessionStorage.setItem('personas', personas);

    cargarConfirmacion();
    goToStep(2);
}

//Función que carga los datos de la reserva raservaModal
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

//Función que guarda los datos de la reserva para seguir con el pago
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
            alert("Error al crear la reserva.")
        }
    })
    .catch(() => alert("Error en la petición."));
}

//Función para cancelar la reserva
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
            alert("Reserva cancelada correctamente.");
            location.reload();
        } else {
            alert(r.msg || "Error al cancelar.");
        }
    })
    .catch(() => alert("Error en la conexión."));
}

//Función para ver el comprobante de pago de la reserva
function verComprobante(id_reserva) {
    window.open(`cliente?action=comprobante&id_reserva=${id_reserva}`, '_blank');
}
