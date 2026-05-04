<div class="modal fade" id="modalPerfil" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header p-0 align-items-center">

                <h4 class="modal-title">Mi Perfil</h4>
                <button type="button" class="btn p-0 text-black ms-auto" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg fs-4"></i>
                </button>

            </div>
            
            <div class="modal-body px-0">
                
                <div class="mb-3">
                    <label class="form-label">Correo electrónico <span class="text-danger">*</span></label>
                    <input type="email" class="form-control mb-1" id="emailPerfil" disabled>
                    <span id="errorEmailPerfil" class="text-danger"></span>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña <span class="text-danger">*</span></label>
                    <input type="text" class="form-control mb-1" id="passwordPerfil" disabled>
                    <span id="errorPasswordPerfil" class="text-danger"></span>
                </div>
            
                <button id="btn-habilitar" class="btn btn-primary w-100 mb-2" onclick="habilitarDatos()">Editar</button>
                <button id="btn-actualizar" class="btn btn-success d-none w-100" onclick="actualizarDatos()">Guardar</button>
            </div>
        </div>
    </div>
</div>
        