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

                <button id="btnEnviarCodigo" class="btn btn-primary w-100" onclick="enviarCodigo()">Enviar código</button>
                
                <div class="mt-3 d-none" id="bloqueCodigo">
                    
                    <label class="form-label">Código de verificación</label>
                    <input type="number" class="form-control" id="codigo">
                    <small class="text-muted mt-1">Este código vence en 10 minutos.</small>
                    
                </div>

                <button id="btnValidarCodigo" class="btn btn-success d-none ms-auto mt-3 w-100" onclick="validarCodigo()">Validar código</button>

                <hr>
                
                <div id="google-button" class="mb-3"></div>

            </div>
        </div>
    </div>
</div>