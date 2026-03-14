const PROMOCION_URL = 'promocion.php';

document.getElementById('btn-create-promocion')?.addEventListener('click', () => {

    abrirModal({
        titulo: 'Nueva Promoción',
        textoBoton: 'Crear',
        claseBoton: 'btn-success',
        contenido: `
            <div class="mb-3">
                <label class="form-label">Titulo</label>
                <input type="text" id="titulo" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea id="descripcion" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha inicio</label>
                <input type="date" id="fecha_inicio" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha fin</label>
                <input type="date" id="fecha_fin" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select id="estado" class="form-select">
                    <option value="activa">Activa</option>
                    <option value="inactiva">Inactiva</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Imagen de la promoción</label>
                <input type="file" id="imagen" class="form-control" accept="image/png, image/jpeg">
            </div>
        `,
        onSubmit: crearPromocion
    });

    setTimeout(configurarFechasPromocion, 50);
});

function crearPromocion () {

    const titulo = document.getElementById('titulo');
    const fecha_inicio = document.getElementById('fecha_inicio');
    const fecha_fin = document.getElementById('fecha_fin');
    
    if (!titulo.value.trim() || !fecha_inicio.value || !fecha_fin.value) {
        alert('Completa los campos obligatorios');
        return;
    }
    
    const formData = new FormData();
    
    formData.append('titulo', titulo.value.trim());
    formData.append('descripcion', document.getElementById('descripcion').value.trim());
    formData.append('fecha_inicio', fecha_inicio.value);
    formData.append('fecha_fin', fecha_fin.value);
    formData.append('estado', document.getElementById('estado').value);
    formData.append('imagen', imagen);
    
    const imagen = document.getElementById('imagen').files[0];
    
    if (!imagen) {
        alert('Selecciona una imagen');
        return;
    }
    
    fetch(`${PROMOCION_URL}?action=guardar`, {
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

    if (!btn || btn.dataset.controller !== 'Promocion') return;

    const id = btn.dataset.id;

    const res = await fetch(`${PROMOCION_URL}?action=obtener`, {
        method: 'POST',
        body: new URLSearchParams({ id })
    });

    const pr = await res.json();

    abrirModal({
        titulo: 'Editar Promoción',
        textoBoton: 'Actualizar',
        claseBoton: 'btn-success',
        contenido: `
        <input type="hidden" id="id_promocion" value="${pr.id_promocion}">
            <div class="mb-3">
                <label class="form-label">Titulo</label>
                <input type="text" id="titulo" class="form-control" value="${pr.titulo}">
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea id="descripcion" class="form-control" rows="3">${pr.descripcion}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha inicio</label>
                <input type="date" id="fecha_inicio" class="form-control" value="${pr.fecha_inicio}">
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha fin</label>
                <input type="date" id="fecha_fin" class="form-control" value="${pr.fecha_fin}">
            </div>

            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select id="estado" class="form-select">
                    <option value="activa" ${pr.estado === 'activa' ? 'selected' : ''}>Activa</option>
                    <option value="inactiva" ${pr.estado === 'inactiva' ? 'selected' : ''}>Inactiva</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Cambiar imagen (opcional)</label>
                <input type="file" id="imagen" class="form-control" accept="image/png, image/jpeg">
            </div>
        `,
        onSubmit: actualizarPromocion
    });

    setTimeout(configurarFechasPromocion, 50);
});

function actualizarPromocion () {

    const body = document.getElementById('modal-body');
    
    const data = new FormData();

    data.append('id', body.querySelector('#id_promocion').value);
    data.append('titulo', body.querySelector('#titulo').value.trim());
    data.append('descripcion', body.querySelector('#descripcion').value.trim());
    data.append('fecha_inicio', body.querySelector('#fecha_inicio').value);
    data.append('fecha_fin', body.querySelector('#fecha_fin').value);
    data.append('estado', body.querySelector('#estado').value);

    const imagen = body.querySelector('#imagen').files[0];

    if (imagen) {
        data.append('imagen', imagen);
    }

    fetch(`${PROMOCION_URL}?action=actualizar`, {
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

    if (!btn || btn.dataset.controller !== 'Promocion') return;

    abrirModal({
        titulo: 'Eliminar Promoción',
        textoBoton: 'Eliminar',
        claseBoton: 'btn-danger',
        contenido: `<p>¿Estás seguro de eliminar esta promoción?</p>`,
        onSubmit: () => eliminarPromocion(btn)
    });
});

function eliminarPromocion(btn) {

    const data = new FormData();

    data.append('id', btn.dataset.id);

    fetch(`${PROMOCION_URL}?action=eliminar`, {
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
