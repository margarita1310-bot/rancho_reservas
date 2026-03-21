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

        }
    })
    .catch(() => alert('Error en la petición'));
}

function cargarDatosEvento() {
    document.getElementById('eventoNombre').value = sessionStorage.getItem('nombre_evento');
    document.getElementById('eventoFecha').value = sessionStorage.getItem('fecha_evento');
    document.getElementById('eventoPrecio').value = sessionStorage.getItem('precio_evento');
}