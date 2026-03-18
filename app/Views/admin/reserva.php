<div class="container-fluid">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-journal-check me-2"></i>
                Panel de Reservas
            </h2>
            <p class="text-muted mb-0">
                Consulta y administra las reservaciones
            </p>
        </div>

        <div class="d-flex align-items-center gap-2">

            <label for="filtro-fecha-reserva" class="form-label mb-0 fw-semibold">
                Fecha:
            </label>

            <input type="date"
                   id="filtro-fecha-reserva"
                   class="form-control form-control-sm"
                   style="max-width: 180px;">

        </div>

    </div>

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <div class="btn-group flex-wrap" role="group">

                <button type="button"
                        class="btn btn-outline-dark active"
                        data-filter="todos">
                    <i class="bi bi-list-ul me-1"></i>
                    Todas
                </button>

                <button type="button"
                        class="btn btn-outline-warning"
                        data-filter="pendiente">
                    <i class="bi bi-hourglass-split me-1"></i>
                    Pendientes
                </button>

                <button type="button"
                        class="btn btn-outline-success"
                        data-filter="confirmada">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    Confirmadas
                </button>

                <button type="button"
                        class="btn btn-outline-danger"
                        data-filter="cancelada">
                    <i class="bi bi-x-circle-fill me-1"></i>
                    Canceladas
                </button>

            </div>

        </div>

    </div>

    <div class="card shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive rounded">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>Reserva</th>
                            <th>Cliente</th>
                            <th>Evento</th>
                            <th>Personas</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Pago</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php require_once __DIR__ . '/../../helpers/format.php' ?>
                        
                        <?php $reservas = $reservas ?? []; ?>
                        
                        <?php if (!empty($reservas)): ?>

                            <?php foreach ($reservas as $re): ?>

                                <tr data-estado="<?= strtolower($re['estado']) ?>">

                                    <td>
                                        <?= htmlspecialchars($re['id_reserva']) ?>
                                    </td>

                                    <td>
                                        <div class="fw-semiblod">
                                            <?= htmlspecialchars($re['cliente']) ?>
                                        </div>
                                        <small class="text-muted">
                                            <?= htmlspecialchars($re['telefono']) ?>
                                        </small>
                                    </td>

                                    <td>
                                        <div class="fw-semiblod">
                                            <?= htmlspecialchars($re['evento']) ?>
                                        </div>
                                        <small class="text-muted">
                                            <?= htmlspecialchars(formatearFecha($re['fecha'])) ?>
                                        </small>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($re['personas']) ?>
                                    </td>

                                    <td>
                                        $<?= htmlspecialchars($re['total']) ?>
                                    </td>

                                    <td>
                                        <span class="badge
                                            <?= $re['estado'] === 'pendiente'
                                            ? 'bg-warning'
                                            : ($re['estado'] === 'confirmada'
                                                ? 'bg-success'
                                                : ($re['estado'] === 'cancelada'
                                                    ? 'bg-danger'
                                                    : 'bg-secondary')) ?>">
                                            <?= htmlspecialchars($re['estado']) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge
                                            <?= $re['estado_pago'] === 'CREATED'
                                            ? 'bg-warning'
                                            : ($re['estado_pago'] === 'COMPLETED'
                                                ? 'bg-success'
                                                : ($re['estado_pago'] === 'FAILED'
                                                    ? 'bg-danger'
                                                    : 'bg-secondary')) ?>">
                                            <?= htmlspecialchars($re['estado_pago']) ?>
                                        </span>
                                    </td>

                                    <td class="text-center">

                                        <div class="btn-group btn-group-sm">

                                            <button class="btn btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                        </div>

                                    </td>

                                </tr>
                            
                            <?php endforeach; ?>
                        
                        <?php else: ?>

                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
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