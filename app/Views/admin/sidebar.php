<?php
$action = $_GET['action'] ?? 'inicio';
?>
<nav id="sidebarMenu"
    class="col-md-3 col-lg-2 order-md-1 d-md-block sidebar offcanvas-md offcanvas-start
           text-white bg-dark min-vh-100">

    <div class="offcanvas-header d-md-none border-bottom border-secondary">
        <h5 class="offcanvas-title">
            <i class="bi bi-house me-2"></i>
            Rancho La Joya
        </h5>
        <button type="button" class="btn-close btn-close-white"
                data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column p-3">

        <h4 class="text-center d-md-block mb-3">
            <i class="bi bi-house mb-2"></i>
            Rancho La Joya
        </h4>
        
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="index.php?action=inicio"
                    class="nav-link text-white <?= $action === 'inicio' ? 'active bg-primary' : '' ?>">
                    <i class="bi bi-grid me-2"></i>
                    Inicio
                </a>
            </li>

            <li class="nav-item">
                <a href="index.php?action=promocion"
                    class="nav-link text-white <?= $action === 'promocion' ? 'active bg-primary' : '' ?>">
                    <i class="bi bi-megaphone me-2"></i>
                    Promociones
                </a>
            </li>

            <li class="nav-item">
                <a href="index.php?action=evento"
                    class="nav-link text-white <?= $action === 'evento' ? 'active bg-primary' : '' ?>">
                    <i class="bi bi-calendar-week me-2"></i>
                    Eventos
                </a>
            </li>

            <li class="nav-item">
                <a href="index.php?action=reserva"
                    class="nav-link text-white <?= $action === 'reserva' ? 'active bg-primary' : '' ?>">
                    <i class="bi bi-people me-2"></i>
                    Reservas
                </a>
            </li>
        </ul>

        <hr class="border-secondary">

        <a href="index.php?action=logout"
            class="btn btn-danger w-100 mt-auto">
            <i class="bi bi-box-arrow-right me-2"></i>
            Cerrar sesión
        </a>
    </div>
</nav>