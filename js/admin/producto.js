document.getElementById('btn-create-producto')?.addEventListener('click', () => {
    let opcionesCategorias = categorias.map(c => `
        <option value="${c.id_categoria}">
            ${c.nombre}
        </option>
    `).join('');

    abrirModal({
        titulo: 'Nuevo Producto',
        textoBoton: 'Crear',
        claseBoton: 'btn-success',
        contenido: `
        <div class="row">
            <div class="mb-3 col-12">
                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" id="nombre" class="form-control mb-1">
                <span id="errorNombreProducto" class="text-danger"></span>
            </div>

            <div class="mb-3 col-12">
                <label class="form-label">Descripción <span class="text-danger">*</span></label>
                <textarea id="descripcion" class="form-control mb-1" rows="3"></textarea>
                <span id="errorDescripcionProducto" class="text-danger"></span>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Precio <span class="text-danger">*</span></label>
                <input type="number" id="precio" class="form-control mb-1">
                <span id="errorPrecioProducto" class="text-danger"></span>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Categoría <span class="text-danger">*</span></label>
                <select id="id_categoria" class="form-select mb-1">
                    <option value="">Seleccionar categoría</option>
                    ${opcionesCategorias}
                </select>
                <span id="errorCategoriaProducto" class="text-danger"></span>
            </div>
        </div>
        `,
        onSubmit: crearProducto
    });
});

function crearProducto () {
    const nombre = document.getElementById('nombre').value.trim();
    const descripcion = document.getElementById('descripcion').value.trim();
    const precio = document.getElementById('precio').value;
    const id = document.getElementById('id_categoria').value;

    const errorNombre = document.getElementById('errorNombreProducto');
    const errorDescripcion = document.getElementById('errorDescripcionProducto');
    const errorPrecio = document.getElementById('errorPrecioProducto');
    const errorCategoria = document.getElementById('errorCategoriaProducto');
    
    errorNombre.textContent = '';
    errorDescripcion.textContent = '';
    errorPrecio.textContent = '';
    errorCategoria.textContent = '';

    let error = false;

    if (!nombre) {
        errorNombre.textContent = 'El nombre es obligatorio.';
        error = true;
    }

    if (!descripcion) {
        errorDescripcion.textContent = 'La descripción es obligatoria.';
        error = true;
    }

    if (!precio) {
        errorPrecio.textContent = 'El precio es obligatorio.';
        error = true;
    }

    if (!/^[0-9]+\.?[0-9]*$/.test(precio) || precio <= 0) {
        errorPrecio.textContent = 'El precio es incorrecto.';
        error = true;
    }

    if (!id) {
        errorCategoria.textContent = 'Selecciona una categoría.';
        error = true;
    }

    if (error) {
        mostrarToast('Completa los campos correctamente.', 'error');
        return;
    }

    const formData = new FormData();
    
    formData.append('nombre', nombre);
    formData.append('descripcion', descripcion);
    formData.append('precio', precio);
    formData.append('id_categoria', id);

    fetch(BASE_URL + 'admin?action=guardarProducto', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'ok') {
            cerrarModal();
            location.reload();
            mostrarToast('Producto creado correctamente.', 'success');
        } else {
            mostrarToast(data.msg || "Error al guardar el producto.", 'error');
        }
    })
    .catch(() => mostrarToast("Error en la petición.", 'error'));
}

