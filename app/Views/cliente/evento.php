<?php if (!empty($eventos)): ?>
   <section id="evento-section" class="evento-section py-5">
      <div class="container text-center text-white">
         <h1 class="">PROXIMO EVENTO</h1>

         <div class="row justify-content-center">
         <?php foreach ($eventos as $evento): ?>
               <div class="evento-card col-md-8 p-3 rounded">
                  <div class="row g-0 align-items-center">
                     <div class="col-md-5">
                        <img class="img-fluid rounded"
                           src="../images/evento/<?= $evento['imagen'] ?>" alt="Evento <?= $evento['id_evento'] ?>">
                     </div>
                        
                     <div class="col-md-7 d-flex align-items-center">
                        <div class="card-body text-start w-100 p-3">
                           <h2><?= $evento['nombre'] ?></h2>
                           <p><?= $evento['descripcion'] ?></p>
                           <p><strong>Fecha: </strong><?= $evento['fecha'] ?></p>
                           <p><strong>Hora: </strong><?= $evento['hora'] ?></p>
                           <p><strong>Precio Mesa: </strong><?= $evento['precio_mesa'] ?></p>
                           <button 
                              class="btn btn-reservar"
                              data-id="<?= $evento['id_evento'] ?>"
                              data-nombre="<?= $evento['nombre'] ?>"
                              data-fecha="<?= $evento['fecha'] ?>"
                              data-precio="<?= $evento['precio_mesa'] ?>"
                              data-bs-toggle="modal" 
                              data-bs-target="#reservaModal">
                              Reservar
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         <?php endforeach; ?>
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