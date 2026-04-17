function abrirLogin() {
    if (window.clienteLogueado) return;

    document.getElementById('emailLogin').disabled = false;
    const modalLogin = document.getElementById('modalLogin');
    const modal = bootstrap.Modal.getInstance(modalLogin) || new bootstrap.Modal(modalLogin);
    modal.show();
}

function cerrarLogin() {
    const modalLogin = document.getElementById('modalLogin');
    const modal = bootstrap.Modal.getInstance(modalLogin) || new bootstrap.Modal(modalLogin);
    modal.hide();
}

function abrirDatosLogin() {
    cerrarLogin();
    abrirDatosCliente();
}

function enviarCodigo() {
    const email = document.getElementById('emailLogin').value;
    const errorEmailLogin = document.getElementById('errorEmailLogin');

    errorEmailLogin.textContent = '';

    let error = false;
    
    if (!email) {
        errorEmailLogin.textContent = 'El correo es obligatorio.';
        error = true;
    }
    
    fetch(BASE_URL + 'cliente?action=enviarCodigo', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `email=${encodeURIComponent(email)}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            mostrarToast('Enviando código, revisa tu correo electrónico.', 'info');
            document.getElementById('emailLogin').disabled = true;
            document.getElementById('enviarCodigoLogin').classList.add('d-none');
            document.getElementById('bloqueCodigoLogin').classList.remove('d-none');
            document.getElementById('validarCodigoLogin').classList.remove('d-none');
        } else {
            mostrarToast(data.msg || 'Error al enviar el código.', 'error');
        }
    })
    .catch(() => mostrarToast('Error de conexión.', 'error'));
}

function validarCodigo() {
    const codigo = document.getElementById('codigoLogin').value.trim();
    const email = document.getElementById('emailLogin').value.trim();

    const errorCodigoLogin = document.getElementById('errorCodigoLogin');

    errorCodigoLogin.textContent = '';

    let error = false;

    if (!codigo) {
        errorCodigoLogin.textContent = 'El código es obligatorio.';
        error = true;
    }

    fetch(BASE_URL + 'cliente?action=validarCodigo', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `codigo=${encodeURIComponent(codigo)}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            sessionStorage.setItem('email_cliente', email);
            if (data.nuevo) {
                abrirDatosLogin();
                return;
            }
            if (data.cliente) {
                successLogin(data.cliente);
            }
        } else {
            errorCodigoLogin.textContent = data.msg || 'Código incorrecto.';
        }
    })
    .catch(() => mostrarToast('Error de conexión.', 'error'));
}

function parseJwt(token) {
    const base64Url = token.split('.')[1];
    const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    const jsonPayload = decodeURIComponent(
        atob(base64)
        .split('')
        .map(c => '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2))
        .join('')
    );
    return JSON.parse(jsonPayload);
}

function handleCredentialResponse(response) {
    const user = parseJwt(response.credential);

    sessionStorage.setItem('email_cliente', user.email);

    document.getElementById('nombreCliente').value = user.name ?? '';
    
    fetch(BASE_URL + 'cliente?action=google', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            token: response.credential
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            if (data.nuevo) {
                abrirDatosLogin();
                return;
            }
            if (data.cliente) {
                successLogin(data.cliente);
            }
        }
    })
    .catch(() => mostrarToast('Error de Google.', 'error'));
}

function successLogin(cliente) {
    sessionStorage.setItem('id_cliente', cliente.id_cliente);
    sessionStorage.setItem('email_cliente', cliente?.email ?? '');
    sessionStorage.setItem('nombre_cliente', cliente?.nombre ?? '');
    sessionStorage.setItem('telefono_cliente', cliente?.telefono ?? '');

    mostrarToast('Inicio de sesión exitoso.', 'success');
    
    window.clienteLogueado = true;
    
    cerrarLogin();
    actualizarNavbar();

    if (sessionStorage.getItem('accion_post') === 'reservar') {
        sessionStorage.removeItem('accion_post');
        abrirDatosReserva();
    }
}

function logout() {
    sessionStorage.clear();
    window.clienteLogueado = false;
    actualizarNavbar();
    location.reload();
}

