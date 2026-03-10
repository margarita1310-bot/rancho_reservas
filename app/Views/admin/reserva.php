<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-journal-check me-2"></i>
                Panel de Reservas
            </h2>
            <p class="text-muted mb-0">
                Consulta y administra las reservaciones
            </p>
        </div>

        <!-- Filtro por fecha -->
        <div class="d-flex align-items-center gap-2">

            <label for="filtro-fecha-reserva" class="form-label mb-0 fw-semibold">
                <i class="bi bi-calendar-event me-1"></i>
                Fecha:
            </label>

            <input type="date"
                   id="filtro-fecha-reserva"
                   class="form-control form-control-sm"
                   style="max-width: 180px;">

        </div>

    </div>

    <!-- Alerta -->
    <div id="alerta-sin-disponibilidad"
         class="alert alert-warning d-none shadow-sm"
         role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        No hay disponibilidad configurada para esta fecha.
        Configura la disponibilidad primero.
    </div>

    <!-- Tabla -->
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive ronded">
                <table class="table table-hover align-middle mb-0"
                       id="tabla-reservas">

                    <thead class="table-light">
                        <tr>
                            <th>Mesa</th>
                            <th>Folio</th>
                            <th>Cliente</th>
                            <th>Hora</th>
                            <th>Personas</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- Se llena dinámicamente -->
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>