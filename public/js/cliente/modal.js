function goToStep(step) {
    document.querySelectorAll('.step').forEach(s => s.classList.add('d-none'));
    document.getElementById('step' + step).classList.remove('d-none');
}

function reservar(idEvento) {
    fetch(`evento.php?action=obtener&id=${idEvento}`)
    .then(res => res.json())
    .then(data => {
        if(data.success){
            document.getElementById('evento-nombre').value = data.evento.nombre;
            document.getElementById('evento-fecha').value = data.evento.fecha;
            sessionStorage.setItem('id_evento', idEvento);
            sessionStorage.setItem('nombre', data.evento.nombre);
            sessionStorage.setItem('fecha', data.evento.fecha);
            nextStep(1);
        }
    });
}

document.querySelectorAll('[data-bs-target="#reservaModal"]').forEach(btn => {
    btn.addEventListener('click', () => {
        sessionStorage.setItem('id_evento', btn.dataset.id);
        sessionStorage.setItem('nombre_evento', btn.dataset.nombre);
        sessionStorage.setItem('fecha_evento', btn.dataset.fecha);
        sessionStorage.setItem('precio_evento', btn.dataset.precio);

        goToStep(1);
    });
});

function cargarDatosEvento() {
    document.getElementById('eventoNombre').value = sessionStorage.getItem('nombre_evento');
    document.getElementById('eventoFecha').value = sessionStorage.getItem('fecha_evento');
    document.getElementById('eventoPrecio').value = sessionStorage.getItem('precio_evento');
}

function guardarDatosCliente() {
    const nombre = document.getElementById('nombre').value.trim();
    const telefono = document.getElementById('telefono').value.trim();

    if (!nombre || !telefono) {
        alert('Completa todos los campos');
        return;
    }

    fetch('auth.php?action=guardarDatosCliente', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `nombre=${nombre}&telefono=${telefono}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            sessionStorage.setItem('nombre', nombre);
            sessionStorage.setItem('telefono', telefono);
            cargarDatosEvento();
            goToStep(3);
        } else {
            alert('Error al guardar datos');
        }
    });
}

function guardarDatosReserva() {
    const hora = document.getElementById('eventoHora').value;
    const personas = document.getElementById('personas').value;

    if (!hora || !personas || personas < 1) {
        alert('Completa todos los campos correctamente');
        return;
    }

    sessionStorage.setItem('hora', hora);
    sessionStorage.setItem('personas', personas);

    cargarConfirmacion();
    goToStep(4);
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

function resetReservaModal() {
    document.querySelectorAll('#reservaModal input').forEach(input => {
        if (input.type !== 'hidden') {
            input.value = '';
        }
    });

    document.querySelectorAll('#reservaModal .step').forEach(step => {
        step.classList.add('d-none');
    });
    
    document.getElementById('step1').classList.remove('d-none');
    
    document.getElementById('bloqueCodigo')?.classList.add('d-none');
    document.getElementById('btnValidarCodigo')?.classList.add('d-none');
    
    document.querySelectorAll('#reservaModal span').forEach(span => {
        span.textContent = '';
    });

    sessionStorage.clear();
}

const reservaModal = document.getElementById('reservaModal');

reservaModal.addEventListener('hidden.bs.modal', () => {
    resetReservaModal();
});