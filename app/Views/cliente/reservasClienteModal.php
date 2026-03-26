<div class="modal fade" id="reservasClienteModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header p-0">

                <h4 class="modal-title">Mis Reservas</h4>
                <button type="button" class="btn p-0 text-black ms-auto" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg fs-4"></i>
                </button>

            </div>
            
            <div class="modal-body px-0">

                <?php require_once __DIR__ . '/../../helpers/format.php' ?>
                
                <?php $reservasCliente = $this->obtenerReservas(); ?>

                <?php if (!empty($reservasCliente)): ?>

                    <?php foreach ($reservasCliente as $rc): ?>

                        <div class="card mb-3 shadow-sm rounded">

                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-start mb-2">

                                    <div>

                                        <h4 class="mb-1 fw-blod"><?= $rc['evento'] ?></h4>
                                        <small class="text-muted">
                                            <?= formatearFecha($rc['fecha_evento']) ?>
                                        </small>

                                    </div>

                                    <div class="d-flex flex-column align-items-end gap-1">

                                        <?php if ($rc['estado_reserva'] === 'confirmada'): ?>
                                            <span class = "badge bg-success">Pagado</span>
                                        <?php elseif ($rc['estado_reserva'] === 'pendiente'): ?>
                                            <span class = "badge bg-warning">Pendiente</span>
                                        <?php elseif ($rc['estado_reserva'] === 'cancelada'): ?>
                                            <span class = "badge bg-danger">Cancelada</span>
                                        <?php endif; ?>

                                    </div>

                                </div>
                        
                                <hr class="my-2">

                                <div class="mb-2">

                                    <span class="badge bg-primary">
                                        <?= formatearhora($rc['hora']) ?>
                                        -
                                        <?= formatearhora($rc['hora_fin']) ?>
                                    </span>

                                </div>

                                <div class="row text-center mb-2">

                                    <div class="col">

                                        <small class="text-muted d-block">Personas</small>
                                        <strong><?= $rc['personas'] ?></strong>

                                    </div>

                                    <div class="col">

                                        <small class="text-muted d-block">Mesas</small>
                                        <strong><?= $rc['mesas_reservadas'] ?></strong>

                                    </div>

                                    <div class="col">

                                        <small class="text-muted d-block">Total</small>
                                        <strong class="text-success">$<?= $rc['total'] ?></strong>

                                    </div>

                                </div>

                                <div class="d-flex gap-2">

                                    <?php if ($rc['puede_pagar']): ?>
                                        <button class="btn btn-sm btn-success" onclick="pagarReserva(<?= $rc['id_reserva'] ?>)">
                                            <?= $rc['estado_pago'] === 'FAILED' ? 'Reintentar pago' : 'Pagar' ?>
                                        </button>
                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="card mb-4 shadow-sm border-0 text-center p-4">
                        <div class="card-body">
                            <h5 class="card-title text-muted">Sin reservas</h5>
            
                            <p class="card-text text-secondary">
                                Aún no has realizado ninguna reserva.
                            </p>
                        </div>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
        