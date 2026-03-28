//Carga del form al crear una promocion
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

            <div class="col-md-6 mb-3">
                <label class="form-label">Fecha inicio</label>
                <input type="date" id="fecha_inicio" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Fecha fin</label>
                <input type="date" id="fecha_fin" class="form-control">
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

//Función para crear una promocion
function crearPromocion () {
    const titulo = document.getElementById('titulo');
    const fecha_inicio = document.getElementById('fecha_inicio');
    const fecha_fin = document.getElementById('fecha_fin');
    
    if (!titulo.value.trim() || !fecha_inicio.value || !fecha_fin.value) {
        alert('Completa los campos obligatorios');
        return;
    }
    
    const imagen = document.getElementById('imagen').files[0];
    
    if (!imagen) {
        alert('Selecciona una imagen');
        return;
    }

    const formData = new FormData();
    
    formData.append('titulo', titulo.value.trim());
    formData.append('descripcion', document.getElementById('descripcion').value.trim());
    formData.append('fecha_inicio', fecha_inicio.value);
    formData.append('fecha_fin', fecha_fin.value);
    formData.append('imagen', imagen);

    fetch(BASE_URL + 'admin?action=guardarPromocion', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(r => {
        if (r.status === 'ok') location.reload();
        else alert("Error al guardar.");
    })
    .catch(() => alert("Error en la petición."));
}

//Carga del form al actualizar promocion
document.addEventListener('click', async e => {
    const btn = e.target.closest('.btn-update');

    if (!btn || btn.dataset.controller !== 'Promocion') return;

    const id = btn.dataset.id;

    const res = await fetch(BASE_URL + 'admin?action=obtenerPromocion', {
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

            <div class="col-md-6 mb-3">
                <label class="form-label">Fecha inicio</label>
                <input type="date" id="fecha_inicio" class="form-control" value="${pr.fecha_inicio}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Fecha fin</label>
                <input type="date" id="fecha_fin" class="form-control" value="${pr.fecha_fin}">
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

//Función para actualizar una promocion
function actualizarPromocion () {
    const body = document.getElementById('modal-body');
    
    const data = new FormData();

    data.append('id', body.querySelector('#id_promocion').value);
    data.append('titulo', body.querySelector('#titulo').value.trim());
    data.append('descripcion', body.querySelector('#descripcion').value.trim());
    data.append('fecha_inicio', body.querySelector('#fecha_inicio').value);
    data.append('fecha_fin', body.querySelector('#fecha_fin').value);

    const imagen = body.querySelector('#imagen').files[0];

    if (imagen) {
        data.append('imagen', imagen);
    }

    fetch(BASE_URL + 'admin?action=actualizarPromocion', {
        method: 'POST',
        body: data
    })
    .then(r => r.json())
    .then(r => {
        if (r.status === 'ok') location.reload();
        else alert("Error al actualizar.");
    })
    .catch(() => alert("Error en la petición."));
}

//Carga del modal borrar promocion
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

//Función para eliminar una promocion
function eliminarPromocion(btn) {
    const data = new FormData();

    data.append('id', btn.dataset.id);

    fetch(BASE_URL + 'admin?action=eliminarPromocion', {
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
    .catch(() => alert("Error en la petición."));
}
