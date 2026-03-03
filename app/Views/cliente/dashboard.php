<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rancho la Joya</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rye&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="/public/css/cliente.css">
</head>
<body>
    <?php include __DIR__ . '/navbar.php'; ?>
    
    <main>
        <?php include __DIR__ . '/hero.php'; ?>
        <?php include __DIR__ . '/promocion.php'; ?>
        <?php include __DIR__ . '/evento.php'; ?>
        <?php include __DIR__ . '/footer.php'; ?>
    </main>

    <?php include __DIR__ . '/modal.php'; ?>

    
    <!-- 1️⃣ Bootstrap SIEMPRE primero -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- 2️⃣ Google Sign In -->
<script src="https://accounts.google.com/gsi/client" async defer></script>

<!-- 3️⃣ JS propios (orden importa) -->
<script src="/public/js/cliente/navbar.js"></script>
<script src="/public/js/cliente/auth.js"></script>
<script src="/public/js/cliente/modal.js"></script>
</body>
</html>
