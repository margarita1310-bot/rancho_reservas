<?php
$eventosConImagen = array_filter($eventosFinalizados, function($ef) {
    return !empty($ef['imagenes']);
});

$totalEventos = count($eventosConImagen);
$usarCarrusel = $totalEventos > 3;
?>

<section id="galeria-section" class="galeria-section py-4">
    <?php if (!empty($eventosConImagen)): ?>
        <div class="container">
            <h2 class="text-center mb-4">Galeria de eventos</h2>
            <?php if (!$usarCarrusel): ?>
                <div class="row g-4 d-none d-md-flex">
                    <?php foreach ($eventosConImagen as $ef): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="evento-finalizado-card">
                                <div class="evento-finalizado-grid">
                                    <?php foreach (array_slice($ef['imagenes'], 0, 6) as $img): ?>
                                        <div class="grid-img">
                                            <img src="<?= $img['url'] ?>" alt="evento">
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="evento-finalizado-overlay">
                                    <h4><?= htmlspecialchars($ef['nombre']) ?></h4>
                                    <p><?= htmlspecialchars($ef['descripcion']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div id="carouselEventos" class="carousel slide <?= $usarCarrusel ? '' : 'd-md-none' ?>">
                <div class="carousel-inner">
                    <?php foreach ($eventosConImagen as $index => $ef): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <div class="p-2">
                                <div class="evento-finalizado-card">
                                    <div class="evento-finalizado-grid">
                                        <?php foreach (array_slice($ef['imagenes'], 0, 4) as $img): ?>
                                            <div class="grid-img">
                                                <img src="<?= $img['url'] ?>" alt="evento">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <div class="evento-finalizado-overlay">
                                        <h4><?= htmlspecialchars($ef['nombre']) ?></h4>
                                        <p><?= htmlspecialchars($ef['descripcion']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button"
                data-bs-target="#carouselEventos" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>

                <button class="carousel-control-next" type="button"
                data-bs-target="#carouselEventos" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    <?php else: ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center text-white">
                    <h2>No hay eventos finalizados</h2>
                    <p>Pronto tendremos nuevos eventos para ti. ¡Mantente atento!</p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>