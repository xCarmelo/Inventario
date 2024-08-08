<?php
if (isset($_GET["product_id"])):
    $product = ProductData::getById($_GET["product_id"]);
    $operations = OperationData::getAllByProductId($product->id);
?>
<div class="row">
    <div class="col-md-12">
        <h1><?php echo $product->name; ?> <small>Historial</small></h1>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <?php $itotal = OperationData::GetInputQYesF($product->id); ?>
    </div>
    <div class="col-md-4">
        <?php $total = OperationData::GetQYesF($product->id); ?>
    </div>
    <div class="col-md-4">
        <?php $ototal = -1 * OperationData::GetOutputQYesF($product->id); ?>
    </div>
</div>

<div class="row">
    <div class="col-6 col-lg-4">
        <div class="card">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-primary text-white p-3 me-3">
                    <svg class="icon icon-xl">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-truck"></use>
                    </svg>
                </div>
                <div>
                    <div class="fs-6 fw-semibold text-primary"><?php echo $itotal; ?></div>
                    <div class="text-medium-emphasis text-uppercase fw-semibold small">ENTRADAS</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-4">
        <div class="card">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-success text-white p-3 me-3">
                    <svg class="icon icon-xl">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-check"></use>
                    </svg>
                </div>
                <div>
                    <div class="fs-6 fw-semibold text-success"><?php echo $total; ?></div>
                    <div class="text-medium-emphasis text-uppercase fw-semibold small">DISPONIBLE</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-4">
        <div class="card">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-warning text-white p-3 me-3">
                    <svg class="icon icon-xl">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-cart"></use>
                    </svg>
                </div>
                <div>
                    <div class="fs-6 fw-semibold text-warning"><?php echo $ototal; ?></div>
                    <div class="text-medium-emphasis text-uppercase fw-semibold small">SALIDAS</div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                HISTORIAL
            </div>
            <div class="card-body">
                <?php if (count($operations) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Cantidad</th>
                                    <th>Tipo</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($operations as $operation): ?>
                                    <tr>
                                        <td></td>
                                        <td><?php echo $operation->q; ?></td>
                                        <td><?php echo $operation->getOperationType()->name; ?></td>
                                        <td><?php echo $operation->created_at; ?></td>
                                        <td style="width:40px;">
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-<?php echo $operation->id; ?>"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteModal-<?php echo $operation->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que quieres eliminar esta operación?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <a href="index.php?view=deleteoperation&ref=history&pid=<?php echo $operation->product_id; ?>&opid=<?php echo $operation->id; ?>" class="btn btn-danger">Eliminar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="alert alert-danger">No hay operaciones</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>
