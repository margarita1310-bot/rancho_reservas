function configurarFechasPromocion() {

    const hoy = new Date().toISOString().split('T')[0];

    const fechaInicio = document.getElementById('fecha_inicio');
    const fechaFin = document.getElementById('fecha_fin');

    if (fechaInicio) {
        fechaInicio.min = hoy;

        fechaInicio.addEventListener('change', () => {
            if (fechaFin) {
                fechaFin.min = fechaInicio.value;
            }
        });
    }

    if (fechaFin) {
        fechaFin.min = hoy;
    }

}

function configurarFechaEvento() {

    const hoy = new Date().toISOString().split('T')[0];

    const fecha = document.getElementById('fecha');
    const horaInicio = document.getElementById('hora');
    const horaFin = document.getElementById('hora_fin');

    if (fecha) {
        fecha.min = hoy;
    }

    if (horaInicio && horaFin) {
        horaInicio.addEventListener('change', () => {
            horaFin.min = horaInicio.value;
        });
    }

}