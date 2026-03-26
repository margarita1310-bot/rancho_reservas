<div class="modal fade" id="loginModal" tabindex="-1">

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

                    <label class="form-label">Correo electronico</label>
                    <input type="email" class="form-control" id="emailLogin">
                
                </div>

                <hr>

                <div id="google-button" class="mb-3"></div>

                <div class="d-flex">
                    <button class="btn btn-warning ms-auto" onclick="enviarCodigo()">Enviar código</button>
                </div>

                <div class="mt-3 d-none" id="bloqueCodigo">
                        
                    <label class="form-label">Código de verificación</label>
                    <input type="text" class="form-control" id="codigo">
                    <small class="text-muted">Este código vence en 10 minutos.</small>
                
                </div>

                <div class="d-flex">
                    <button class="btn btn-success d-none ms-auto mt-2" id="btnValidarCodigo" onclick="validarCodigo()">Validar código</button>
                </div>
            </div>
        </div>
    </div>
</div>