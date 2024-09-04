<div class="container">
    <div class="row">
        <div class="col-12">
            <h1><i class="bi bi-cart"></i> COMPRAS</h1>
            <div class="clearfix"></div>
            <div class="card mt-5">
                <div class="card-header">
                    COMPRAS
                </div>
                <div class="card-body">

                    <?php
                    $products = SellData::getRes();

                    if (count($products) > 0) {
                    ?>
                    <div class="table-responsive"> 
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Producto</th>
                                    <th>Total</th>
                                    <th>Fecha</th>
                                    <?php if($_SESSION['is_admin'] === 1): ?>
                                    <th></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $sell): ?>
                                <tr>
                                    <td style="width:30px;"><a href="index.php?view=onere&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-link"><i class="bi bi-eye"></i></a></td>
                                    <td>
                                        <?php
                                        $operations = OperationData::getAllProductsBySellId($sell->id);
                                        echo count($operations);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $total = 0;
                                        foreach ($operations as $operation) {
                                            $product = $operation->getProduct();
                                            $total += $operation->q * $product->price_in;
                                        }
                                        echo "<b>C$ " . number_format($total) . "</b>";
                                        ?>
                                    </td>
                                    <td><?php echo $sell->created_at; ?></td>
                                    
                                    <?php if ($_SESSION['is_admin'] === 1):?>
                                    <td style="width:30px;">
                                        <button class="btn btn-xs btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-<?php echo $sell->id; ?>"><i class="bi bi-trash"></i></button>
                                    </td>
                                    <?php endif;?>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="deleteModal-<?php echo $sell->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de que quieres eliminar esta compra?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <a href="index.php?view=delre&id=<?php echo $sell->id; ?>" class="btn btn-danger">Eliminar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php
                    } else {
                    ?>
                    <div class="jumbotron">
                        <h2>No hay datos</h2>
                        <p>No se ha realizado ninguna operación.</p>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>