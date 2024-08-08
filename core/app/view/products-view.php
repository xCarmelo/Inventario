<div class="row">
    <div class="col-md-12">

        <h1>Productos</h1>
        <div class="">
            <a href="index.php?view=newproduct" class="btn btn-secondary">Agregar Producto</a>
        </div>
        <br>

        <div class="card">
            <div class="card-header">
                PRODUCTOS
            </div>
            <div class="card-body">

                <?php
                $page = 1;
                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                }
                $limit = 10;
                if (isset($_GET["limit"]) && $_GET["limit"] != "" && $_GET["limit"] != $limit) {
                    $limit = $_GET["limit"];
                }

                $products = ProductData::getAll();
                if (count($products) > 0) {

                    if ($page == 1) {
                        $curr_products = ProductData::getAllByPage($products[0]->id, $limit);
                    } else {
                        $curr_products = ProductData::getAllByPage($products[($page - 1) * $limit]->id, $limit);
                    }
                    $npaginas = floor(count($products) / $limit);
                    $spaginas = count($products) % $limit;

                    if ($spaginas > 0) {
                        $npaginas++;
                    }
                ?>

                <h3>Pagina <?php echo $page . " de " . $npaginas; ?></h3>
                <div class="btn-group pull-right">
                    <?php
                    $px = $page - 1;
                    if ($px > 0):
                    ?>
                    <a class="btn btn-sm btn-secondary" href="<?php echo "index.php?view=products&limit=$limit&page=" . ($px); ?>"><i class="glyphicon glyphicon-chevron-left"></i> Atras </a>
                    <?php endif; ?>

                    <?php
                    $px = $page + 1;
                    if ($px <= $npaginas):
                    ?>
                    <a class="btn btn-sm btn-secondary" href="<?php echo "index.php?view=products&limit=$limit&page=" . ($px); ?>">Adelante <i class="glyphicon glyphicon-chevron-right"></i></a>
                    <?php endif; ?>
                </div>
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Presentacion</th>
                                <th>Activo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($curr_products as $product): ?>
                                <tr>
                                    <td><?php echo $product->barcode; ?></td>
                                    <td>
                                        <?php if ($product->image != ""): ?>
                                            <img src="storage/products/<?php echo $product->image; ?>" style="width:64px;">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $product->name; ?></td>
                                    <td><?php echo $product->presentation; ?></td>
                                    <td><?php if ($product->is_active): ?><i class="fa fa-check"></i><?php endif; ?></td>
                                    <td style="width:120px;">
                                        <div class="btn-group" role="group">
                                            <a href="index.php?view=editproduct&id=<?php echo $product->id; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                            <button class="btn btn-sm btn-danger ms-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-href="index.php?view=delproduct&id=<?php echo $product->id; ?>"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="btn-group pull-right">
                    <?php
                    for ($i = 0; $i < $npaginas; $i++) {
                        echo "<a href='index.php?view=products&limit=$limit&page=" . ($i + 1) . "' class='btn btn-secondary btn-sm'>" . ($i + 1) . "</a> ";
                    }
                    ?>
                </div>
                <form class="form-inline">
                    <label for="limit">Limite</label>
                    <input type="hidden" name="view" value="products">
                    <input type="number" value="<?php echo $limit ?>" name="limit" style="width:60px;" class="form-control">
                </form>

                <div class="clearfix"></div>

                <?php
                } else {
                ?>
                <div class="jumbotron">
                    <h2>No hay productos</h2>
                    <p>No se han agregado productos a la base de datos, puedes agregar uno dando click en el boton <b>"Agregar Producto"</b>.</p>
                </div>
                <?php
                }
                ?>

            </div>
        </div>

        <br><br><br><br><br><br><br><br><br><br>
    </div>
</div>

<!-- Modal de Confirmación para Eliminación -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a id="confirmDeleteBtn" class="btn btn-danger" href="#">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#confirmDeleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var url = button.data('href'); // Extraer la URL del atributo data-href

            var modal = $(this);
            modal.find('#confirmDeleteBtn').attr('href', url);
        });
    });
</script>
