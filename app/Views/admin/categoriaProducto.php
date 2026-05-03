<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div class="flex-grow-1">
            <h2 class="fw-bold mb-1">
                <i class="bi bi-tag me-2"></i>
                Categorías del Menú
            </h2>
            <p class="text-muted mb-0">
                Organiza los productos en diferentes categorías como bebidas, alimentos o promociones especiales. Desde aquí puedes crear, editar o eliminar categorías para estructurar el menú de forma clara y facilitar la navegación del cliente.
            </p>
        </div>

        <div class="flex-shrink-0">
            <button class="btn btn-primary d-flex align-items-center gap-2 shadow-sm"
            id="btn-create-categoriaProducto" >
                <i class="bi bi-plus-circle"></i>
                Crear categoría
            </button>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive rounded">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Categoría</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $categoriasProductos = $categoriasProductos ?? []; ?>
                        <?php if (!empty($categoriasProductos)): ?>
                            <?php foreach ($categoriasProductos as $cp): ?>
                                <tr>
                                    <td>
                                        <div class="fw-semibold">
                                            <?= htmlspecialchars($cp['nombre']) ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <button class="btn btn-outline-danger btn-delete"
                                        data-id="<?= $cp['id_categoria'] ?>"
                                        data-controller="CategoriaProducto"
                                        title="Borrar categoría">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox-fill fs-3 d-block mb-2"></i>
                                    No hay categorias registradas
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>