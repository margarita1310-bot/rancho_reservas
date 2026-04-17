<div class="modal fade" id="modalLogin" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header p-0 align-items-center">
                <h4 class="modal-title">Iniciar Sesión</h4>
                <button type="button" class="btn p-0 text-black ms-auto" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg fs-4"></i>
                </button>
            </div>
            
            <div class="modal-body px-0">
                    
                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control mb-1" id="emailLogin" disabled>
                    <span id="errorEmailLogin" class="text-danger"></span>
                </div>

                <button id="enviarCodigoLogin" class="btn btn-primary w-100" onclick="enviarCodigo()">Enviar código</button>
                
                <div class="mt-3 d-none" id="bloqueCodigoLogin">
                    <label class="form-label">Código de verificación</label>
                    <input type="text" maxlength="6" class="form-control mb-1" id="codigoLogin">
                    <small class="text-muted">Este código vence en 10 minutos.</small>
                    <br>
                    <span id="errorCodigoLogin" class="text-danger"></span>
                </div>

                <button id="validarCodigoLogin" class="btn btn-success d-none ms-auto mt-3 w-100" onclick="validarCodigo()">Validar código</button>

                <hr>
                
                <div id="googleLogin" class="mb-3"></div>

            </div>
        </div>
    </div>
</div>