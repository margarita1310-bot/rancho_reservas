<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - Rancho La Joya</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Rye&family=Zain:ital,wght@0,200;0,300;0,400;0,700;0,800;0,900;1,300;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/login.css">

</head>
<body class="bg-dark d-flex align-items-center justify-content-center min-vh-100">
    <main class="container">
        <section class="row g-0 rounded-4 overflow-hidden shadow login-container w-100">
        
            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center bg-dark">
                <img src="<?= BASE_URL ?>images/logo.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="Logo">
            </div>
        
            <div class="col-12 col-lg-6 p-4 p-md-5 text-white">
                <h1 class="mb-3">Iniciar Sesión</h1>
                
                <p class="mb-4 text-secondary">
                    Acceso exclusivo al panel de gestión de El Bar del Rancho La Joya.
                </p>

                <form method="POST" action="admin?action=autenticar">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-login w-100">
                        Ingresar
                    </button>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger mt-3" role="alert">
                            <?= $error ?>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </section>
    </main>
</body>
</html>