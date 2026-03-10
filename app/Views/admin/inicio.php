<div class="container-fluid">

    <div class="mb-4">
        <h2 class="fw-bold mb-1">
            <i class="bi bi-grid me-2"></i>
            Panel General
        </h2>
        <p class="text-muted mb-0">
            Resumen de actividades del Rancho la Joya.
        </p>
    </div>

    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="card-title">Reservas Hoy</h5>
                    <h2 class="text-primary"><!-- --></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="card-title">Eventos Activos</h5>
                    <h2 class="text-success"><!-- --></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="card-title">Promociones</h5>
                    <h2 class="text-warning"><!-- --></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="card-title">Próximos Eventos</h5>
                    <h2 class="text-danger"><!-- --></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    Próximos Eventos
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Evento</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $evento = $evento ?? []; ?>
                        <?php if (!empty($evento)): ?>
                            <?php foreach ($evento as $ev): ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars($ev['nombre']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($ev['fecha']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($ev['hora']) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox-fill fs-3 d-block mb-2"></i>
                                    No hay eventos registrados
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    Últimas Reservas
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Personas</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $reserva = $reserva ?? []; ?>
                        <?php if (!empty($reserva)): ?>
                            <?php foreach ($reserva as $re): ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars($re['nombre_cliente']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($re['fecha']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($re['personas']) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox-fill fs-3 d-block mb-2"></i>
                                    No hay reservas registradas
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
