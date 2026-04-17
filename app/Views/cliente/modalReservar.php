<div class="modal fade" id="modalReservar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header p-0 align-items-center">
                <h4 class="modal-title">Reserva tu evento</h4>
                <button type="button" class="btn p-0 text-black ms-auto" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg fs-4"></i>
                </button>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 px-3">

                <div class="d-flex flex-column align-items-center">
                    <div class="step-indicator active" id="indicator1">1</div>
                    <small class="text-muted mt-2">Detalles</small>
                </div>

                <div class="d-flex flex-column align-items-center">
                    <div class="step-indicator" id="indicator2">2</div>
                    <small class="text-muted mt-2">Confirmar</small>
                </div>

                <div class="d-flex flex-column align-items-center">
                    <div class="step-indicator" id="indicator3">3</div>
                    <small class="text-muted mt-2">Pago</small>
                </div>

            </div>
            
            <div class="modal-body px-0">
                <div id="step1" class="step d-none">

                    <div class="mb-3">
                        <label class="form-label">Evento</label>
                        <input type="text" class="form-control" id="nombreEvento" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input class="form-control" id="fechaEvento" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <input class="form-control" id="precioEvento" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hora de llegada <span class="text-danger">*</span></label>
                        <input type="time" class="form-control mb-1" id="horaEvento">
                        <small id="info-hora" class="text-muted"></small>
                        <br>
                        <span id="errorHoraEvento" class="text-danger"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Número de personas <span class="text-danger">*</span></label>
                        <input type="number" class="form-control mb-1" id="personasEvento" min="1" max="20" step="1" inputmode="numeric" autocomplete="off">
                        <small id="info-personas" class="text-muted"></small>
                        <br>
                        <span id="errorPersonasEvento" class="text-danger"></span>
                    </div>

                    <button type="button" class="btn btn-primary w-100" onclick="guardarDatosReserva()">Siguiente</button>

                </div>
        
                <div id="step2" class="step d-none">
                    <div class="body-datos p-2 border rounded">

                        <p class="fw-bold mb-3 text-center">
                            Revisa que tus datos sean correctos antes de continuar.
                        </p>

                        <div class="row mb-3">
                            <div class="col-5 fw-semibold">Nombre:</div>
                            <div class="col-7" id="confirmarNombre"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-5 fw-semibold">Correo electronico:</div>
                            <div class="col-7 text-break" id="confirmarEmail"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-5 fw-semibold">Teléfono:</div>
                            <div class="col-7" id="confirmarTelefono"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-5 fw-semibold">Evento:</div>
                            <div class="col-7" id="confirmarEvento"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-5 fw-semibold">Fecha:</div>
                            <div class="col-7" id="confirmarFecha"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-5 fw-semibold">Precio:</div>
                            <div class="col-7" id="confirmarPrecio"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-5 fw-semibold">Hora:</div>
                            <div class="col-7" id="confirmarHora"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-5 fw-semibold">Personas:</div>
                            <div class="col-7" id="confirmarPersonas"></div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <button type="button" class="btn btn-outline-secondary" onclick="goToStep(1)">Atrás</button>
                        <button id="crear-reserva" type="button" class="btn btn-primary" onclick="crearReserva()">Proceder al pago</button>
                    </div>

                    <small id="error-reserva" class="text-danger"></small>

                </div>
        
                <div id="step3" class="step d-none">

                    <div id="paypal-button" class="mb-3"></div>
                    <button type="button" class="btn btn-outline-secondary" onclick="goToStep(2)">Atrás</button>

                </div>
            </div>
        </div>
    </div>
</div>