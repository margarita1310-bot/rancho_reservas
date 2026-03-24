<div class="modal fade" id="perfilModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header p-0">

                <h3 class="modal-title">Mi Perfil</h3>
                <button type="button" class="btn p-0 text-black ms-auto" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg fs-3"></i>
                </button>

            </div>
            
            <div class="modal-body px-0">
                
                <div class="mb-3">
                    <label class="form-label">Correo</label>
                    <input type="email" class="form-control" id="clienteEmail" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="clienteNombre">
                </div>

                <div class="mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="clienteTelefono">
                </div>
            
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button class="btn btn-success" onclick="actualizarDatosCliente()">Guardar</button>
            </div>

        </div>
    </div>
</div>
        