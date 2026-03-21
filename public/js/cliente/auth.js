window.onload = function () {
    google.accounts.id.initialize({
        client_id: GOOGLE_CLIENT_ID,
        callback: handleCredentialResponse
    });
    google.accounts.id.renderButton(
        document.getElementById("google-button"),
        {
            theme: "outline",
            size: "large",
            text: "continue_with"
        }
    );
};

function handleCredentialResponse(response) {
    const user = parseJwt(response.credential);
    console.log(user);

    sessionStorage.setItem('email', user.email);
    sessionStorage.setItem('nombre', user.name ?? '');

    document.getElementById('nombre').value = user.name ?? '';
    
    goToStep(2);
    
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

            goToStep(2);
        } else {
            alert(data.message ?? 'Código incorrecto');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error de conexión');
    });
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
