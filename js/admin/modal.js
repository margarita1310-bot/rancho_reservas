document.addEventListener('DOMContentLoaded', () => {
    const modalGlobal = document.getElementById('modalGlobal');

    if (modalGlobal) {
        modalGlobal.addEventListener('shown.bs.modal', () => {
            configurarFechaEvento();
            configurarFechasPromocion();
        });
    }

    const modalPerfil = document.getElementById('modalPerfil');

    if (modalPerfil) {
        modalPerfil.addEventListener('show.bs.modal', () => {
            cargarPerfil();
        });

        modalPerfil.addEventListener('hidden.bs.modal', function () {
            limpiarModalPerfil();
        });
    }
});

function abrirModal ({
    titulo,
    contenido,
    textoBoton = "Guardar",
    claseBoton = "btn-primary",
    onSubmit })
    {
        const modalGlobal = document.getElementById('modalGlobal');
        const modal = bootstrap.Modal.getInstance(modalGlobal) || new bootstrap.Modal(modalGlobal);

        const modalTitulo = document.getElementById('modalTitle');
        const modalBody = document.getElementById('modalBody');
        const btnSave = document.getElementById('modalBtnSave');
            
        modalTitulo.textContent = titulo;
        modalBody.innerHTML = contenido;

        btnSave.textContent = textoBoton;
        btnSave.className = `btn ${claseBoton}`;
        
        btnSave.onclick = () => {
            if (onSubmit) {
                onSubmit();
            }
        };

        modal.show();
    }

function cerrarModal() {
    const modalGlobal = document.getElementById('modalGlobal');
    const modal = bootstrap.Modal.getInstance(modalGlobal) || new bootstrap.Modal(modalGlobal);
    modal.hide();
}

function cargarPerfil() {
    fetch('admin?action=perfil')
    .then(res => res.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
            return;
        }
        document.getElementById('emailPerfil').value = data.email;
        document.getElementById('passwordPerfil').value = data.password;
    })
    .catch(error => {
        console.error('Error al cargar el perfil:', error);
        alert('Error al cargar el perfil');
    });
}

function habilitarDatos() {
    document.getElementById('emailPerfil').disabled = false;
    document.getElementById('passwordPerfil').disabled = false;
    document.getElementById('btn-habilitar').classList.add('d-none');
    document.getElementById('btn-actualizar').classList.remove('d-none');
}

function limpiarModalPerfil() {
    const modalPerfil = document.getElementById('modalPerfil');

    modalPerfil.querySelector('#emailPerfil').value = '';
    modalPerfil.querySelector('#passwordPerfil').value = '';

    modalPerfil.querySelector('#errorEmailPerfil').textContent = '';
    modalPerfil.querySelector('#errorPasswordPerfil').textContent = '';

    modalPerfil.querySelector('#emailPerfil').disabled = true;
    modalPerfil.querySelector('#passwordPerfil').disabled = true;

    modalPerfil.querySelector('#btn-habilitar').classList.remove('d-none');
    modalPerfil.querySelector('#btn-actualizar').classList.add('d-none');
}

function actualizarDatos() {
    const email = document.getElementById('emailPerfil').value;
    const password = document.getElementById('passwordPerfil').value;

    const errorEmailPerfil = document.getElementById('errorEmailPerfil');
    const errorPasswordPerfil = document.getElementById('errorPasswordPerfil');

    errorEmailPerfil.textContent = '';
    errorPasswordPerfil.textContent = '';

    let error = false;

    if (!email) {
        errorEmailPerfil.textContent = 'El email es obligatorio.';
        error = true;
    }

    if (!password) {
        errorPasswordPerfil.textContent = 'La contraseña es obligatoria.';
        error = true;
    }

    if (!email && !password) {
        alert('Todos los campos son obligatorios');
        return;
    }

    fetch('admin?action=actualizarPerfil', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ email, password })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            mostrarToast('Perfil actualizado.', 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalPerfil'));
            modal.hide();
        } else {
            mostrarToast(data.error || 'Error al actualizar', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar el perfil');
    });
}
