<div class="container">
    <div class="row">
        <div class="col-12">
        <h1><i class="bi bi-boxes"></i> Inventario de Productos</h1>
            <div class="d-flex justify-content-end mb-3">
            </div>
            <div class="clearfix"></div>
            <br>
            <div class="card">
                <div class="card-header">INVENTARIO</div>
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
                        <div class="d-flex justify-content-end mb-3">
                            <?php
                            $px = $page - 1;
                            if ($px > 0) :
                            ?>
                                <a class="btn btn-sm btn-default" href="<?php echo "index.php?view=inventary&limit=$limit&page=" . ($px); ?>"><i class="glyphicon glyphicon-chevron-left"></i> Atras </a>
                            <?php endif; ?>
                            <?php
                            $px = $page + 1;
                            if ($px <= $npaginas) :
                            ?>
                                <a class="btn btn-sm btn-default" href="<?php echo "index.php?view=inventary&limit=$limit&page=" . ($px); ?>">Adelante <i class="glyphicon glyphicon-chevron-right"></i></a>
                            <?php endif; ?>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Nombre</th>
                                        <th>Disponible</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($curr_products as $product) :
                                        $q = OperationData::getQYesF($product->id);
                                    ?>
                                        <tr class="<?php if ($q <= $product->inventary_min / 2) {
                                                        echo "table-danger";
                                                    } elseif ($q <= $product->inventary_min) {
                                                        echo "table-warning";
                                                    } ?>">
                                            <td><?php echo $product->id; ?></td>
                                            <td><?php echo $product->name; ?></td>
                                            <td><?php echo $q; ?></td>
                                            <td style="width:93px;">
                                                <a href="index.php?view=history&product_id=<?php echo $product->id; ?>" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-time"></i> Historial</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mb-3">
                            <?php
                            for ($i = 0; $i < $npaginas; $i++) {
                                echo "<a href='index.php?view=inventary&limit=$limit&page=" . ($i + 1) . "' class='btn btn-default btn-sm'>" . ($i + 1) . "</a> ";
                            }
                            ?>
                        </div>
                        <form class="form-inline">
                            <label for="limit">Limite</label>
                            <input type="hidden" name="view" value="inventary">
                            <input type="number" value=<?php echo $limit ?> name="limit" style="width:60px;" class="form-control">
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
        </div>
    </div>
</div>
