document.addEventListener('DOMContentLoaded', () => {
    if (typeof google !== "undefined") {
        google.accounts.id.initialize({
            client_id: GOOGLE_CLIENT_ID,
            callback: handleCredentialResponse
        });

        const googleBtn = document.getElementById("googleLogin");

        if (googleBtn) {
            google.accounts.id.renderButton(googleBtn, {
                    theme: "outline",
                    size: "large",
                    text: "continue_with",
                    width: "100%"
            });
        }
    }

    const id = sessionStorage.getItem('id_cliente');
    window.clienteLogueado = !!id;

    actualizarNavbar();

    const modalReservar = document.getElementById('modalReservar');

    if (modalReservar) {
        modalReservar.addEventListener('show.bs.modal', () => {
            goToStep(1);
        });

        modalReservar.addEventListener('hidden.bs.modal', () => {
            limpiarModalReservar();
            mostrarToast('Reserva cancelada.', 'info');
        });
    }

    const modalLogin = document.getElementById('modalLogin');

    if (modalLogin) {
        modalLogin.addEventListener('hidden.bs.modal', function () {
            limpiarModalLogin();
        });
    }

    const modalPerfil = document.getElementById('modalPerfilCliente');

    if (modalPerfil) {
        modalPerfil.addEventListener('hidden.bs.modal', function () {
            limpiarModalPerfil();
        });
    }
});

function limpiarModalLogin() {
    const modalLogin = document.getElementById('modalLogin');
    
    modalLogin.querySelector('#emailLogin').value = '';
    modalLogin.querySelector('#codigoLogin').value = '';

    modalLogin.querySelector('#errorEmailLogin').textContent = '';
    modalLogin.querySelector('#errorCodigoLogin').textContent = '';

    modalLogin.querySelector('#bloqueCodigoLogin').classList.add('d-none');
    modalLogin.querySelector('#validarCodigoLogin').classList.add('d-none');
    modalLogin.querySelector('#enviarCodigoLogin').classList.remove('d-none');

    modalLogin.querySelector('#emailLogin').disabled = false;
}

function limpiarModalPerfil() {
    const modalPerfil = document.getElementById('modalPerfilCliente');

    modalPerfil.querySelector('#emailPerfil').value = '';
    modalPerfil.querySelector('#nombrePerfil').value = '';
    modalPerfil.querySelector('#telefonoPerfil').value = '';

    modalPerfil.querySelector('#errorEmailPerfil').textContent = '';
    modalPerfil.querySelector('#errorNombrePerfil').textContent = '';
    modalPerfil.querySelector('#errorTelefonoPerfil').textContent = '';

    modalPerfil.querySelector('#emailPerfil').disabled = true;
    modalPerfil.querySelector('#nombrePerfil').disabled = true;
    modalPerfil.querySelector('#telefonoPerfil').disabled = true;

    modalPerfil.querySelector('#btn-habilitar').classList.remove('d-none');
    modalPerfil.querySelector('#btn-eliminar').classList.remove('d-none');
    modalPerfil.querySelector('#btn-actualizar').classList.add('d-none');
}

function limpiarModalReservar() {
    const modalReservar = document.getElementById('modalReservar');

    modalReservar.querySelector('#horaEvento').value = '';
    modalReservar.querySelector('#personasEvento').value = '';

    modalReservar.querySelector('#errorHoraEvento').textContent = '';
    modalReservar.querySelector('#errorPersonasEvento').textContent = '';
    modalReservar.querySelector('#error-reserva').textContent = '';

    modalReservar.querySelector('#info-hora').textContent = '';
    modalReservar.querySelector('#info-personas').textContent = '';

    modalReservar.querySelector('#confirmarNombre').textContent = '';
    modalReservar.querySelector('#confirmarEmail').textContent = '';
    modalReservar.querySelector('#confirmarTelefono').textContent = '';
    modalReservar.querySelector('#confirmarEvento').textContent = '';
    modalReservar.querySelector('#confirmarFecha').textContent = '';
    modalReservar.querySelector('#confirmarPrecio').textContent = '';
    modalReservar.querySelector('#confirmarHora').textContent = '';
    modalReservar.querySelector('#confirmarPersonas').textContent = '';

    modalReservar.querySelectorAll('.step').forEach(s => s.classList.add('d-none'));
    modalReservar.querySelector('#step1').classList.remove('d-none');

    modalReservar.querySelectorAll('.step-indicator').forEach(s => s.classList.remove('active'));
    modalReservar.querySelector('#indicator1').classList.add('active');

    const paypal = modalReservar.querySelector('#paypal-button');

    if (paypal) {
        paypal.innerHTML = '';
        paypal.removeAttribute('data-reserva');
    }
}

