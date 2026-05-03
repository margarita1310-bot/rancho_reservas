<header>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid px-3">
            <a class="navbar-brand rounded" href="#hero-section">
                <img src="<?= BASE_URL ?>images/logo.jpg" height="40" alt="LaJoya Logo">
            </a>

            <div class="d-flex align-items-center gap-3 order-lg-3">
                <div id="navLogin">
                    <button class="btn btn-login" onclick="abrirLogin()">
                        Iniciar sesión
                    </button>
                </div>

                <div class="dropdown d-none" id="navUser">
                    <a class="nav-link btn dropdown-toggle text-white" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-6 me-1"></i>
                        <span id="nombreClienteNav" class="d-none d-lg-inline"></span>
                        <span id="inicialesClienteNav" class="d-inline d-lg-none"></span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" onclick="abrirPerfilCliente()">Mi perfil</a></li>
                        <li><a class="dropdown-item" href="#" onclick="abrirReservasCliente()">Mis reservas</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="logout()">Cerrar sesión</a></li>
                    </ul>
                </div>

                <button class="navbar-toggler d-lg-none p-0" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasTop">
                    <i class="bi bi-list fs-1 text-white"></i>
                </button>
            </div>
            
            <div class="collapse navbar-collapse order-lg-2" id="navbarNav">
                <ul class="navbar-nav mx-auto align-items-lg-center gap-lg-3">
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link" href="#hero-section">Inicio</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link" href="#evento-section">Eventos</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link" href="#promocion-section">Promos</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link" href="#menu-section">Menú</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link" href="#galeria-section">Galería</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link" href="#footer-section">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="offcanvas offcanvas-top text-white" tabindex="-1" id="offcanvasTop">
        <div class="offcanvas-header px-3 py-2">
            <a class="navbar-brand rounded" href="#hero-section">
                <img src="<?= BASE_URL ?>images/logo.jpg" height="40" alt="LaJoya Logo">
            </a>

            <button class="btn text-white ms-auto px-0" type="button" data-bs-dismiss="offcanvas">
                <i class="bi bi-x-lg fs-1"></i>
            </button>
        </div>

        <div class="offcanvas-body d-flex flex-column align-items-center">
            <ul class="navbar-nav text-center">
                <li class="nav-item">
                    <a class="nav-link" href="#hero-section" data-bs-dismiss="offcanvas">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#evento-section" data-bs-dismiss="offcanvas">Eventos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#promocion-section" data-bs-dismiss="offcanvas">Promos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#menu-section" data-bs-dismiss="offcanvas">Menú</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#galeria-section" data-bs-dismiss="offcanvas">Galería</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#footer-section" data-bs-dismiss="offcanvas">Contacto</a>
                </li>
            </ul>
        </div>
    </div>
</header>
