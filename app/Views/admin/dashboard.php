<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Rancho la Joya</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Rye&family=Zain:ital,wght@0,200;0,300;0,400;0,700;0,800;0,900;1,300;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/public/css/admin.css">

</head>
<body>
    <div class="sidebarMovil d-md-none text-white d-flex justify-content-between align-items-center px-3 py-2 shadow-sm">
        <h1 class="d-flex align-items-center mb-0 fs-5">
            <img src="/public/images/logo.jpg" alt="Rancho La Joya Logo" class="sidebar-logo rounded ms-2 me-2">
            Rancho La Joya
        </h1>
        <button id="toggleSidebarBtn"
            class="btn d-md-none text-white"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu">
            <i class="bi bi-list fs-4"></i>
        </button>
    </div>
    
    <div class="container-fluid">
        <div class="row">
            
            <?php include __DIR__ . '/sidebar.php'; ?>
            
            <main class="col-md-9 col-lg-10 order-md-2 ms-sm-auto px-md-4 py-4">
                
                <?php require_once $vista; ?>
            
            </main>
            
            <?php include __DIR__ . '/modal.php'; ?>
        
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="/public/js/admin/filter.js"></script>
<script src="/public/js/admin/helpers.js"></script>
<script src="/public/js/admin/sidebar.js"></script>
<script src="/public/js/admin/modal.js"></script>
<script src="/public/js/admin/evento.js"></script>
<script src="/public/js/admin/promocion.js"></script>

</body>
</html>