document.addEventListener('click', async e => {
    const btn = e.target.closest('.btn-update');

    if (!btn || btn.dataset.controller !== 'Producto') return;

    const id = btn.dataset.id;

    const res = await fetch(BASE_URL + 'admin?action=obtenerProducto', {
        method: 'POST',
        body: new URLSearchParams({ id })
    });

    const p = await res.json();

    let opcionesCategorias = categorias.map(c => `
        <option value="${c.id_categoria}" 
            ${c.id_categoria == p.id_categoria ? 'selected' : ''}>
            ${c.nombre}
        </option>
    `).join('');

    abrirModal({
        titulo: 'Editar Producto',
        textoBoton: 'Actualizar',
        claseBoton: 'btn-success',
        contenido: `
        <div class="row">
        <input type="hidden" id="id_producto" value="${p.id_producto}">
            <div class="mb-3 col-12">
                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" id="nombre" class="form-control mb-1" value="${p.nombre}">
                <span id="errorNombreProducto" class="text-danger"></span>
            </div>

            <div class="mb-3 col-12">
                <label class="form-label">Descripción <span class="text-danger">*</span></label>
                <textarea id="descripcion" class="form-control mb-1" rows="3">${p.descripcion}</textarea>
                <span id="errorDescripcionProducto" class="text-danger"></span>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Precio <span class="text-danger">*</span></label>
                <input type="number" id="precio" class="form-control mb-1" value="${p.precio}">
                <span id="errorPrecioProducto" class="text-danger"></span>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">Categoría <span class="text-danger">*</span></label>
                <select id="id_categoria" class="form-select mb-1">
                    ${opcionesCategorias}
                </select>
                <span id="errorCategoriaProducto" class="text-danger"></span>
            </div>
        </div>
        `,
        onSubmit: actualizarProducto
    });
});

function actualizarProducto () {
    const body = document.getElementById('modalBody');

    const nombre = body.querySelector('#nombre').value.trim();
    const descripcion = body.querySelector('#descripcion').value.trim();
    const precio = body.querySelector('#precio').value;
    const id = body.querySelector('#id_categoria').value;
    
    const errorNombre = body.querySelector('#errorNombreProducto');
    const errorDescripcion = body.querySelector('#errorDescripcionProducto');
    const errorPrecio = body.querySelector('#errorPrecioProducto');
    const errorCategoria = body.querySelector('#errorCategoriaProducto');


    errorNombre.textContent = '';
    errorDescripcion.textContent = '';
    errorPrecio.textContent = '';
    errorCategoria.textContent = '';

    let error = false;

    if (!nombre) {
        errorNombre.textContent = 'El nombre es obligatorio.';
        error = true;
    }

    if (!descripcion) {
        errorDescripcion.textContent = 'La descripción es obligatoria.';
        error = true;
    }

    if (!precio) {
        errorPrecio.textContent = 'El precio es obligatorio.';
        error = true;
    }

    if (!/^[0-9]+\.?[0-9]*$/.test(precio) || precio <= 0) {
        errorPrecio.textContent = 'El precio es incorrecto.';
        error = true;
    }

    if (!id) {
        errorCategoria.textContent = 'Selecciona una categoría.';
        error = true;
    }

    if (error) {
        mostrarToast('Completa los campos correctamente.', 'error');
        return;
    }

    const data = new FormData();

    data.append('id', body.querySelector('#id_producto').value);
    data.append('nombre', nombre);
    data.append('descripcion', descripcion);
    data.append('precio', precio);
    data.append('id_categoria', id);

    fetch(BASE_URL + 'admin?action=actualizarProducto', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'ok') {
            cerrarModal();
            location.reload();
            mostrarToast('Producto actualizado correctamente.', 'success');
        } else {
            mostrarToast(data.msg || "Error al actualizar el producto.", 'error');
        }
    })
    .catch(() => mostrarToast("Error en la petición.", 'error'));
}

document.addEventListener('click', e => {
    const btn = e.target.closest('.btn-delete');

    if (!btn || btn.dataset.controller !== 'Producto') return;

    abrirModal({
        titulo: 'Eliminar Producto',
        textoBoton: 'Eliminar',
        claseBoton: 'btn-danger',
        contenido: `<p>¿Estás seguro de eliminar este producto?</p>`,
        onSubmit: () => eliminarProducto(btn)
    });
});

function eliminarProducto(btn) {
    const data = new FormData();

    data.append('id', btn.dataset.id);

    fetch(BASE_URL + 'admin?action=eliminarProducto', {
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
