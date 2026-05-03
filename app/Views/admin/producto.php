<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div class="flex-grow-1">
            <h2 class="fw-bold mb-1">
                <i class="bi bi-tag me-2"></i>
                Gestión de Productos
            </h2>
            <p class="text-muted mb-0">
                Administra todos los productos disponibles en el menú. Puedes crear, editar y eliminar elementos, definir precios y descripciones. Así como asignarlos a una categoría específica para mantener una organización clara y atractiva para los clientes.
            </p>
        </div>

        <div class="flex-shrink-0">
            <button class="btn btn-primary d-flex align-items-center gap-2 shadow-sm"
            id="btn-create-producto">
                <i class="bi bi-plus-circle"></i>
                Crear producto
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
                    Todas
                </button>

                <?php $categoriasProductos = $categoriasProductos ?? []; ?>
                <?php foreach ($categoriasProductos as $cp): ?>
                    <button type="button"
                    class="btn btn-outline-warning"
                    data-filter="<?= htmlspecialchars($cp['id_categoria']) ?>">
                        <?= htmlspecialchars($cp['nombre']) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive rounded">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Categoria</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $productos = $productos ?? []; ?>
                        <?php if (!empty($productos)): ?>
                            <?php foreach ($productos as $p): ?>
                                <tr data-estado="<?= strtolower($p['id_categoria']) ?>">
                                    <td>
                                        <div class="fw-semibold">
                                            <?= htmlspecialchars($p['producto']) ?>
                                        </div>

                                        <small class="text-muted">
                                            <?= htmlspecialchars($p['descripcion']) ?>
                                        </small>
                                    </td>

                                    <td>
                                        $<?= htmlspecialchars($p['precio']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($p['categoria']) ?>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary btn-update"
                                            data-id="<?= $p['id_producto'] ?>"
                                            data-controller="Producto"
                                            title="Editar producto">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <button class="btn btn-outline-danger btn-delete"
                                            data-id="<?= $p['id_producto'] ?>"
                                            data-controller="Producto"
                                            title="Borrar producto">
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
                                    No hay productos registrados
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>