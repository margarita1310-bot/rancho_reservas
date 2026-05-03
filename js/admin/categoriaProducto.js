document.getElementById('btn-create-categoriaProducto')?.addEventListener('click', () => {
    abrirModal({
        titulo: 'Nueva categoría',
        textoBoton: 'Crear',
        claseBoton: 'btn-success',
        contenido: `
        <div class="row">
            <div class="mb-3 col-12">
                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" id="nombre" class="form-control mb-1">
                <span id="errorNombreCategoriaProducto" class="text-danger"></span>
            </div>
        </div>
        `,
        onSubmit: crearCategoriaProducto
    });
});

function crearCategoriaProducto () {
    const nombre = document.getElementById('nombre').value.trim();
    const errorNombreCategoriaProducto = document.getElementById('errorNombreCategoriaProducto');

    errorNombreCategoriaProducto.textContent = '';

    let error = false;

    if (!nombre) {
        errorNombreCategoriaProducto.textContent = 'El nombre es obligatorio.';
        error = true;
    }

    if (error) {
        mostrarToast('Completa el campo correctamente.', 'error');
        return;
    }

    const formData = new FormData();
    
    formData.append('nombre', nombre);

    fetch(BASE_URL + 'admin?action=guardarCategoriaProducto', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'ok') {
            cerrarModal();  
            location.reload();
            mostrarToast('Categoría creada correctamente.', 'success');
        } else {
            mostrarToast(data.msg || "Error al guardar la categoría.", 'error');
        } 
    })
    .catch(() => mostrarToast("Error en la petición.", 'error'));
}

document.addEventListener('click', e => {
    const btn = e.target.closest('.btn-delete');

    if (!btn || btn.dataset.controller !== 'CategoriaProducto') return;

    abrirModal({
        titulo: 'Eliminar Categoría',
        textoBoton: 'Eliminar',
        claseBoton: 'btn-danger',
        contenido: `<p>¿Estás seguro de eliminar esta categoría?</p>`,
        onSubmit: () => eliminarCategoriaProducto(btn)
    });
});

function eliminarCategoriaProducto(btn) {
    const data = new FormData();
    
    data.append('id', btn.dataset.id);

    fetch(BASE_URL + 'admin?action=eliminarCategoriaProducto', {
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
