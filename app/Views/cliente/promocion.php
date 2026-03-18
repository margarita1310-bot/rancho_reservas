<?php require_once __DIR__ . '/../../helpers/format.php' ?>

<?php if (!empty($promociones)): ?>

    <section id="promocion-section" class="promocion-section py-4">

        <div class="container">
            
            <h2 class="text-center mb-4">Promociones</h2>
            
            <div class="row g-4 justify-content-center">

                <?php foreach ($promociones as $pr): ?>

                    <div class="col-md-4">

                        <div class="card promocion-card h-100 shadow-sm">

                            <img
                                src="../images/promocion/<?= $pr['imagen'] ?>" 
                                class="card-img-top" 
                                alt="Promoción <?= $pr['id_promocion'] ?>">
                            
                            <div class="card-body text-center">

                                <h4 class="card-title"><?= $pr['titulo'] ?></h4>
                                <p class="card-text"><?= $pr['descripcion'] ?></p>
                                
                                <div class="promocion-fechas">

                                    <small class="text-muted mt-1">
                                        <?= formatearFecha($pr['fecha_inicio']) ?>
                                        -
                                        <?= formatearFecha($pr['fecha_fin']) ?>
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

    <section id="promocion-section" class=" promocion-section py-4">

        <div class="grid-section text-black">

            <div class="container">

                <div class="row text-center">

                    <h2>No hay promociones disponibles</h2>
                    <p>Pronto tendremos nuevas ofertas para ti. ¡Mantente atento!</p>
                
                </div>

            </div>

        </div>

    </section>
    
<?php endif; ?>