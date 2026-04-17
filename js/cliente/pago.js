//Función para crear y capturar una orden de pago desde el boton de PayPal
function renderPayPal() {
    const paypalDiv = document.getElementById('paypal-button');
    const id_reserva = paypalDiv.dataset.reserva;

    paypalDiv.innerHTML = '';

    paypal.Buttons ({
        
        createOrder: function() {
            return crearOrdenPaypal(id_reserva);
        },
        
        onApprove: function (data) {
            return fetch(BASE_URL + "cliente?action=capturarPago", {
                method:"POST",
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `orderID=${data.orderID}&id_reserva=${id_reserva}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "ok") {
                    mostrarToast('Pago completado.', 'success');
                    location.reload();
                    mostrarToast('Para visualizar tu reserva, ve a "Mis Reservas".', 'info');
                } else {
                    mostrarToast(data.msg || 'Error en el pago.', 'error');
                }
            });
        }
    }).render('#paypal-button');
}

//Funcion para crear la orden de pago
function crearOrdenPaypal(id_reserva) {
    return fetch(BASE_URL + "cliente?action=crearOrden", {
        method:"POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id_reserva=' + id_reserva
    })
    .then(res => res.json())
    .then(data => {
        if (data.status !== "ok") {
            mostrarToast(data.msg || 'Error creando orden.', 'error');
            throw new Error("Orden invalida.");
        }
        return data.orderID;
    });
}

//Función para pagar una reserva en caso de fallo
function pagarReserva(id_reserva) {
    const paypalDiv = document.getElementById('paypal-button');
    paypalDiv.dataset.reserva = id_reserva;

    cerrarReservasCliente();
    abrirDatosReserva();
    goToStep(3);
    renderPayPal();
}
