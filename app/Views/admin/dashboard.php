<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Rancho la Joya</title>

    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Cabin:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    
    <!--Bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <!--Bootstrap iconos-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!--Link Estilos-->
    <link rel="stylesheet" href="/public/css/admin.css">

</head>
<body>

<div class="container-fluid">
    <div class="row min-vh-100">

        <?php include __DIR__ . '/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 order-md-2 ms-sm-auto px-md-4 py-4">
            
            <button class="btn btn-dark d-md-none mb-3"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarMenu">
                <i class="bi bi-list"></i>
            </button>

            <?php require_once $vista; ?>
        </main>

        <?php include __DIR__ . '/modal.php'; ?>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="/public/js/admin/sidebar.js"></script>
<script src="/public/js/admin/modal.js"></script>
<script src="/public/js/admin/filter.js"></script>
<script src="/public/js/admin/evento.js"></script>
<script src="/public/js/admin/promocion.js"></script>
</body>
</html>