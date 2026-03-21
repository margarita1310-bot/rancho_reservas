<div class="container-fluid">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-tag me-2"></i>
                Gestión de Promociones
            </h2>
            <p class="text-muted mb-0">
                Gestiona las ofertas y promociones disponibles
            </p>
        </div>

        <button id="btn-create-promocion" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-plus-circle"></i>
            Crear promoción
        </button>

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
                        data-filter="proxima">
                    <i class="bi bi-calendar-event me-1"></i>
                    Proximas
                </button>

                <button type="button"
                        class="btn btn-outline-success"
                        data-filter="activa">
                    <i class="bi bi-check-circle me-1"></i>
                    Activas
                </button>

                <button type="button"
                        class="btn btn-outline-danger"
                        data-filter="expirada">
                    <i class="bi bi-x-circle me-1"></i>
                    Expiradas
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
                            <th>Título</th>
                            <th>Vigencia</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php require_once __DIR__ . '/../../helpers/format.php' ?>

                        <?php $promociones = $promociones ?? []; ?>

                        <?php if (!empty($promociones)): ?>

                            <?php foreach ($promociones as $pr): ?>

                                <tr data-estado="<?= strtolower($pr['estado']) ?>">

                                    <td>
                                        <div class="fw-semibold">
                                            <?= htmlspecialchars($pr['titulo']) ?>
                                        </div>
                                        <small class="text-muted">
                                            <?= htmlspecialchars($pr['descripcion']) ?>
                                        </small>
                                    </td>

                                    <td>
                                        <span class="d-block">
                                            <?= htmlspecialchars(formatearFecha($pr['fecha_inicio'])) ?>
                                        </span>
                                        <small class="text-muted">
                                            hasta <?= htmlspecialchars(formatearFecha($pr['fecha_fin'])) ?>
                                        </small>
                                    </td>

                                    <td>
                                        <span class="badge 
                                            <?= $pr['estado'] === 'proxima'
                                                ? 'bg-warning'
                                                : ($pr['estado'] === 'activa'
                                                    ? 'bg-success'
                                                    :($pr['estado'] === 'expirada'
                                                        ? 'bg-danger'
                                                        : 'bg-dark')) ?>">
                                            <?= htmlspecialchars($pr['estado']) ?>
                                        </span>
                                    </td>

                                    <td class="text-center">

                                        <div class="btn-group btn-group-sm">

                                            <button class="btn btn-outline-primary btn-update"
                                                    data-id="<?= $pr['id_promocion'] ?>"
                                                    data-controller="Promocion">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <button class="btn btn-outline-danger btn-delete"
                                                    data-id="<?= $pr['id_promocion'] ?>"
                                                    data-controller="Promocion">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </div>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox-fill fs-3 d-block mb-2"></i>
                                    No hay promociones registradas
                                </td>
                            </tr>

                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>