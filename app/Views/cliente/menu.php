<?php if (!empty($productos)): ?>
    <section id="menu-section" class="menu-section py-4">
        <div class="container">
            <h2 class="text-center mb-4">Nuestro Menú</h2>
            
            <div class="menu-card p-4 rounded">
                <ul class="nav nav-pills justify-content-center mb-4">
                    <li class="nav-item">
                        <button class="nav-link active" data-filter="todos">
                            Todos
                        </button>
                    </li>
                    
                    <?php foreach ($categoriasProductos as $cp): ?>
                        <li class="nav-item">
                            <button class="nav-link" data-filter="<?= htmlspecialchars($cp['id_categoria']) ?>">
                                <?= htmlspecialchars($cp['nombre']) ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
                
                <div class="row">
                    <?php foreach ($productos as $p): ?>
                        <div class="col-md-4 mb-4 producto-item"
                        data-categoria="<?= $p['id_categoria'] ?>">
                            <div class="p-3 rounded h-100">
                                <h4><?= htmlspecialchars($p['producto']) ?></h4>
                                <p><?= htmlspecialchars($p['descripcion']) ?></p>
                                <p class="lead">$<?= htmlspecialchars($p['precio']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <section id="menu-section" class="menu-section py-4">
      <div class="container">
         <div class="row justify-content-center">
            <div class="col-md-6 text-center text-black">
               <h2>No hay productos disponibles</h2>
               <p>Pronto tendremos nuevos productos para ti. ¡Mantente atento!</p>
            </div>
         </div>
      </div>
   </section>
<?php endif; ?>