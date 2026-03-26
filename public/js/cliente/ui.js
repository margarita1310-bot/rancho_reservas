function actualizarNavbar() {
    const id =  sessionStorage.getItem('id_cliente');
    const nombre = sessionStorage.getItem('nombre');

    const navLogin = document.getElementById('navLogin');
    const navUser = document.getElementById('navUser');

    if (id) {
        navLogin.classList.add('d-none');
        navUser.classList.remove('d-none');

        document.getElementById('nombreCliente').textContent = nombre ?? '';

        const partes = nombre.trim().split(" ");
        let iniciales = "";

        if (partes.length === 1) {
            iniciales = partes[0][0];
        } else {
            iniciales = partes[0][0] + partes[1][0];
        }

        document.getElementById('inicialesCliente').textContent = iniciales.toUpperCase();

    } else {
        navLogin.classList.remove('d-none');
        navUser.classList.add('d-none');
    }
}

function abrirLogin() {
    if (window.clienteLogueado) return;

    const loginModal = document.getElementById('loginModal');

    const modal = bootstrap.Modal.getInstance(loginModal) || new bootstrap.Modal(loginModal);
    modal.show();
}

document.addEventListener('DOMContentLoaded', () => {
    if (typeof google !== "undefined") {
        google.accounts.id.initialize({
            client_id: GOOGLE_CLIENT_ID,
            callback: handleCredentialResponse
        });

        const googleBtn = document.getElementById("google-button");

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

    const reservaModal = document.getElementById('reservaModal');

    if (reservaModal) {
        reservaModal.addEventListener('show.bs.modal', () => {
            goToStep(1);
        });
    }
});
