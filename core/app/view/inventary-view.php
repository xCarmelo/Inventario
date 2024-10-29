<div class="container">
    <div class="row">
        <div class="col-12">
            <h1><i class="bi bi-boxes"></i> Inventario de Productos</h1>
            <div class="clearfix"></div>
            <br>
            <div class="card">
                <div class="card-header">INVENTARIO</div>

                <?php
                $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                $offset = ($page - 1) * $limit;
                $products = ProductData::getAll();
                $totalProducts = count($products);
                $totalPages = ceil($totalProducts / $limit);
                $curr_products = array_slice($products, $offset, $limit);
                ?>

                <div class="d-flex justify-content-between align-items-center mt-3 ms-3">
                    <div>
                        <form method="get" class="d-inline">
                            <input type="hidden" name="view" value="inventary">
                            <b>Mostrar:</b>
                            <select name="limit" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                                <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10 por página</option>
                                <option value="25" <?php echo $limit == 25 ? 'selected' : ''; ?>>25 por página</option>
                                <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50 por página</option>
                            </select>
                            <b class="me-3">Productos por página</b>
                        </form>
                    </div>
                    <div class="me-3">
                        <span>Estas en la pagina: <?php echo $page; ?> de <?php echo $totalPages; ?></span>
                    </div>
                </div>

                <div class="card-body">
                    <?php if ($totalProducts > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Imagen</th>
                                        <th>Nombre</th>
                                        <th>Disponible</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($curr_products as $product): 
                                        if($product->is_active != 0):?>
                                        <tr class="<?php if (OperationData::getQYesF($product->id) <= $product->inventary_min) echo "table-warning"; ?>">
                                            <td><?php echo $product->id; ?></td>
                                            <td>
                                                <?php if ($product->image): ?>
                                                    <img src="storage/products/<?php echo $product->image; ?>" style="width:64px;" class="custom-modal-trigger">
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $product->name; ?></td>
                                            <td><?php echo OperationData::getQYesF($product->id); ?></td>
                                            <!-- <td style="width:93px;">
                                                <a href="index.php?view=history&product_id=<?php echo $product->id; ?>" class="btn btn-success btn-sm">
                                                    <i class="glyphicon glyphicon-time"></i> Historial
                                                </a>
                                            </td> -->
                                        </tr>
                                    <?php endif; endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación centrada debajo de la tabla -->
                        <div class="d-flex justify-content-center mt-3">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <?php if ($page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="index.php?view=inventary&limit=<?php echo $limit; ?>&page=1">««</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="index.php?view=inventary&limit=<?php echo $limit; ?>&page=<?php echo $page - 1; ?>">‹</a>
                                        </li>
                                    <?php endif; ?>

                                    <?php
                                    $startPage = max(1, $page - 2);
                                    $endPage = min($totalPages, $page + 2);
                                    for ($i = $startPage; $i <= $endPage; $i++): ?>
                                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                            <a class="page-link" href="index.php?view=inventary&limit=<?php echo $limit; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($page < $totalPages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="index.php?view=inventary&limit=<?php echo $limit; ?>&page=<?php echo $page + 1; ?>">›</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="index.php?view=inventary&limit=<?php echo $limit; ?>&page=<?php echo $totalPages; ?>">»»</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>

                    <?php else: ?>
                        <div class="jumbotron">
                            <h2>No hay productos</h2>
                            <p>No se han agregado productos a la base de datos, puedes agregar uno dando click en el botón <b>"Agregar Producto"</b>.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Ampliar Imágenes -->
<div class="modal fade custom-img-modal" id="imgModal" tabindex="-1" aria-labelledby="imgModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img id="modalImage" src="" alt="Imagen del producto" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para el Modal de Imágenes -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    var images = document.getElementsByClassName('custom-modal-trigger');
    var modal = new bootstrap.Modal(document.getElementById('imgModal'));
    var modalImage = document.getElementById('modalImage');

    for (var i = 0; i < images.length; i++) {
        images[i].addEventListener('mouseover', function() {
            modalImage.src = this.src;
            modal.show();
        });

        images[i].addEventListener('mouseleave', function() {
            modal.hide();
        });
    }
});
</script>
