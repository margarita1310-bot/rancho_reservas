<div class="container-fluid">
    
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-calendar-event me-2"></i>
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

    <!-- Filtros -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <div class="btn-group" role="group">

                <button type="button"
                        class="btn btn-outline-secondary active"
                        data-filter="todos">
                    <i class="bi bi-list-ul me-1"></i>
                    Todas
                </button>

                <button type="button"
                        class="btn btn-outline-success"
                        data-filter="activo">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    Activas
                </button>

                <button type="button"
                        class="btn btn-outline-danger"
                        data-filter="cancelado">
                    <i class="bi bi-x-circle-fill me-1"></i>
                    Canceladas
                </button>

            </div>

        </div>
    </div>

    <!-- Tabla -->
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive rounded">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Horario</th>
                            <th>Mesas</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $evento = $evento ?? []; ?>

                        <?php if (!empty($evento)): ?>
                            <?php foreach ($evento as $ev): ?>

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
                                        <?= htmlspecialchars($ev['fecha']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($ev['hora']) ?>
                                        -
                                        <?= htmlspecialchars($ev['hora_fin']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($ev['mesas_disponibles']) ?>
                                    </td>

                                    <td>
                                        $<?= htmlspecialchars($ev['precio_mesa']) ?>
                                    </td>

                                    <td>
                                        <span class="badge 
                                            <?= $ev['estado'] === 'activo'
                                                ? 'bg-success'
                                                : ($ev['estado'] === 'cancelado'
                                                    ? 'bg-danger'
                                                    : 'bg-secondary') ?>">
                                            <?= htmlspecialchars($ev['estado']) ?>
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">

                                            <button class="btn btn-outline-primary btn-update"
                                                    data-id="<?= $ev['id_evento'] ?>"
                                                    data-controller="Evento">
                                                <i class="bi bi-pencil"></i>
                                            </button>

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
                                <td colspan="7" class="text-center py-5 text-muted">
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