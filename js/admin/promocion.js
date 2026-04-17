document.getElementById('btn-create-promocion')?.addEventListener('click', () => {
    abrirModal({
        titulo: 'Nueva Promoción',
        textoBoton: 'Crear',
        claseBoton: 'btn-success',
        contenido: `
        <div class="row">
            <div class="mb-3 col-12">
                <label class="form-label">Título <span class="text-danger">*</span></label>
                <input type="text" id="titulo" class="form-control mb-1">
                <span id="errorTituloPromocion" class="text-danger"></span>
            </div>

            <div class="mb-3 col-12">
                <label class="form-label">Descripción <span class="text-danger">*</span></label>
                <textarea id="descripcion" class="form-control mb-1" rows="3"></textarea>
                <span id="errorDescripcionPromocion" class="text-danger"></span>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Fecha inicio <span class="text-danger">*</span></label>
                <input type="date" id="fecha_inicio" class="form-control mb-1">
                <span id="errorFechaInicioPromocion" class="text-danger"></span>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Fecha fin <span class="text-danger">*</span></label>
                <input type="date" id="fecha_fin" class="form-control mb-1">
                <span id="errorFechaFinPromocion" class="text-danger"></span>
            </div>

            <div class="mb-3 col-12">
                <label class="form-label">Imagen de la promoción <span class="text-danger">*</span></label>
                <input type="file" id="imagen" class="form-control mb-1" accept="image/png, image/jpeg, image/jpg">
                <span class="text-muted">Solo se permiten archivos JPG, JPEG y PNG.</span>
                <br>
                <span id="errorImagenPromocion" class="text-danger"></span>
            </div>
        </div>
        `,
        onSubmit: crearPromocion
    });

    setTimeout(configurarFechasPromocion, 100);
});

