const EVENTO_URL = 'evento.php';

document.getElementById('btn-create-evento')?.addEventListener('click', () => {

    abrirModal({
        titulo: 'Nuevo Evento',
        textoBoton: 'Crear',
        claseBoton: 'btn-success',
        contenido: `
            <div class="col-12 mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" id="nombre" class="form-control">
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Descripción</label>
                <textarea id="descripcion" class="form-control" rows="3"></textarea>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Fecha</label>
                <input type="date" id="fecha" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Hora</label>
                <input type="time" id="hora" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Hora de terminación</label>
                <input type="time" id="hora_fin" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Mesas disponibles</label>
                <input type="number" id="mesas_disponibles" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Precio</label>
                <input type="number" step="0.01" id="precio_mesa" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select id="estado" class="form-select">
                    <option value="activo">Activo</option>
                    <option value="cancelado">Cancelado</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Imagen del evento</label>
                <input type="file" id="imagen" class="form-control" accept="image/png, image/jpeg">
            </div>
        `,
        onSubmit: crearEvento
    });

    setTimeout(configurarFechaEvento, 50);
});

function crearEvento () {

    const nombre = document.getElementById('nombre');
    const fecha = document.getElementById('fecha');
    const hora = document.getElementById('hora');

    if(!nombre.value.trim() || !fecha.value || !hora.value) {
        alert('Completa los campos obligatorios');
        return;
    }

    const formData = new FormData();
    
    formData.append('nombre', nombre.value.trim());
    formData.append('descripcion', document.getElementById('descripcion').value.trim());
    formData.append('fecha', fecha.value);
    formData.append('hora', hora.value);
    formData.append('hora_fin', document.getElementById('hora_fin').value);
    formData.append('mesas_disponibles', document.getElementById('mesas_disponibles').value);
    formData.append('precio_mesa', document.getElementById('precio_mesa').value);
    formData.append('estado', document.getElementById('estado').value);
    
    const imagen = document.getElementById('imagen').files[0];
    
    if (!imagen) {
        alert('Selecciona una imagen');
        return;
    }
    
    formData.append('imagen', imagen);

    fetch(`${EVENTO_URL}?action=guardar`, {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(r => {
        if (r.status === 'ok') location.reload();
        else alert('Error al guardar');
    })
    .catch(() => alert('Error en la petición'));
}

document.addEventListener('click', async e => {

    const btn = e.target.closest('.btn-update');

    if (!btn || btn.dataset.controller !== 'Evento') return;

    const id = btn.dataset.id;
    
    const res = await fetch(`${EVENTO_URL}?action=obtener`, {
        method: 'POST',
        body: new URLSearchParams({ id })
    });
    
    const ev = await res.json();
    
    abrirModal({
        titulo: 'Editar Evento',
        textoBoton: 'Actualizar',
        claseBoton: 'btn-success',
        contenido: `
            <input type="hidden" id="id_evento" value="${ev.id_evento}">
            <div class="col-12 mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" id="nombre" class="form-control" value="${ev.nombre}">
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Descripcion</label>
                <textarea id="descripcion" class="form-control" rows="3">${ev.descripcion}</textarea>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Fecha</label>
                <input type="date" id="fecha" class="form-control" value="${ev.fecha}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Hora</label>
                <input type="time" id="hora" class="form-control" value="${ev.hora}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Hora de terminación</label>
                <input type="time" id="hora_fin" class="form-control" value="${ev.hora_fin}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Mesas disponibles</label>
                <input type="number" id="mesas_disponibles" class="form-control" value="${ev.mesas_disponibles}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Precio</label>
                <input type="number" step="0.01" id="precio_mesa" class="form-control" value="${ev.precio_mesa}">
            </div>

            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select id="estado" class="form-select">
                    <option value="activo" ${ev.estado === 'activo' ? 'selected' : ''}>Activo</option>
                    <option value="cancelado" ${ev.estado === 'cancelado' ? 'selected' : ''}>Cancelado</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Cambiar imagen (opcional)</label>
                <input type="file" id="imagen" class="form-control" accept="image/png, image/jpeg">
            </div>
        `,
        onSubmit: actualizarEvento
    });

    setTimeout(configurarFechaEvento, 50);
});

function actualizarEvento() {
    
    const body = document.getElementById('modal-body');
    
    const data = new FormData();

    data.append('id', body.querySelector('#id_evento').value);
    data.append('nombre', body.querySelector('#nombre').value.trim());
    data.append('descripcion', body.querySelector('#descripcion').value.trim());
    data.append('fecha', body.querySelector('#fecha').value);
    data.append('hora', body.querySelector('#hora').value);
    data.append('hora_fin', body.querySelector('#hora_fin').value);
    data.append('mesas_disponibles', body.querySelector('#mesas_disponibles').value);
    data.append('precio_mesa', body.querySelector('#precio_mesa').value);
    data.append('estado', body.querySelector('#estado').value);

    const imagen = body.querySelector('#imagen').files[0];

    if (imagen) {
        data.append('imagen', imagen);
    }

    fetch(`${EVENTO_URL}?action=actualizar`, {
        method: 'POST',
        body: data
    })
    .then(r => r.json())
    .then(r => {
        if (r.status === 'ok') location.reload();
        else alert('Error al actualizar');
    })
    .catch(() => alert('Error en la petición'));
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

    fetch(`${EVENTO_URL}?action=eliminar`, {
        method: 'POST',
        body: data
    })
    .then(r => r.json())
    .then(r => {
        if (r.status === 'ok') {
            btn.closest('tr').remove();
        }

        document.getElementById('modal-global').classList.add('d-none');
    })
    .catch(() => alert('Error en la petición'));
}
