<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rancho la Joya</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Rye&family=Zain:ital,wght@0,200;0,300;0,400;0,700;0,800;0,900;1,300;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="icon" href="<?= BASE_URL ?>images/logo.jpg">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/cliente.css">
    
</head>
<body>

    <?php include __DIR__ . '/navbar.php'; ?>
    
    <main>

        <?php include __DIR__ . '/hero.php'; ?>
        <?php include __DIR__ . '/evento.php'; ?>
        <?php include __DIR__ . '/promocion.php'; ?>
        <?php include __DIR__ . '/menu.php'; ?>
        <?php include __DIR__ . '/galeria.php'; ?>
        <?php include __DIR__ . '/footer.php'; ?>
        <div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3"></div>
    
    </main>

    <?php include __DIR__ . '/modalAdP.php'; ?>
    <?php include __DIR__ . '/modalLogin.php'; ?>
    <?php include __DIR__ . '/modalDatosCliente.php'; ?>
    <?php include __DIR__ . '/modalTyC.php'; ?>
    <?php include __DIR__ . '/modalReservar.php'; ?>
    <?php include __DIR__ . '/modalPerfilCliente.php'; ?>
    <?php include __DIR__ . '/modalReservasCliente.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo $_ENV['PAYPAL_CLIENT_ID']; ?>&currency=<?php echo $_ENV['PAYPAL_CURRENCY']; ?>"></script>
    <script>const GOOGLE_CLIENT_ID = "<?php echo $_ENV['GOOGLE_CLIENT_ID']; ?>";</script>
    <script>const BASE_URL = "<?= BASE_URL ?>"</script>
    <script src="<?= BASE_URL ?>js/cliente/filter.js"></script>
    <script src="<?= BASE_URL ?>js/cliente/ui.js"></script>
    <script src="<?= BASE_URL ?>js/cliente/app.js"></script>
    <script src="<?= BASE_URL ?>js/cliente/auth.js"></script>
    <script src="<?= BASE_URL ?>js/cliente/cliente.js"></script>
    <script src="<?= BASE_URL ?>js/cliente/reserva.js"></script>
    <script src="<?= BASE_URL ?>js/cliente/pago.js"></script>
    
</body>
</html>
