<?php
$action = $_GET['action'] ?? 'inicio';
?>
<nav id="sidebarMenu"
    class="col-md-3 col-lg-2 vh-100 sidebar collapse d-md-block
            text-white">

    <div class="d-flex flex-column p-3">
        <div class="sidebar-header">
            <h1 class="text-center mb-1 d-flex flex-column align-items-center">
                <i class="bi bi-house fs-1 mb-3"></i>
                Rancho La Joya
            </h1>

            <p class="text-center">Panel de Administración</p>

            <hr class="border-secondary">
        </div>
        
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="index.php?action=inicio"
                    class="nav-link text-white <?= $action === 'inicio' ? 'active' : '' ?>">
                    <i class="bi bi-grid me-2"></i>
                    Inicio
                </a>
            </li>

            <li class="nav-item">
                <a href="index.php?action=promocion"
                    class="nav-link text-white <?= $action === 'promocion' ? 'active' : '' ?>">
                    <i class="bi bi-tag me-2"></i>
                    Promociones
                </a>
            </li>

            <li class="nav-item">
                <a href="index.php?action=evento"
                    class="nav-link text-white <?= $action === 'evento' ? 'active' : '' ?>">
                    <i class="bi bi-calendar2-week me-2"></i>
                    Eventos
                </a>
            </li>

            <li class="nav-item">
                <a href="index.php?action=reserva"
                    class="nav-link text-white <?= $action === 'reserva' ? 'active' : '' ?>">
                    <i class="bi bi-journal-check me-2"></i>
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