<div class="modal fade" id="loginModal" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header p-0 align-items-center">
                <h3 class="modal-title">Iniciar Sesión</h3>
                <button type="button" class="btn p-0 text-black ms-auto" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg fs-3"></i>
                </button>
            </div>
            
            <div class="modal-body px-0">
                <div id="step1" class="step">

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
                    </div>
                    
                    <button class="btn btn-success d-none mt-2" id="btnValidarCodigo" onclick="validarCodigo()">Validar código</button>
                </div>

                <div id="step2" class="step d-none">
                    <h4>Datos personales</h4>
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Nombre legal</label>
                            <input type="text" class="form-control" id="nombre">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono">
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" onclick="goToStep(1)">Atrás</button>
                            <button type="button" class="btn btn-warning" onclick="guardarDatosCliente()">Siguiente</button>
                        </div>
                    </form>
                </div>

                <div id="step3" class="step d-none">
                    <p>Login exitoso</p>
                </div>
            </div>
        </div>
    </div>
</div>