<?php
$found = false;
$products = ProductData::getAll();
$products_array = array();
foreach ($products as $product) {
    $q = OperationData::getQYesF($product->id);
    if ($q <= $product->inventary_min) {
        $products_array[] = $product;
    }
}

$totalProducts = count($products);
$totalClients = count(PersonData::getClients());
$totalProviders = count(PersonData::getProviders());
$totalCategories = count(CategoryData::getAll());
?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1>Artículos Religiosos</h1>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary text-white me-3 d-flex justify-content-center align-items-center rounded-circle"
                         style="width: 50px; height: 50px;">
                        <i class="bi bi-box fs-3"></i>
                    </div>
                    <div>
                        <div class="fs-6 fw-semibold text-primary"><?php echo $totalProducts; ?></div>
                        <div class="text-medium-emphasis text-uppercase fw-semibold small">PRODUCTOS</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a class="btn-block text-primary" href="./?view=products">
                        <span class="small fw-semibold">IR A PRODUCTOS</span>
                        <i class="bi bi-chevron-right fs-5"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-info text-white me-3 d-flex justify-content-center align-items-center rounded-circle"
                         style="width: 50px; height: 50px;">
                        <i class="bi bi-people fs-3"></i>
                    </div>
                    <div>
                        <div class="fs-6 fw-semibold text-info"><?php echo $totalClients; ?></div>
                        <div class="text-medium-emphasis text-uppercase fw-semibold small">CLIENTES</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a class="btn-block text-info" href="./?view=clients">
                        <span class="small fw-semibold">IR A CLIENTES</span>
                        <i class="bi bi-chevron-right fs-5"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-warning text-white me-3 d-flex justify-content-center align-items-center rounded-circle"
                         style="width: 50px; height: 50px;">
                        <i class="bi bi-truck fs-3"></i>
                    </div>
                    <div>
                        <div class="fs-6 fw-semibold text-warning"><?php echo $totalProviders; ?></div>
                        <div class="text-medium-emphasis text-uppercase fw-semibold small">PROVEEDORES</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a class="btn-block text-warning" href="./?view=providers">
                        <span class="small fw-semibold">IR A PROVEEDORES</span>
                        <i class="bi bi-chevron-right fs-5"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-danger text-white me-3 d-flex justify-content-center align-items-center rounded-circle"
                         style="width: 50px; height: 50px;">
                        <i class="bi bi-tag fs-3"></i>
                    </div>
                    <div>
                        <div class="fs-6 fw-semibold text-danger"><?php echo $totalCategories; ?></div>
                        <div class="text-medium-emphasis text-uppercase fw-semibold small">CATEGORIAS</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a class="btn-block text-danger" href="./?view=categories">
                        <span class="small fw-semibold">IR A CATEGORIAS</span>
                        <i class="bi bi-chevron-right fs-5"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">ALERTAS DE INVENTARIO</div>
                <div class="card-body">
                    <?php
                    if (count($products_array) > 0) { ?>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <th>Código</th>
                                <th>Nombre del producto</th>
                                <th>Descripción</th>
                                <th>En Stock</th>
                                <th></th>
                                </thead>
                                <?php
                                foreach ($products_array as $product):
                                    $q = OperationData::getQYesF($product->id);
                                    ?>
                                    <tr class="<?php if ($q == 0) {
                                        echo "table-danger";
                                    } else if ($q <= $product->inventary_min / 2) {
                                        echo "table-danger";
                                    } else if ($q <= $product->inventary_min) {
                                        echo "table-warning";
                                    } ?>">
                                        <td><?php echo $product->id; ?></td>
                                        <td><?php echo $product->name; ?></td>
                                        <td><?php echo $product->description; ?></td>
                                        <td><?php echo $q; ?></td>
                                        <td>
                                        <?php
                                          if ($q == 0) {
                                              echo "<span class='badge text-danger fw-bold fs-6'>No hay existencias.</span>";
                                          } else if ($q <= $product->inventary_min / 2) {
                                              echo "<span class='badge text-danger fw-bold fs-6'>Quedan muy pocas existencias.</span>";
                                          } else if ($q <= $product->inventary_min) {
                                              echo "<span class='badge text-success fw-bold fs-6'>Quedan pocas existencias.</span>";
                                          }
                                        ?>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                                ?>
                            </table>
                        </div>

                        <div class="clearfix"></div>

                    <?php
                    } else {
                        ?>
                        <div class="p-5 mb-4 bg-light rounded-3">
                            <h2>No hay alertas</h2>
                            <p>Por el momento no hay alertas de inventario, estas se muestran cuando el inventario ha
                                alcanzado el nivel mínimo.</p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