function crearPromocion () {
    const titulo = document.getElementById('titulo').value.trim();
    const descripcion = document.getElementById('descripcion').value.trim();
    const fecha_inicio = document.getElementById('fecha_inicio').value;
    const fecha_fin = document.getElementById('fecha_fin').value;

    const errorTitulo = document.getElementById('errorTituloPromocion');
    const errorDescripcion = document.getElementById('errorDescripcionPromocion');
    const errorFechaInicio = document.getElementById('errorFechaInicioPromocion');
    const errorFechaFin = document.getElementById('errorFechaFinPromocion');
    const errorImagen = document.getElementById('errorImagenPromocion');

    errorTitulo.textContent = '';
    errorDescripcion.textContent = '';
    errorFechaInicio.textContent = '';
    errorFechaFin.textContent = '';
    errorImagen.textContent = '';

    let error = false;

    if (!titulo) {
        errorTitulo.textContent = 'El titulo es obligatorio.';
        error = true;
    }

    if (!descripcion) {
        errorDescripcion.textContent = 'La descripción es obligatoria.';
        error = true;
    }

    if (!fecha_inicio) {
        errorFechaInicio.textContent = 'La fecha de inicio es obligatoria.';
        error = true;
    }

    if (!fecha_fin) {
        errorFechaFin.textContent = 'La fecha de fin es obligatoria.';
        error = true;
    }

    if (fecha_inicio && fecha_fin && fecha_inicio > fecha_fin) {
        errorFechaFin.textContent = 'La fecha de fin debe ser posterior a la fecha de inicio.';
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
    
    formData.append('titulo', titulo);
    formData.append('descripcion', descripcion);
    formData.append('fecha_inicio', fecha_inicio);
    formData.append('fecha_fin', fecha_fin);
    formData.append('imagen', imagen);

    fetch(BASE_URL + 'admin?action=guardarPromocion', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'ok') {
            cerrarModal();
            location.reload();
            mostrarToast('Promoción creada correctamente.', 'success');
        } else {
            mostrarToast(data.msg || "Error al guardar la promoción.", 'error');
        }
    })
    .catch(() => mostrarToast("Error en la petición.", 'error'));
}

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
        <div class="row">
        <input type="hidden" id="id_promocion" value="${pr.id_promocion}">
            <div class="mb-3 col-12">
                <label class="form-label">Título <span class="text-danger">*</span></label>
                <input type="text" id="titulo" class="form-control mb-1" value="${pr.titulo}">
                <span id="errorTituloPromocion" class="text-danger"></span>
            </div>

            <div class="mb-3 col-12">
                <label class="form-label">Descripción <span class="text-danger">*</span></label>
                <textarea id="descripcion" class="form-control mb-1" rows="3">${pr.descripcion}</textarea>
                <span id="errorDescripcionPromocion" class="text-danger"></span>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Fecha inicio <span class="text-danger">*</span></label>
                <input type="date" id="fecha_inicio" class="form-control mb-1" value="${pr.fecha_inicio}">
                <span id="errorFechaInicioPromocion" class="text-danger"></span>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Fecha fin <span class="text-danger">*</span></label>
                <input type="date" id="fecha_fin" class="form-control mb-1" value="${pr.fecha_fin}">
                <span id="errorFechaFinPromocion" class="text-danger"></span>
            </div>

            <div class="mb-3 col-12">
                <label class="form-label">Cambiar imagen <span class="text-muted">(opcional)</span></label>
                <input type="file" id="imagen" class="form-control" accept="image/png, image/jpeg, image/jpg">
                <span class="text-muted">Solo se permiten archivos JPG, JPEG y PNG.</span>
            </div>
        `,
        onSubmit: actualizarPromocion
    });

    setTimeout(configurarFechasPromocion, 100);
});

//Función para actualizar una promocion
function actualizarPromocion () {
    const body = document.getElementById('modalBody');

    const titulo = body.querySelector('#titulo').value.trim();
    const descripcion = body.querySelector('#descripcion').value.trim();
    const fecha_inicio = body.querySelector('#fecha_inicio').value;
    const fecha_fin = body.querySelector('#fecha_fin').value;
    
    const errorTitulo = body.querySelector('#errorTituloPromocion');
    const errorDescripcion = body.querySelector('#errorDescripcionPromocion');
    const errorFechaInicio = body.querySelector('#errorFechaInicioPromocion');
    const errorFechaFin = body.querySelector('#errorFechaFinPromocion');

    errorTitulo.textContent = '';
    errorDescripcion.textContent = '';
    errorFechaInicio.textContent = '';
    errorFechaFin.textContent = '';

    let error = false;

    if (!titulo) {
        errorTitulo.textContent = 'El titulo es obligatorio.';
        error = true;
    }

    if (!descripcion) {
        errorDescripcion.textContent = 'La descripción es obligatoria.';
        error = true;
    }

    if (!fecha_inicio) {
        errorFechaInicio.textContent = 'La fecha de inicio es obligatoria.';
        error = true;
    }

    if (!fecha_fin) {
        errorFechaFin.textContent = 'La fecha de fin es obligatoria.';
        error = true;
    }

    if (fecha_inicio && fecha_fin && fecha_inicio > fecha_fin) {
        errorFechaFin.textContent = 'La fecha de fin debe ser posterior a la fecha de inicio.';
        error = true;
    }

    if (error) {
        mostrarToast('Completa los campos correctamente.', 'error');
        return;
    }

    const data = new FormData();

    data.append('id', body.querySelector('#id_promocion').value);
    data.append('titulo', titulo);
    data.append('descripcion', descripcion);
    data.append('fecha_inicio', fecha_inicio);
    data.append('fecha_fin', fecha_fin);

    const imagen = body.querySelector('#imagen').files[0];

    if (imagen) {
        data.append('imagen', imagen);
    }

    fetch(BASE_URL + 'admin?action=actualizarPromocion', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'ok') {
            cerrarModal();
            location.reload();
            mostrarToast('Promoción actualizada correctamente.', 'success');
        } else {
            mostrarToast(data.msg || "Error al actualizar la promoción.", 'error');
        }
    })
    .catch(() => mostrarToast("Error en la petición.", 'error'));
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

    fetch(BASE_URL + 'admin?action=eliminarPromocion', {
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
