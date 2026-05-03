let totalActual = 0;
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-add-images');
    if(!btn) return;

    const id = btn.dataset.id;
    totalActual = parseInt(btn.dataset.total || 0);

    abrirModal({
        titulo: 'Agregar Imagenes',
        textoBoton: 'Guardar',
        claseBoton: 'btn-success',
        contenido: `
        <p class="text-muted">Puedes subir hasta 4 imágenes del evento finalizado.</p>
        <div class="row">
            <div class="mb-3 col-12">
                <label class="form-label">Imagenes</label>
                <input type="file" id="imagenes_evento" class="form-control mb-1" accept="image/*" multiple>
                <span id="errorImagenesEvento" class="text-danger"></span>
            </div>

            <div id="previewImagenes" class="d-flex flex-wrap gap-2"></div>
        </div>
        `,
        onSubmit: () => subirImagenesEvento(id)
    });

    setTimeout(() => activarPreviewImagenes(), 100);
});

function activarPreviewImagenes() {
    const input = document.getElementById('imagenes_evento');
    const preview = document.getElementById('previewImagenes');
    const error = document.getElementById('errorImagenesEvento');

    input.addEventListener('change', function() {
        preview.innerHTML = '';
        error.textContent = '';

        const files = Array.from(this.files);

        if ((files.length + totalActual) > 4) {
            error.textContent = `Solo puedes tener máximo 4 imágenes. Ya tienes ${totalActual}.`;
            input.value = '';
            return;
        }

        files.forEach(file => {
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '90px';
                img.style.height = '90px';
                img.style.objectFit = 'cover';
                img.classList.add('rounded', 'shadow-sm');

                preview.appendChild(img);
            };

            reader.readAsDataURL(file);
        });
    });
}

function subirImagenesEvento(id) {
    const input = document.getElementById('imagenes_evento');
    const error = document.getElementById('errorImagenesEvento');
    error.textContent = '';

    if (!input.files.length) {
        error.textContent = 'Selecciona al menos una imagen';
        return;
    }

    if ((input.files.length + totalActual) > 4) {
        error.textContent = `Solo puedes tener máximo 4 imágenes. Ya tienes ${totalActual}.`;
        return;
    }

    const formData = new FormData();
    formData.append('id', id);

    Array.from(input.files).forEach(file => {
        formData.append('imagenes[]', file);
    });

    fetch(BASE_URL + 'admin?action=subirImagenesEvento', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'ok') {
            cerrarModal();
            mostrarToast('Imágenes subidas correctamente.', 'success');
            location.reload();
        } else {
            mostrarToast(data.msg || 'Error al subir imágenes', 'error');
        }
    })
    .catch(() => mostrarToast('Error en la petición', 'error'));
}

document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-delete-img');
    if (!btn) return;

    const id = btn.dataset.id;
    const evento = btn.dataset.evento;

    if (!confirm('¿Eliminar esta imagen?')) return;

    const formData = new FormData();
    formData.append('id', id);
    formData.append('evento', evento);

    fetch(BASE_URL + 'admin?action=eliminarImagenesEvento', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'ok') {
            mostrarToast('Imagen eliminada', 'success');
            location.reload();
        } else {
            mostrarToast(data.msg || 'Error', 'error');
        }
    });
});