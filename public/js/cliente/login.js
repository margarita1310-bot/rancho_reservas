function login() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('login modal'));
    modal.hide();

    mostrarUsuarioLogueado();
}

function mostrarUsuarioLogueado() {
    document.getElementById('navLogin').classList.add('d-node');
    document.getElementById('navUser').classList.remove('d-node');
}

function logout() {
    location.reload();
}