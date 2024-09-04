<?php
if (isset($_GET["product_id"])): 
    $product = ProductData::getById($_GET["product_id"]);
    $operations = OperationData::getAllByProductId($product->id);
?>
<div class="row">
    <div class="col-md-12">
        <h1><?php echo $product->name; ?> <small class="text-muted">Historial</small></h1>
    </div>
</div>

<div class="row text-center">
    <div class="col-6 col-lg-4">
        <?php $itotal = OperationData::GetInputQYesF($product->id); ?>
        <div class="card">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-primary text-white p-3 me-3 rounded-circle">
                    <i class="bi bi-box-arrow-in-down fs-3"></i>
                </div>
                <div>
                    <div class="fs-6 fw-bold text-primary"><?php echo $itotal; ?></div>
                    <div class="text-muted text-uppercase fw-semibold small">Entradas</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-4">
        <?php $total = OperationData::GetQYesF($product->id); ?>
        <div class="card">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-success text-white p-3 me-3 rounded-circle">
                    <i class="bi bi-box2 fs-3"></i>
                </div>
                <div>
                    <div class="fs-6 fw-bold text-success"><?php echo $total; ?></div>
                    <div class="text-muted text-uppercase fw-semibold small">Disponible</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-4">
        <?php $ototal = -1 * OperationData::GetOutputQYesF($product->id); ?>
        <div class="card">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-warning text-white p-3 me-3 rounded-circle">
                    <i class="bi bi-box-arrow-in-up fs-3"></i>
                </div>
                <div>
                    <div class="fs-6 fw-bold text-warning"><?php echo $ototal; ?></div>
                    <div class="text-muted text-uppercase fw-semibold small">Salidas</div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Historial
            </div>
            <div class="card-body">
                <?php if (count($operations) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cantidad</th>
                                    <th>Tipo</th>
                                    <th>Fecha</th>
                                    <?php if($_SESSION['is_admin'] === 1): ?>
                                    <th>Acciones</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($operations as $operation): ?>
                                    <tr>
                                        <td><?php echo $operation->id; ?></td>
                                        <td><?php echo $operation->q; ?></td>
                                        <td><?php echo $operation->getOperationType()->name; ?></td>
                                        <td><?php echo $operation->created_at; ?></td>
                                        <?php if($_SESSION['is_admin'] === 1): ?>
                                        <td>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-<?php echo $operation->id; ?>">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </td>
                                        <?php endif; ?>
                                    </tr>

                                    <!-- Modal de Confirmación de Eliminación -->
                                    <div class="modal fade" id="deleteModal-<?php echo $operation->id; ?>" tabindex="-1" aria-labelledby="deleteModalLabel-<?php echo $operation->id; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel-<?php echo $operation->id; ?>">Confirmar Eliminación</h5>
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
