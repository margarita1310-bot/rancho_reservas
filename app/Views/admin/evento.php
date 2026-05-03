<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div class="flex-grow-1">
            <h2 class="fw-bold mb-1">
                <i class="bi bi-calendar2-week me-2"></i>
                Agenda de Eventos
            </h2>
            <p class="text-muted mb-0">
                Crea y administra eventos especiales como shows, promociones temáticas o fechas importantes. Define información relevante como nombre, descripción, fecha y detalles adicionales para mantener a los clientes informados y atraer mayor participación.
            </p>
        </div>

        <div class="flex-shrink-0">
            <button class="btn btn-primary d-flex align-items-center gap-2 shadow-sm"
            id="btn-create-evento">
                <i class="bi bi-plus-circle"></i>
                Crear evento
            </button>
        </div>
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
                        <?php require_once ROOT_PATH . '/app/helpers/format.php' ?>
                        <?php $eventos = $eventos ?? []; ?>
                        <?php if (!empty($eventos)): ?>
                            <?php foreach ($eventos as $ev): ?>
                                <?php $bloqueado = ((int)$ev['tiene_reservas'] > 0); ?>
                                <tr data-estado="<?= strtolower($ev['estado']) ?>">
                                    <td>
                                        <?php if ($bloqueado): ?>
                                            <span class="badge bg-danger mb-1" title="No se puede editar ni borrar">
                                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                                Este evento tiene reservas.
                                            </span>
                                            <br>
                                        <?php endif; ?>
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
                                                    : 'bg-dark') ?>">
                                            <?= htmlspecialchars($ev['estado']) ?>
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <?php if ($bloqueado): ?>
                                                <button class="btn btn-outline-primary btn-update-mesas"
                                                data-id="<?= $ev['id_evento'] ?>"
                                                title="Agregar más mesas">
                                                    <i class="bi bi-plus-circle"></i>
                                                </button>
                                            <?php else: ?>
                                                <button class="btn btn-outline-primary btn-update"
                                                data-id="<?= $ev['id_evento'] ?>"
                                                data-controller="Evento"
                                                title="Editar evento">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                
                                                <button class="btn btn-outline-danger btn-delete"
                                                data-id="<?= $ev['id_evento'] ?>"
                                                data-controller="Evento"
                                                title="Borrar evento">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            <?php endif; ?>
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