<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div class="flex-grow-1">
            <h2 class="fw-bold mb-1">
                <i class="bi bi-journal-check me-2"></i>
                Panel de Reservas
            </h2>
            <p class="text-muted mb-0">
                Consulta y gestiona las reservas realizadas por los clientes. Visualiza información importante como fecha, horario, datos de contacto y estado de la reserva para garantizar una atención organizada y eficiente.
            </p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-shrink-0">
            <label for="filtro-fecha-reserva" class="form-label mb-0 fw-semibold">
                Fecha:
            </label>

            <input type="date"
            class="form-control form-control-sm"
            style="max-width: 180px;"
            id="filtro-fecha-reserva">
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
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Evento</th>
                            <th>Personas</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Pago</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php require_once ROOT_PATH . '/app/helpers/format.php' ?>
                        <?php require_once ROOT_PATH . '/app/helpers/estado.php' ?>
                        <?php $reservas = $reservas ?? []; ?>
                        <?php if (!empty($reservas)): ?>
                            <?php foreach ($reservas as $re): ?>
                                <tr data-estado="<?= strtolower($re['estado']) ?>"
                                    data-fecha="<?= date('Y-m-d', strtotime($re['fecha_reserva'])) ?>"
                                >
                                    <td>
                                        <?= htmlspecialchars($re['id_reserva']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(formatearFechaCompleta($re['fecha_reserva'])) ?>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">
                                            <?= htmlspecialchars($re['cliente']) ?>
                                        </div>

                                        <small class="text-muted">
                                            <?= htmlspecialchars($re['telefono']) ?>
                                        </small>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">
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
                                        <span class="badge <?= badgeReserva($re['estado']) ?>">
                                            <?= textoReserva($re['estado']) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge <?= badgePago($re['estado_pago']) ?>">
                                            <?= textoPago($re['estado_pago']) ?>
                                        </span>
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