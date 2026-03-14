<?php if (!empty($eventos)): ?>
   <section id="evento-section" class="evento-section py-5">
      <div class="container">

         <h2 class="text-center text-white mb-5">PROXIMO EVENTO</h2>

         <div class="row justify-content-center">

         <?php foreach ($eventos as $evento): ?>

               <div class="col-lg-8 mb-4">

                  <div class="evento-card">
                     
                     <div class="row g-0 align-items-center">
                     
                        <div class="col-md-5">
                           <img
                              src="../images/evento/<?= $evento['imagen'] ?>"
                              class="evento-img"
                              alt="Evento <?= $evento['id_evento'] ?>">
                        </div>
                        
                        <div class="col-md-7">
                           
                           <div class="evento-info">
                              <h2><?= $evento['nombre'] ?></h2>
                              <p class="evento-descripcion">
                                 <?= $evento['descripcion'] ?>
                              </p>
                              
                              <div class="evento-detalles">
                                 <span>
                                    <i class="bi bi-calendar me-2"></i>
                                    <?= $evento['fecha'] ?>
                                 </span>
                                 <span>
                                    <i class="bi bi-clock me-2"></i>
                                    <?= $evento['hora'] ?>
                                 </span>
                                 <span class="evento-precio">
                                    <i class="bi bi-currency-dollar me-2"></i>
                                    <?= $evento['precio_mesa'] ?>
                                 </span>
                              </div>
                              
                              <button 
                                 class="btn btn-reservar mt-3"
                                 data-id="<?= $evento['id_evento'] ?>"
                                 data-nombre="<?= $evento['nombre'] ?>"
                                 data-fecha="<?= $evento['fecha'] ?>"
                                 data-precio="<?= $evento['precio_mesa'] ?>"
                                 data-bs-toggle="modal" 
                                 data-bs-target="#reservaModal">
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
<section id="evento-section" class="evento-section py-5">
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