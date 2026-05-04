function cancelarReserva(id_reserva) {
    if (!confirm("¿Seguro que quieres cancelar esta reserva?")) {
        return;
    }

    fetch(BASE_URL + "admin?action=cancelarReserva", {
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