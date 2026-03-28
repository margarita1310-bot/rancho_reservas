<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de pago - Rancho la Joya</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Rye&family=Zain:ital,wght@0,200;0,300;0,400;0,700;0,800;0,900;1,300;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/comprobante.css">

</head>
<body>
    <div class="container py-5">

        <div class="card shadow-sm mx-auto">

            <div class="card-header text-center text-white">
                <h4 class="mb-0">Comprobante de Pago</h4>
            </div>

            <div class="card-body">
                <div class="text-center mb-3">
                    <span class="badge bg-success">PAGADO</span>
                </div>

                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item">
                        <strong>Folio:</strong> #<?= $reserva['id_reserva'] ?>
                    </li>
                    <li class="list-group-item">
                        <strong>Cliente:</strong> <?= $reserva['cliente'] ?>
                    </li>
                    <li class="list-group-item">
                        <strong>Email:</strong> <?= $reserva['email'] ?>
                    </li>
                    <li class="list-group-item">
                        <strong>Evento:</strong> <?= $reserva['evento'] ?>
                    </li>
                    <li class="list-group-item">
                        <strong>Fecha del evento:</strong> <?= $reserva['fecha'] ?>
                    </li>
                    <li class="list-group-item">
                        <strong>Personas:</strong> <?= $reserva['personas'] ?>
                    </li>
                </ul>

                <hr>

                <div class="d-flex justify-content-between">
                    <strong>Total:</strong>
                    <span class="fw-bold">$<?= $reserva['total'] ?> MXN</span>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <strong>Fecha de pago:</strong>
                    <span><?= $reserva['fecha_pago'] ?></span>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <strong>ID Transacción:</strong>
                    <span><?= $reserva['paypal_transaction_id'] ?></span>
                </div>

            </div>
        </div>
    </div>
</body>
</html>