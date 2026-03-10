<?php if (!empty($promociones)): ?>
    <section id="promocion-section" class="promocion-section py-5">
        <div class="container">
            <h1 class="text-center text-black mb-5">PROMOCIONES</h1>
            
            <div class="row g-4">
                <?php foreach ($promociones as $promocion): ?>
                    <div class="col-md-4">
                    <div class="card promocion-card h-100 shadow-sm">
                        <img class="card-img-top" 
                            src="../images/promocion/<?php echo $promocion['imagen']; ?>" 
                            alt="Promoción <?php echo $promocion['id_promocion']; ?>">
                        <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $promocion['titulo']; ?></h5>
                        <p class="card-text"><?php echo $promocion['descripcion']; ?></p>
                        <div class="promocion-fechas">
                            <small>
                                <?php echo $promocion['fecha_inicio']; ?>
                                -
                                <?php echo $promocion['fecha_fin']; ?>
                            </small>
                        </div>
                    </div>
                    </div>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php else: ?>
<section id="promocion-section" class=" promocion-section py-5">
    <div class="grid-section text-black">
        <div class="container">
            <div class="row text-center">
                <h2>No hay promociones disponibles</h2>
                <p>Pronto tendremos nuevas ofertas para ti. ¡Mantente atento!</p>
            </div>
         </div>
      </div>
   </div>
</section>
<?php endif; ?>