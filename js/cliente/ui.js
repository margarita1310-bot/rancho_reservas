window.addEventListener("scroll", function() {
    const navbar = document.querySelector(".navbar");
    const hero = document.querySelector(".hero-section");
    const heroHeight = hero.offsetHeight;
    
    if (window.scrollY < heroHeight - 50) {
        navbar.style.backgroundColor = "transparent";
    } else {
        navbar.style.backgroundColor = "rgba(32, 13, 2, 0.6)";
    }
});

document.querySelectorAll('.offcanvas .nav-link').forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();

        const targetId = this.getAttribute('href');
        const target = document.querySelector(targetId);

        const offcanvas = bootstrap.Offcanvas.getInstance(
            document.getElementById('offcanvasTop')
        );

        offcanvas.hide();

        setTimeout(() => {
            target.scrollIntoView({ behavior: 'smooth' });
        }, 300);
    });
});

function mostrarToast(message, type = 'success') {
    const colores = {
        success: 'bg-success text-white',
        error: 'bg-danger text-white',
        warning: 'bg-warning text-dark',
        info: 'bg-info text-white'
    }

    const toastHTML = `
        <div class="toast align-items-center ${colores[type]} border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;

    const toastContainer = document.getElementById('toastContainer');
    toastContainer.insertAdjacentHTML('beforeend', toastHTML);

    const toastElement = toastContainer.lastElementChild;
    const toast = new bootstrap.Toast(toastElement, { delay: 2500 });
    toast.show();

    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}

function actualizarNavbar() {
    const id =  sessionStorage.getItem('id_cliente');
    const nombre = sessionStorage.getItem('nombre_cliente');

    const navLogin = document.getElementById('navLogin');
    const navUser = document.getElementById('navUser');

    if (id) {
        navLogin.classList.add('d-none');
        navUser.classList.remove('d-none');

        document.getElementById('nombreClienteNav').textContent = nombre ?? '';

        const partes = nombre.trim().split(" ");
        let iniciales = "";

        if (partes.length === 1) {
            iniciales = partes[0][0];
        } else {
            iniciales = partes[0][0] + partes[1][0];
        }

        document.getElementById('inicialesClienteNav').textContent = iniciales.toUpperCase();

    } else {
        navLogin.classList.remove('d-none');
        navUser.classList.add('d-none');
    }
}

function goToStep(step) {
    document.querySelectorAll('.step').forEach(s => s.classList.add('d-none'));
    document.getElementById('step' + step).classList.remove('d-none');

    document.querySelectorAll('.step-indicator').forEach(s => {
        s.classList.remove('active', 'completed');
    });

    for (let i = 1; i <= 3 ; i++) {
        const indicator = document.getElementById('indicator' + i);

        if (i < step) {
            indicator.classList.add('completed');
            indicator.innerHTML = '<i class="bi bi-check"></i>';
        } else if (i === step) {
            indicator.classList.add('active');
            indicator.innerHTML = i;
        } else {
            indicator.innerHTML = i;
        }
    }
}

function aMinutos(hhmm) {
    const [h, m] = hhmm.split(":").map(Number);
    return h * 60 + m;
}

function minutosAHora(min) {
    min = min % (24 * 60);

    const h = Math.floor(min / 60);
    const m = min % 60;

    return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;
}
