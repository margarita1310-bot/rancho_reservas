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
    const body = document.getElementById('modalBody');
    if (!body) return;
    
    const fecha = body.querySelector('#fecha');
    const horaInicio = body.querySelector('#hora');
    const horaFin = body.querySelector('#hora_fin');
    const duracionEvento = body.querySelector('#duracion');
    
    const hoy = new Date().toISOString().split('T')[0];

    if (fecha) {
        fecha.min = hoy;
    }

    if (horaInicio && horaFin) {
        horaInicio.addEventListener('change', () => {
            horaFin.min = horaInicio.value;
        });
    }

    function calcularHoraFin() {
        const hora = horaInicio.value;
        const duracion = parseInt(duracionEvento.value);

        if (!hora || !duracion) return;

        const [h, m] = hora.split(':').map(Number);

        let fechaTemp = new Date();
        fechaTemp.setHours(h + duracion);
        fechaTemp.setMinutes(m);

        const horas = String(fechaTemp.getHours()).padStart(2, '0');
        const minutos = String(fechaTemp.getMinutes()).padStart(2, '0');

        horaFin.value = `${horas}:${minutos}`;
    }

    if (horaInicio && duracionEvento) {
        horaInicio.addEventListener('change', calcularHoraFin);
        duracionEvento.addEventListener('input', calcularHoraFin);
    }

    if (horaInicio?.value && horaFin?.value && duracionEvento) {
        const [h1, m1] = horaInicio.value.split(':').map(Number);
        const [h2, m2] = horaFin.value.split(':').map(Number);
        
        let inicio = new Date();
        inicio.setHours(h1, m1);

        let fin = new Date();
        fin.setHours(h2, m2);

        let diff = (fin - inicio) / (1000 * 60 * 60);

        if (diff > 0) {
            duracionEvento.value = diff;
        }
    }
}

document.getElementById('filtro-fecha-reserva').addEventListener('change', function () {
    const fechaSeleccionada = this.value;
    const filas = document.querySelectorAll('tbody tr');

    filas.forEach(fila => {
        const fecha = fila.getAttribute('data-fecha');

        if (!fechaSeleccionada || fecha === fechaSeleccionada) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });
});

