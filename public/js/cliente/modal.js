function goToStep(step) {
    document.querySelectorAll('.step').forEach(s => s.classList.add('d-none'));
    document.getElementById('step' + step).classList.remove('d-none');
}

function reservar(idEvento) {
    const formData = new FormData();
    formData.append('id', idEvento);

    fetch('evento.php?action=obtener', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(r => {
        if(r){
            document.getElementById('evento-nombre').value = r.evento.nombre;
            document.getElementById('evento-fecha').value = r.evento.fecha;

            sessionStorage.setItem('id_evento', idEvento);
            sessionStorage.setItem('nombre', r.evento.nombre);
            sessionStorage.setItem('fecha', r.evento.fecha);

            goToStep(1);
        }
    })
    .catch(() => alert('Error en la petición'));
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

    const formData = new FormData();

    formData.append('nombre', nombre);
    formData.append('telefono', telefono);

    fetch('auth.php?action=guardarDatosCliente', {
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


    fetch("reserva.php?action=guardar", {
        method:"POST",
        body: formData
    })

    .then(r => r.json())
    .then(r => {
        if(r.status === "ok") {
            reservaID = r.id_reserva;
            iniciarPayPal();
            goToStep(5);
        } else {
            alert("Error al crear la reserva")
        }
    })
    .catch(() => alert('Error en la petición'));
}

function iniciarPayPal() {

    paypal.Buttons ({
        
        createOrder: function() {

            const total = sessionStorage.getItem('precio_evento');

            const formData = new FormData();

            formData.append('id_reserva', reservaID);
            formData.append('monto', total);
            
            return fetch("pago.php?action=crearOrden", {
                method:"POST",
                body: formData
            })
    
            .then(r => r.json())
            .then(r => {

                if (r.status !== "ok") {
                    alert("Error creando orden");
                    throw new Error("orden invalida");
                }

                return r.orderID;
            });
        },
        
        onApprove: function (data) {

            const formData = new FormData();
            formData.append('orderID', data.orderID);
            formData.append('id_reserva', reservaID);
            
            return fetch("pago.php?action=capturar", {
                method:"POST",
                body: formData
            })

            .then(r => r.json())
            .then(r => {

                if (r.status === "ok") {

                    alert("Pago realizado correctamente");
    
                    location.reload();

                } else {
                    alert("Error al capturar pago");
                }
            });
        }
    }).render('#paypal-button');
}

/*
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
*/