document.getElementById('btn-create-evento')?.addEventListener('click', () => {
    abrirModal({
        titulo: 'Nuevo Evento',
        textoBoton: 'Crear',
        claseBoton: 'btn-success',
        contenido: `
        <p class="text-muted">Una vez reservado el evento, no podrá ser modificado. Verifique la información antes de crear el evento.</p>
        <div class="row">
            <div class="mb-3 col-12">
                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" id="nombre" class="form-control mb-1">
                <span id="errorNombreEvento" class="text-danger"></span>
            </div>

            <div class="mb-3 col-12">
                <label class="form-label">Descripción <span class="text-danger">*</span></label>
                <textarea id="descripcion" class="form-control mb-1" rows="3"></textarea>
                <span id="errorDescripcionEvento" class="text-danger"></span>
            </div>

            <div class="mb-3 col-12">
                <label class="form-label">Fecha <span class="text-danger">*</span></label>
                <input type="date" id="fecha" class="form-control mb-1">
                <span id="errorFechaEvento" class="text-danger"></span>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Hora <span class="text-danger">*</span></label>
                <input type="time" id="hora" class="form-control mb-1">
                <span id="errorHoraEvento" class="text-danger"></span>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Duración <span class="text-muted">(en horas)</span> <span class="text-danger">*</span></label>
                <input type="number" id="duracion" class="form-control mb-1"  min="1" max="10">
                <small class="text-muted">La duración debe ser de 1 a 10 horas.</small>
                <br>
                <span id="errorDuracionEvento" class="text-danger"></span>
            </div>

            <div class="mb-3 col-12">
                <label class="form-label">Hora de terminación</label>
                <input type="time" id="hora_fin" class="form-control" readonly>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Mesas disponibles <span class="text-danger">*</span></label>
                <input type="number" id="mesas_disponibles" class="form-control mb-1">
                <span id="errorMesasDisponiblesEvento" class="text-danger"></span>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Precio <span class="text-danger">*</span></label>
                <input type="number" step="0.01" id="precio_mesa" class="form-control mb-1">
                <span id="errorPrecioMesaEvento" class="text-danger"></span>
            </div>

            <div class="mb-3 col-12">
                <label class="form-label">Imagen del evento <span class="text-danger">*</span></label>
                <input type="file" id="imagen" class="form-control mb-1" accept="image/png, image/jpeg, image/jpg">
                <span class="text-muted">Solo se permiten archivos JPG, JPEG y PNG.</span>
                <br>
                <span id="errorImagenEvento" class="text-danger"></span>
            </div>
        </div>
        `,
        onSubmit: crearEvento
    });

    setTimeout(configurarFechaEvento, 100);
});

function crearEvento () {
    const nombre = document.getElementById('nombre').value.trim();
    const descripcion = document.getElementById('descripcion').value.trim();
    const fecha = document.getElementById('fecha').value;
    const hora = document.getElementById('hora').value;
    const duracion = document.getElementById('duracion').value;
    const horaFin = document.getElementById('hora_fin').value;
    const mesasDisponibles = document.getElementById('mesas_disponibles').value;
    const precioMesa = document.getElementById('precio_mesa').value;

    const errorNombre = document.getElementById('errorNombreEvento');
    const errorDescripcion = document.getElementById('errorDescripcionEvento');
    const errorFecha = document.getElementById('errorFechaEvento');
    const errorHora = document.getElementById('errorHoraEvento');
    const errorDuracion = document.getElementById('errorDuracionEvento');
    const errorMesasDisponibles = document.getElementById('errorMesasDisponiblesEvento');
    const errorPrecioMesa = document.getElementById('errorPrecioMesaEvento');
    const errorImagen = document.getElementById('errorImagenEvento');

    errorNombre.textContent = '';
    errorDescripcion.textContent = '';
    errorFecha.textContent = '';
    errorHora.textContent = '';
    errorDuracion.textContent = '';
    errorMesasDisponibles.textContent = '';
    errorPrecioMesa.textContent = '';
    errorImagen.textContent = '';

    let error = false;

    if (!nombre) {
        errorNombre.textContent = 'El nombre es obligatorio.';
        error = true;
    }

    if (!descripcion) {
        errorDescripcion.textContent = 'La descripción es obligatoria.';
        error = true;
    }

    if (!fecha) {
        errorFecha.textContent = 'La fecha es obligatoria.';
        error = true;
    }

    if (!hora) {
        errorHora.textContent = 'La hora es obligatoria.';
        error = true;
    }

    if (!duracion) {
        errorDuracion.textContent = 'La duración es obligatoria.';
        error = true;
    }

    if (duracion <= 0) {
        errorDuracion.textContent = 'La duración debe ser mayor a 0.';
        error = true;
    }

    if (duracion > 10) {
        errorDuracion.textContent = 'La duración no puede ser mayor a 10 horas.';
        error = true;
    }

    if (!/^[0-9]+$/.test(mesasDisponibles) || mesasDisponibles < 1) {
        errorMesasDisponibles.textContent = 'El número de mesas disponibles es incorrecto.';
        error = true;
    }

    if (!/^[0-9]+\.?[0-9]*$/.test(precioMesa) || precioMesa <= 0) {
        errorPrecioMesa.textContent = 'El precio de la mesa es incorrecto.';
        error = true;
    }
    
    const imagen = document.getElementById('imagen').files[0];
    
    if (!imagen) {
        errorImagen.textContent = 'La imagen es obligatoria.';
        error = true;
    }
    
    if (error) {
        mostrarToast('Completa los campos correctamente.', 'error');
        return;
    }

    const formData = new FormData();
    
    formData.append('nombre', nombre);
    formData.append('descripcion', descripcion);
    formData.append('fecha', fecha);
    formData.append('hora', hora);
    formData.append('hora_fin', horaFin);
    formData.append('mesas_disponibles', mesasDisponibles);
    formData.append('precio_mesa', precioMesa);
    formData.append('imagen', imagen);

    fetch(BASE_URL + 'admin?action=guardarEvento', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'ok') {
            cerrarModal();  
            location.reload();
            mostrarToast('Evento creado correctamente.', 'success');
        } else {
            mostrarToast(data.msg || "Error al guardar el evento.", 'error');
        } 
    })
    .catch(() => mostrarToast("Error en la petición.", 'error'));
}

