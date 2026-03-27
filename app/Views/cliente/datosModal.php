<div class="modal fade" id="datosModal" tabindex="-1">
    
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header p-0 align-items-center">

                <h4 class="modal-title">Completa tus datos</h4>
                <button type="button" class="btn p-0 text-black ms-auto" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg fs-4"></i>
                </button>

            </div>

            <div class="modal-body px-0">
                
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre">
                </div>
                    
                <div class="mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono">
                </div>

                <button type="button" class="btn btn-success ms-auto w-100" onclick="guardarDatosCliente()">Guardar</button>
            </div>
        </div>
    </div>
</div>