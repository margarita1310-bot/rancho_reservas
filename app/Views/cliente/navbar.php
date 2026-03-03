<header>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand rounded" href="#hero-section">
                <img src="/public/images/logo.jpg" height="36" alt="LaJoya Logo">
            </a>

            <div class="ms-auto d-flex align-items-center gap-3">
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasTop">
                    <i class="bi bi-list text-white fs-1"></i>
                </button>
            </div>
            
            <div class="collapse navbar-collapse d-none d-lg-flex" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#promocion-section">Promociones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#evento-section">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#footer-section">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="offcanvas offcanvas-top text-white" tabindex="-1" id="offcanvasTop">
        <div class="offcanvas-header">
            <a class="navbar-brand rounded" href="#hero-section">
                <img src="/public/images/logo.jpg" height="36" alt="LaJoya Logo">
            </a>

            <button type="button" class="btn text-white ms-auto" data-bs-dismiss="offcanvas">
                <i class="bi bi-x-lg fs-3"></i>
            </button>
        </div>
        <div class="offcanvas-body d-flex flex-column align-items-center">
            <ul class="navbar-nav text-center">
                <li class="nav-item">
                    <a class="nav-link" href="#promocion-section" data-bs-dismiss="offcanvas">Promociones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#evento-section" data-bs-dismiss="offcanvas">Eventos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#footer-section" data-bs-dismiss="offcanvas">Contacto</a>
                </li>
            </ul>
        </div>
    </div>
</header>