document.addEventListener('click', async e => {
    const btn = e.target.closest('.btn-update');

    if (!btn || btn.dataset.controller !== 'Evento') return;

    const id = btn.dataset.id;
    
    const res = await fetch(BASE_URL + 'admin?action=obtenerEvento', {
        method: 'POST',
        body: new URLSearchParams({ id })
    });
    
    const ev = await res.json();
    
    abrirModal({
        titulo: 'Editar Evento',
        textoBoton: 'Actualizar',
        claseBoton: 'btn-success',
        contenido: `
        <p class="text-muted">Una vez reservado el evento, no podrá ser modificado. Verifique la información antes de actualizar el evento.</p>
        <div class="row">
            <input type="hidden" id="id_evento" value="${ev.id_evento}">
            <div class="mb-3 col-12">
                <label class="form-label">Nombre <span class="text-danger">*</span> </label>
                <input type="text" id="nombre" class="form-control mb-1" value="${ev.nombre}">
                <span id="errorNombreEvento" class="text-danger"></span>
            </div>

            <div class="mb-3 col-12">
                <label class="form-label">Descripcion <span class="text-danger">*</span> </label>
                <textarea id="descripcion" class="form-control mb-1" rows="3">${ev.descripcion}</textarea>
                <span id="errorDescripcionEvento" class="text-danger"></span>
            </div>

            <div class="mb-3 col-12">
                <label class="form-label">Fecha <span class="text-danger">*</span> </label>
                <input type="date" id="fecha" class="form-control mb-1" value="${ev.fecha}">
                <span id="errorFechaEvento" class="text-danger"></span>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Hora <span class="text-danger">*</span> </label>
                <input type="time" id="hora" class="form-control mb-1" value="${ev.hora}">
                <span id="errorHoraEvento" class="text-danger"></span>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Duración <span class="text-muted">(en horas)</span> <span class="text-danger">*</span></label>
                <input type="number" id="duracion" class="form-control mb-1"  min="1" max="10">
                <span id="errorDuracionEvento" class="text-danger"></span>
            </div>

            <div class="mb-3 col-12">
                <label class="form-label">Hora de terminación</label>
                <input type="time" id="hora_fin" class="form-control" value="${ev.hora_fin}" readonly>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Mesas disponibles <span class="text-danger">*</span> </label>
                <input type="number" id="mesas_disponibles" class="form-control mb-1" value="${ev.mesas_disponibles}">
                <span id="errorMesasDisponiblesEvento" class="text-danger"></span>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Precio <span class="text-danger">*</span> </label>
                <input type="number" step="0.01" id="precio_mesa" class="form-control mb-1" value="${ev.precio_mesa}">
                <span id="errorPrecioMesaEvento" class="text-danger"></span>
            </div>

            <div class="mb-3 col-12">
                <label class="form-label">Cambiar imagen <span class="text-muted">(opcional)</span></label>
                <input type="file" id="imagen" class="form-control" accept="image/png, image/jpeg, image/jpg">
                <span class="text-muted">Solo se permiten archivos JPG, JPEG y PNG.</span>
            </div>
        </div>
        `,
        onSubmit: actualizarEvento
    });

    setTimeout(configurarFechaEvento, 100);
});

