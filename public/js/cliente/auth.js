function handleCredentialResponse(response) {
    const user = parseJwt(response.credential);
    console.log(user);

    sessionStorage.setItem('email', user.email);
    sessionStorage.setItem('nombre', user.name ?? '');

    document.getElementById('nombre').value = user.name ?? '';
    
    fetch('index.php?action=google', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            token: response.credential
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {

            sessionStorage.setItem("id_cliente", data.cliente.id_cliente);

            loginExitoso(data.cliente);
        }
    });
}

function enviarCodigo() {
    const email = document.getElementById('emailLogin').value;

    fetch('index.php?action=enviarCodigo', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `email=${email}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('bloqueCodigo').classList.remove('d-none');
            document.getElementById('btnValidarCodigo').classList.remove('d-none');
        } else {
            alert('Error al enviar el código');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error de conexión');
    });
}

function validarCodigo() {
    const codigo = document.getElementById('codigo').value.trim();
    const email = document.getElementById('emailLogin').value.trim();

    if (!codigo) {
        alert('Ingresa el código');
        return;
    }

    fetch('index.php?action=validarCodigo', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `codigo=${encodeURIComponent(codigo)}&email=${encodeURIComponent(email)}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            sessionStorage.setItem('email', email);
            
            if (data.cliente) {
                sessionStorage.setItem('id_cliente', data.cliente.id_cliente);
                sessionStorage.setItem('nombre', data.cliente.nombre ?? '');
                sessionStorage.setItem('telefono', data.cliente.telefono ?? '');
            }

            loginExitoso(data.cliente);
        } else {
            alert(data.message ?? 'Código incorrecto');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error de conexión');
    });
}

function loginExitoso(cliente) {
    sessionStorage.setItem('id_cliente', cliente.id_cliente);
    sessionStorage.setItem('nombre', cliente?.nombre ?? '');
    sessionStorage.setItem('email', cliente?.email ?? '');
    sessionStorage.setItem('telefono', cliente?.telefono ?? '');
    
    window.clienteLogueado = true;
    
    const loginModal = document.getElementById('loginModal');

    const modal = bootstrap.Modal.getInstance(loginModal) || new bootstrap.Modal(loginModal);
    modal.hide();

    actualizarNavbar();

    if (!cliente.nombre?.trim() || !cliente.telefono?.trim()) {

        const datosModal = document.getElementById('datosModal');

        const modal = bootstrap.Modal.getInstance(datosModal) || new bootstrap.Modal(datosModal);
        modal.show();
    }
}

function logout() {
    sessionStorage.clear();
    window.clienteLogueado = false;
    actualizarNavbar();
    location.reload();
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
