//Función para validar los datos al iniciar sesión con Google
function handleCredentialResponse(response) {
    const user = parseJwt(response.credential);
    console.log(user);

    sessionStorage.setItem('email', user.email);
    sessionStorage.setItem('nombre', user.name ?? '');

    document.getElementById('nombre').value = user.name ?? '';
    
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
            if (data.cliente) {
                sessionStorage.setItem('id_cliente', data.cliente.id_cliente ?? '');
                sessionStorage.setItem('nombre', data.cliente.nombre ?? '');
                sessionStorage.setItem('telefono', data.cliente.telefono ?? '');
            }
            if (data.nuevo) {
                alert("Asegúrate de ingresar los siguientes datos correctamente.");
                abrirDatosModal(data.cliente);
            } else {
                loginExitoso(data.cliente);
            }
        }
    })
    .catch(() => alert("Error de Google."));
}

//Función para enviar el código al iniciar sesión por medio de correo
function enviarCodigo() {
    const email = document.getElementById('emailLogin').value;

    if (!email) {
        alert("Ingresa un correo electronico valido.");
        return;
    }

    fetch(BASE_URL + 'cliente?action=enviarCodigo', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `email=${email}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('btnEnviarCodigo').classList.add('d-none');
            document.getElementById('bloqueCodigo').classList.remove('d-none');
            document.getElementById('btnValidarCodigo').classList.remove('d-none');
        } else {
            alert("Error al enviar el código.");
        }
    })
    .catch(() => alert("Error de conexión."));
}

//Función para validar el código al iniciar sesión por medio de correo
function validarCodigo() {
    const codigo = document.getElementById('codigo').value.trim();
    const email = document.getElementById('emailLogin').value.trim();

    if(!email) {
        alert("Ingresa un correo electronico valido.");
        return;
    }

    if (!codigo) {
        alert("Ingresa el código.");
        return;
    }

    fetch(BASE_URL + 'cliente?action=validarCodigo', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `codigo=${encodeURIComponent(codigo)}`
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
            if (data.nuevo) {
                alert("Asegúrate de ingresar los siguientes datos correctamente.");
                abrirDatosModal(data.cliente);
            } else {
                loginExitoso(data.cliente);
            }

        } else {
            alert(data.message ?? "Código incorrecto.");
        }
    })
    .catch(() => alert("Error de conexión."));
}

//Función al iniciar sesión correctamente
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
}

//Función al cerrar sesión en la pagina
function logout() {
    sessionStorage.clear();
    window.clienteLogueado = false;
    actualizarNavbar();
    location.reload();
    alert("Sesión cerrada exitosamente.")
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
