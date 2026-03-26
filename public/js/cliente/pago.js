function renderPayPal() {
    const paypalDiv = document.getElementById('paypal-button');
    const id_reserva = paypalDiv.dataset.reserva;

    paypalDiv.innerHTML = '';

    paypal.Buttons ({
        
        createOrder: function() {
            return crearOrdenPaypal(id_reserva);
        },
        
        onApprove: function (data) {
            return fetch("index.php?action=capturarPago", {
                method:"POST",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `orderID=${data.orderID}&id_reserva=${id_reserva}`
            })
            .then(r => r.json())
            .then(r => {
                if (r.status === "ok") {
                    alert("Pago completado");
                    location.reload();
                } else {
                    alert("Error en el pago");
                }
            });
        }
    }).render('#paypal-button');
}

function crearOrdenPaypal(id_reserva) {
    return fetch("index.php?action=crearOrden", {
        method:"POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id_reserva=' + id_reserva
    })
    .then(r => r.json())
    .then(r => {

        if (r.status !== "ok") {
            alert("Error creando orden");
            throw new Error("Orden invalida");
        }

        return r.orderID;
    });
}

function pagarReserva(id_reserva) {
    const paypalDiv = document.getElementById('paypal-button');
    paypalDiv.dataset.reserva = id_reserva;

    const reservasClienteModal = document.getElementById('reservasClienteModal');

    const modalReservas = bootstrap.Modal.getInstance(reservasClienteModal) || new bootstrap.Modal(reservasClienteModal);
    modalReservas.hide();
    
    const reservaModal = document.getElementById('reservaModal');
    
    const modalPago = bootstrap.Modal.getInstance(reservaModal) || new bootstrap.Modal(reservaModal);
    modalPago.show();

    goToStep(3);

    renderPayPal();
}