function actualizarEvento() {
    const body = document.getElementById('modalBody');

    const nombre = body.querySelector('#nombre').value.trim();
    const descripcion = body.querySelector('#descripcion').value.trim();
    const fecha = body.querySelector('#fecha').value;
    const hora = body.querySelector('#hora').value;
    const duracion = body.querySelector('#duracion').value;
    const hora_fin = body.querySelector('#hora_fin').value;
    const mesasDisponibles = body.querySelector('#mesas_disponibles').value;
    const precioMesa = body.querySelector('#precio_mesa').value;

    const errorNombre = body.querySelector('#errorNombreEvento');
    const errorDescripcion = body.querySelector('#errorDescripcionEvento');
    const errorFecha = body.querySelector('#errorFechaEvento');
    const errorHora = body.querySelector('#errorHoraEvento');
    const errorDuracion = body.querySelector('#errorDuracionEvento');
    const errorMesasDisponibles = body.querySelector('#errorMesasDisponiblesEvento');
    const errorPrecioMesa = body.querySelector('#errorPrecioMesaEvento');

    errorNombre.textContent = '';
    errorDescripcion.textContent = '';
    errorFecha.textContent = '';
    errorHora.textContent = '';
    errorDuracion.textContent = '';
    errorMesasDisponibles.textContent = '';
    errorPrecioMesa.textContent = '';

    let error = false;

    if (!nombre) {
        errorNombre.textContent = 'El nombre es obligatorio.';
        error = true;
    }

    if (!descripcion) {
        errorDescripcion.textContent = 'La descripción es obligatoria.';
        error = true;
    }

    if (!fecha) {
        errorFecha.textContent = 'La fecha es obligatoria.';
        error = true;
    }

    if (!hora) {
        errorHora.textContent = 'La hora es obligatoria.';
        error = true;
    }

    if (!duracion) {
        errorDuracion.textContent = 'La duración es obligatoria.';
        error = true;
    }

    if (duracion <= 0) {
        errorDuracion.textContent = 'La duración debe ser mayor a 0.';
        error = true;
    }

    if (duracion > 10) {
        errorDuracion.textContent = 'La duración no puede ser mayor a 10 horas.';
        error = true;
    }

    if (!/^[0-9]+$/.test(mesasDisponibles) || mesasDisponibles < 1) {
        errorMesasDisponibles.textContent = 'El número de mesas disponibles es incorrecto.';
        error = true;
    }

    if (!/^[0-9]+\.?[0-9]*$/.test(precioMesa) || precioMesa <= 0) {
        errorPrecioMesa.textContent = 'El precio de la mesa es incorrecto.';
        error = true;
    }

    if (error) {
        mostrarToast('Completa los campos correctamente.', 'error');
        return;
    }
    
    const data = new FormData();

    data.append('id', body.querySelector('#id_evento').value);
    data.append('nombre', nombre);
    data.append('descripcion', descripcion);
    data.append('fecha', fecha);
    data.append('hora', hora);
    data.append('hora_fin', hora_fin);
    data.append('mesas_disponibles', mesasDisponibles);
    data.append('precio_mesa', precioMesa);

    const imagen = body.querySelector('#imagen').files[0];

    if (imagen) {
        data.append('imagen', imagen);
    }

    fetch(BASE_URL + 'admin?action=actualizarEvento', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'ok') {
            cerrarModal();
            location.reload();
            mostrarToast('Evento actualizado correctamente.', 'success');
        } else {
            mostrarToast(data.msg || "Error al actualizar el evento.", 'error');
        }
    })
    .catch(() => mostrarToast("Error en la petición.", 'error'));
}

document.addEventListener('click', e => {
    const btn = e.target.closest('.btn-delete');

    if (!btn || btn.dataset.controller !== 'Evento') return;

    abrirModal({
        titulo: 'Eliminar Evento',
        textoBoton: 'Eliminar',
        claseBoton: 'btn-danger',
        contenido: `<p>¿Estás seguro de eliminar este evento?</p>`,
        onSubmit: () => eliminarEvento(btn)
    });
});

function eliminarEvento(btn) {
    const data = new FormData();
    
    data.append('id', btn.dataset.id);

    fetch(BASE_URL + 'admin?action=eliminarEvento', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'ok') {
            btn.closest('tr').remove();
        }
        cerrarModal();
    })
    .catch(() => mostrarToast("Error en la petición.", 'error'));
}
