<div class="modal fade" id="reservaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reserva tu evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body">
                <div id="step1" class="step">
                    <h6>Inicia sesión</h6>

                    <div class="mb-3">
                        <label class="form-label">Correo electronico</label>
                        <input type="email" class="form-control" id="emailLogin">
                    </div>

                    <hr>

                    <div id="googleBtn" class="google-custom"></div>

                    <button class="btn btn-warning mb-3" onclick="enviarCodigo()">Enviar código</button>
                    
                    <div class="mb-3 d-none" id="bloqueCodigo">
                        <label class="form-label">Código de verificación</label>
                        <input type="text" class="form-control" id="codigo">
                    </div>
                    
                    <button class="btn btn-success d-none mt-2" id="btnValidarCodigo" onclick="validarCodigo()">Validar código</button>
                </div>

                <div id="step2" class="step d-none">
                    <h6>Datos personales</h6>
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
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
                    <h6>Detalles de tu reserva</h6>

                    <div class="mb-3">
                        <label class="form-label">Evento</label>
                        <input type="text" class="form-control" id="eventoNombre" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input class="form-control" id="eventoFecha" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <input class="form-control" id="eventoPrecio" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hora de llegada</label>
                        <input type="time" class="form-control" id="eventoHora">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número de personas</label>
                        <input type="number" class="form-control" id="personas" min="1" max="20">
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="goToStep(2)">Atrás</button>
                        <button type="button" class="btn btn-warning" onclick="guardarDatosReserva()">Siguiente</button>
                    </div>
                </div>
        
                <div id="step4" class="step d-none">
                    <h6>Confirma tu información</h6>
                    <p><strong>Nombre:</strong> <span id="confirmarNombre"></span></p>
                    <p><strong>Correo:</strong> <span id="confirmarEmail"></span></p>
                    <p><strong>Teléfono:</strong> <span id="confirmarTelefono"></span></p>
                    <p><strong>Evento:</strong> <span id="confirmarEvento"></span></p>
                    <p><strong>Fecha:</strong> <span id="confirmarFecha"></span></p>
                    <p><strong>Precio:</strong> <span id="confirmarPrecio"></span></p>
                    <p><strong>Hora:</strong> <span id="confirmarHora"></span></p>
                    <p><strong>Personas:</strong> <span id="confirmarPersonas"></span></p>

                    <button type="button" class="btn btn-secondary" onclick="goToStep(3)">Atrás</button>
                    <button type="button" class="btn btn-warning" onclick="goToStep(5)">Proceder al pago</button>
                </div>
        
                <div id="step5" class="step d-none">
                    <h6>Pago con PayPal</h6>
                    <div id="paypal-button-container"></div>
                    <button type="button" class="btn btn-secondary" onclick="goToStep(4)">Atrás</button>
                </div>
            </div>
        </div>
    </div>
</div>