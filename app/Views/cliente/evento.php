<?php require_once ROOT_PATH . '/app/helpers/format.php' ?>

<?php if (!empty($eventos)): ?>
   <section id="evento-section" class="evento-section py-4">
      <div class="container">
         <h2 class="text-center mb-4">Próximo Evento</h2>

         <div class="row justify-content-center">
         <?php foreach ($eventos as $ev): ?>

               <div class="col-lg-8 mb-4">
                  <div class="evento-card">
                     <div class="row g-0 align-items-center">
                        <div class="col-md-5">
                           <img
                              src="../images/evento/<?= $ev['imagen'] ?>"
                              class="evento-img"
                              alt="Evento <?= $ev['id_evento'] ?>">
                        </div>
                        
                        <div class="col-md-7">
                           <div class="evento-info">
                              <h4 class="card-title mb-1"><?= $ev['nombre'] ?></h4>
                              <p class="evento-descripcion">
                                 <?= $ev['descripcion'] ?>
                              </p>
                              
                              <div class="evento-detalles">
                                 <span>
                                    <i class="bi bi-calendar me-2"></i>
                                    <?= formatearFecha($ev['fecha']) ?>
                                 </span>

                                 <span>
                                    <i class="bi bi-clock me-2"></i>
                                    <?= formatearHora($ev['hora']) ?>
                                    -
                                    <?= formatearHora($ev['hora_fin']) ?>
                                 </span>

                                 <span class="evento-precio">
                                    <i class="bi bi-currency-dollar me-2"></i>
                                    <?= $ev['precio_mesa'] ?>
                                 </span>
                              </div>
                              
                              <button
                                 class="btn btn-reservar mt-3"
                                 data-id="<?= $ev['id_evento'] ?>"
                                 data-nombre="<?= $ev['nombre'] ?>"
                                 data-fecha="<?= $ev['fecha'] ?>"
                                 data-hora="<?= $ev['hora'] ?>"
                                 data-hora_fin="<?= $ev['hora_fin'] ?>"
                                 data-precio="<?= $ev['precio_mesa'] ?>"
                                 onclick="botonReservar(this)">
                                 Reservar Mesa
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            <?php endforeach; ?>
         </div>
      </div>
   </section>

<?php else: ?>
   <section id="evento-section" class="evento-section py-4">
      <div class="container">
         <div class="row justify-content-center">
            <div class="col-md-6 text-center text-white">
               <h2>No hay eventos disponibles</h2>
               <p>Pronto tendremos nuevos eventos para ti. ¡Mantente atento!</p>
            </div>
         </div>
      </div>
   </section>
<?php endif; ?>