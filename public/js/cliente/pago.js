function iniciarPayPal() {

    paypal.Buttons ({
        
        createOrder: function() {

            const total = sessionStorage.getItem('precio_evento');

            const formData = new FormData();

            formData.append('id_reserva', reservaID);
            formData.append('monto', total);
            
            return fetch("index.php?action=crearOrden", {
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
            
            return fetch("index.php?action=capturarPago", {
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