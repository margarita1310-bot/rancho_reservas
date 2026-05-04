<?php $action = $_GET['action'] ?? 'inicio'; ?>
<nav id="sidebarMenu"
    class="col-md-3 col-lg-2 vh-100 sidebar collapse d-md-block text-white">

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
                <a href="admin?action=inicio"
                    class="nav-link text-white <?= $action === 'inicio' ? 'active' : '' ?>">
                    <i class="bi bi-grid me-2"></i>
                    Inicio
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse"
                    href="#menuSubmenu">
                    <span><i class="bi bi-box me-2"></i>Menú</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
            
                <div class="collapse <?= in_array($action, ['categoriaProducto','producto']) ? 'show' : '' ?>" id="menuSubmenu">
                    <ul class="nav flex-column ms-3">
                        <li>
                            <a href="admin?action=categoriaProducto"
                                class="nav-link text-white <?= $action === 'categoriaProducto' ? 'active' : '' ?>">
                                Categorías
                            </a>
                        </li>
                        <li>
                            <a href="admin?action=producto"
                                class="nav-link text-white <?= $action === 'producto' ? 'active' : '' ?>">
                                Productos
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse"
                    href="#eventoSubmenu">
                    <span><i class="bi bi-calendar2-week me-2"></i>Eventos</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                
                <div class="collapse <?= in_array($action, ['evento','eventoFinalizado']) ? 'show' : '' ?>" id="eventoSubmenu">
                    <ul class="nav flex-column ms-3">
                        <li>
                            <a href="admin?action=evento"
                                class="nav-link text-white <?= $action === 'evento' ? 'active' : '' ?>">
                                Activos
                            </a>
                        </li>
                        <li>
                            <a href="admin?action=eventoFinalizado"
                                class="nav-link text-white <?= $action === 'eventoFinalizado' ? 'active' : '' ?>">
                                Finalizados
                            </a>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <a href="admin?action=promocion"
                    class="nav-link text-white <?= $action === 'promocion' ? 'active' : '' ?>">
                    <i class="bi bi-tag me-2"></i>
                    Promociones
                </a>
            </li>

            <li class="nav-item">
                <a href="admin?action=reserva"
                    class="nav-link text-white <?= $action === 'reserva' ? 'active' : '' ?>">
                    <i class="bi bi-journal-check me-2"></i>
                    Reservas
                </a>
            </li>
        </ul>

        <hr class="border-secondary">


        <button class="btn btn-primary w-100 mt-auto mb-2"
        data-bs-toggle="modal"
        data-bs-target="#modalPerfil">
            <i class="bi bi-person-circle me-2"></i>
            Perfil
        </button>

        <a href="admin?action=logout"
            class="btn btn-danger w-100">
            <i class="bi bi-box-arrow-right me-2"></i>
            Cerrar sesión
        </a>
    </div>
</nav>