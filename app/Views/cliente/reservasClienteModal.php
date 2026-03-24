<div class="modal fade" id="reservasClienteModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header p-0">

                <h3 class="modal-title">Mis Reservas</h3>
                <button type="button" class="btn p-0 text-black ms-auto" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg fs-3"></i>
                </button>

            </div>
            
            <div class="modal-body px-0">
                
                <?php $reservasCliente = $this->obtenerReservas(); ?>

                <?php foreach ($reservasCliente as $rc): ?>

                <div class="card mb-3 shadow-sm">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-1"><?= $rc['evento'] ?></h5>
                            <span class="badge"></span>
                        </div>

                        <p class="mb-1"><strong>Fecha:</strong></p>
                        <p class="mb-1"><strong>Personas:</strong></p>
                        <p class="mb-2"><strong>Total:</strong></p>

                        <div class="d-flex gap-2">
                            <!--Botones de pagar en caso de no se acomplete-->
                        </div>

                    </div>

                </div>

                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>
        