<div class="container-fluid">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-calendar2-week me-2"></i>
                Agenda de Eventos
            </h2>
            <p class="text-muted mb-0">
                Organiza y gestiona eventos especiales
            </p>
        </div>

        <button id="btn-create-evento" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-plus-circle"></i>
            Crear evento
        </button>

    </div>

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <div class="btn-group flex-wrap" role="group">

                <button type="button"
                        class="btn btn-outline-dark active"
                        data-filter="todos">
                    <i class="bi bi-list-ul me-1"></i>
                    Todos
                </button>

                <button type="button"
                        class="btn btn-outline-warning"
                        data-filter="proximo">
                    <i class="bi bi-calendar-event me-1"></i>
                    Proximos
                </button>

                <button type="button"
                        class="btn btn-outline-success"
                        data-filter="activo">
                    <i class="bi bi-play-circle me-1"></i>
                    Activos
                </button>

                <button type="button"
                        class="btn btn-outline-secondary"
                        data-filter="finalizado">
                    <i class="bi bi-flag me-1"></i>
                    Finalizados
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
                            <th>Nombre</th>
                            <th>Horario</th>
                            <th>Mesas</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php require_once __DIR__ . '/../../helpers/format.php' ?>

                        <?php $eventos = $eventos ?? []; ?>

                        <?php if (!empty($eventos)): ?>

                            <?php foreach ($eventos as $ev): ?>

                                <tr data-estado="<?= strtolower($ev['estado']) ?>">

                                    <td>
                                        <div class="fw-semibold">
                                            <?= htmlspecialchars($ev['nombre']) ?>
                                        </div>
                                        <small class="text-muted">
                                            <?= htmlspecialchars($ev['descripcion']) ?>
                                        </small>
                                    </td>

                                    <td>
                                        <span class="d-block">
                                            <?= htmlspecialchars(formatearFecha($ev['fecha'])) ?>
                                        </span>
                                        <small class="text-muted">
                                            <?= htmlspecialchars(formatearHora($ev['hora'])) ?>
                                            -
                                            <?= htmlspecialchars(formatearHora($ev['hora_fin'])) ?>
                                        </small>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($ev['mesas_disponibles']) ?>
                                    </td>

                                    <td>
                                        $<?= htmlspecialchars($ev['precio_mesa']) ?>
                                    </td>

                                    <td>
                                        <span class="badge 
                                            <?= $ev['estado'] === 'proximo'
                                                ? 'bg-warning'
                                                : ($ev['estado'] === 'activo'
                                                    ? 'bg-success'
                                                    : ($ev['estado'] === 'finalizado'
                                                        ? 'bg-secondary'
                                                        : 'bg-dark')) ?>">
                                            <?= htmlspecialchars($ev['estado']) ?>
                                        </span>
                                    </td>

                                    <td class="text-center">

                                        <?php $bloqueado = ((int)$ev['tiene_reservas'] > 0); ?>

                                        <div class="btn-group btn-group-sm">

                                            <?php if ($bloqueado): ?>

                                                <span title="No se puede editar, tiene reservas">
                                                    <button class="btn btn-outline-primary btn-update" disabled>
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                </span>

                                            <?php else: ?>
                                                
                                                <button class="btn btn-outline-primary btn-update"
                                                        data-id="<?= $ev['id_evento'] ?>"
                                                        data-controller="Evento"
                                                        title="Editar evento">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                            <?php endif; ?>

                                            <button class="btn btn-outline-danger btn-delete"
                                                    data-id="<?= $ev['id_evento'] ?>"
                                                    data-controller="Evento">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </div>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
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
</div>