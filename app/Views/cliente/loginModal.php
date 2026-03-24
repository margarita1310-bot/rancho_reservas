<div class="modal fade" id="loginModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header p-0 align-items-center">

                <h3 class="modal-title">Iniciar Sesión</h3>

                <button type="button" class="btn p-0 text-black ms-auto" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg fs-3"></i>
                </button>

            </div>
            
            <div class="modal-body px-0">
                    
                <div class="mb-3">

                    <label class="form-label">Correo electronico</label>
                    <input type="email" class="form-control" id="emailLogin">
                
                </div>

                <hr>

                <div id="google-button" class="mb-3"></div>

                <button class="btn btn-warning mb-3" onclick="enviarCodigo()">Enviar código</button>
                    
                <div class="mb-3 d-none" id="bloqueCodigo">
                        
                    <label class="form-label">Código de verificación</label>
                    <input type="text" class="form-control" id="codigo">
                    <small class="text-muted mt-2">Este código vence en 10 minutos.</small>
                
                </div>
                    
                <button class="btn btn-success d-none mt-2" id="btnValidarCodigo" onclick="validarCodigo()">Validar código</button>
            
            </div>
        </div>
    </div>
</div>