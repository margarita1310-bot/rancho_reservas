<div class="modal fade" id="reservaModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header p-0 align-items-center">

                <h4 class="modal-title">Reserva tu evento</h4>
                <button type="button" class="btn p-0 text-black ms-auto" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg fs-4"></i>
                </button>

            </div>
            
            <div class="modal-body px-0">
        
                <div id="step1" class="step d-none">

                    <h4>Detalles de tu reserva</h4>

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
                        <input type="time" class="form-control" id="eventoHora" min="18:00" max="23:00">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Número de personas</label>
                        <input type="number" class="form-control" id="eventoPersonas" min="1" max="20">

                    </div>

                    <div class="d-flex">
                        <button type="button" class="btn btn-warning ms-auto" onclick="guardarDatosReserva()">Siguiente</button>
                    </div>

                </div>
        
                <div id="step2" class="step d-none">

                    <h6 class="mb-2">
                        <i class="bi bi-check-circle text-success"></i>
                        Confirmar información
                    </h6>

                    <p class="text-muted mb-3">
                        Revisa que tus datos sean correctos antes de continuar.
                    </p>

                    <div class="row g-3">
                        
                    </div>
                    <p><strong>Nombre:</strong> <span id="confirmarNombre"></span></p>
                    <p><strong>Correo:</strong> <span id="confirmarEmail"></span></p>
                    <p><strong>Teléfono:</strong> <span id="confirmarTelefono"></span></p>
                    <p><strong>Evento:</strong> <span id="confirmarEvento"></span></p>
                    <p><strong>Fecha:</strong> <span id="confirmarFecha"></span></p>
                    <p><strong>Precio:</strong> <span id="confirmarPrecio"></span></p>
                    <p><strong>Hora:</strong> <span id="confirmarHora"></span></p>
                    <p><strong>Personas:</strong> <span id="confirmarPersonas"></span></p>

                    
                    <div class="d-flex justify-content-between">

                        <button type="button" class="btn btn-secondary" onclick="goToStep(1)">Atrás</button>
                        <button type="button" class="btn btn-warning" onclick="crearReserva()">Proceder al pago</button>

                    </div>

                </div>
        
                <div id="step3" class="step d-none">

                    <h4>Pago con PayPal</h4>
                    <div id="paypal-button"></div>
                    <button type="button" class="btn btn-secondary" onclick="goToStep(2)">Atrás</button>

                </div>
            </div>
        </div>
    </div>
</div>