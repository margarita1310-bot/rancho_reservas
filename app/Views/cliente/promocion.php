<?php if (!empty($promociones)): ?>
    <section id="promocion-section" class="promocion-section py-5">
        <div class="container text-center text-black">
            <h1 class="">PROMOCIONES</h1>
            
            <div class="row justify-content-center">
                <?php foreach ($promociones as $promocion): ?>
                    <div class="promocion-card col-md-4 p-3 rounded">
                        <img class="img-fluid rounded" 
                            src="../images/promocion/<?php echo $promocion['imagen']; ?>" 
                            alt="Promoción <?php echo $promocion['id_promocion']; ?>">
                        <h2><?php echo $promocion['titulo']; ?></h2>
                        <p><?php echo $promocion['descripcion']; ?></p>
                        <p><?php echo $promocion['fecha_inicio']; ?></p>
                        <p><?php echo $promocion['fecha_fin']; ?></p>
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