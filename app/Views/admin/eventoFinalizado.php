<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-calendar2-week me-2"></i>
                Galeria de Eventos
            </h2>
            <p class="text-muted mb-0">
                Gestiona el historial de eventos ya realizados. Aquí puedes subir fotografías, agregar descripciones y conservar un registro visual que ayude a promocionar futuras actividades y mostrar la experiencia ofrecida a los clientes.
            </p>
        </div>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive rounded">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Imagenes</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $eventosFinalizados = $eventosFinalizados ?? []; ?>
                        <?php if (!empty($eventosFinalizados)): ?>
                            <?php foreach ($eventosFinalizados as $ef): ?>
                                <tr>
                                    <td>
                                        <div class="fw-semibold">
                                            <?= htmlspecialchars($ef['nombre']) ?>
                                        </div>
                                        
                                        <small class="text-muted">
                                            <?= htmlspecialchars($ef['descripcion']) ?>
                                        </small>
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <?php if (!empty($ef['imagenes'])): ?>
                                                <?php foreach ($ef['imagenes'] as $img): ?>
                                                    <div class="mini-img position-relative">
                                                        <img src="<?= htmlspecialchars($img['url']) ?>" alt="img-evento">
                                                        <button class="btn btn-danger btn-sm btn-delete-img"
                                                        data-id="<?= $img['id'] ?>"
                                                        data-evento="<?= $ef['id_evento'] ?>">
                                                            <i class="bi bi-trash p-0"></i>
                                                        </button>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="text-muted small">Sin imágenes</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary btn-add-images"
                                            data-id="<?= $ef['id_evento'] ?>"
                                            data-total="<?= count($ef['imagenes']) ?>"
                                            title="Agregar imagenes del evento">
                                                <i class="bi bi-images"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox-fill fs-3 d-block mb-2"></i>
                                    No hay eventos finalizados
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>