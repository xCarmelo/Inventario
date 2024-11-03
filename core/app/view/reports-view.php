<?php
$products = ProductData::getAll();
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : "";

// Determinar si se debe cargar todos los registros o filtrar por fechas y producto
if (isset($_POST['option']) && $_POST['option'] == 'all') {
    $operations = OperationData::getAllByOperations();
} elseif (isset($_GET["sd"]) && isset($_GET["ed"]) && $_GET["sd"] != "" && $_GET["ed"] != "") {
    // Cargar operaciones filtradas por fecha y producto
    if ($product_id == "") {
        $operations = OperationData::getAllByDateOfficial($_GET["sd"], $_GET["ed"]);
    } else {
        $operations = OperationData::getAllByDateOfficialBP($product_id, $_GET["sd"], $_GET["ed"]);
    }
} else {
    // Cargar todos los registros por defecto
    $operations = OperationData::getAllByOperations(); 
}

// Paginación
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
$totalOperations = count($operations);
$totalPages = ceil($totalOperations / $limit);
$offset = ($page - 1) * $limit;
$curr_operations = array_slice($operations, $offset, $limit);
?>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1><i class="bi bi-file-earmark-bar-graph"></i> Reporte de Movimientos</h1>

                <div class="row">
                    <div class="col-md-10">
                        <form class="mt-5" id="salesForm">
                            <input type="hidden" name="view" value="reports">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label for="startDate" class="form-label">Productos</label>
                                    <select name="product_id" class="form-control">
                                        <option value="">-- TODOS --</option>
                                        <?php foreach($products as $p): ?>
                                        <option value="<?php echo $p->id; ?>" <?php echo ($product_id == $p->id) ? 'selected' : ''; ?>>
                                            <?php echo $p->name; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label for="startDate" class="form-label">Fecha Inicial</label>
                                    <input type="date" name="sd" value="<?php if(isset($_GET["sd"])) { echo $_GET["sd"]; } ?>" class="form-control">
                                </div>
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label for="startDate" class="form-label">Fecha Final</label>
                                    <input type="date" name="ed" value="<?php if(isset($_GET["ed"])) { echo $_GET["ed"]; } ?>" class="form-control">
                                </div>
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label for="startDate" class="form-label">.</label>
                                    <input type="button " id="processButton" class="btn btn-success btn-block w-100 text-white" value="Procesar">
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Botón de refresh -->
                    <div class="col-md-2">
                    <label for="startDate d-none d-sm-block" class="form-label" style="color:#ebedef;">.</label><br>
                    <label for="startDate d-none d-sm-block" class="form-label" style="color:#ebedef;">.</label>
                        <form class="mt-3" action="index.php?view=reports" method="post">
                            <input type="hidden" name="option" value="all">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-arrow-clockwise"></i> Refresh
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <br>
        
        <div class="row"> 
            <div class="col-12">
                <div class="card">
                    <div class="card-header">MOVIMIENTOS</div> 
                    <div class="card-body">
                        <?php if (count($curr_operations) > 0): ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <form method="GET" action="index.php">
                                        <input type="hidden" name="view" value="reports">
                                        <input type="hidden" name="sd" value="<?php echo $_GET['sd'] ?? ''; ?>">
                                        <input type="hidden" name="ed" value="<?php echo $_GET['ed'] ?? ''; ?>">
                                        <label for="limit">Mostrar </label>
                                        <select name="limit" id="limit" onchange="this.form.submit()">
                                            <option value="5" <?php echo ($limit == 5) ? 'selected' : ''; ?>>5</option>
                                            <option value="10" <?php echo ($limit == 10) ? 'selected' : ''; ?>>10</option>
                                            <option value="20" <?php echo ($limit == 20) ? 'selected' : ''; ?>>20</option>
                                            <option value="50" <?php echo ($limit == 50) ? 'selected' : ''; ?>>50</option>
                                        </select> operaciones por página
                                    </form>
                                </div>
                                <div>
                                    <span>Estás en la página <?php echo $page; ?> de <?php echo $totalPages; ?></span>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Id</th>
                                            <th>Producto</th>
                                            <th>Descripción</th>
                                            <th>Cantidad</th>
                                            <th>Operación</th>
                                            <th>Motivo</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($curr_operations as $operation): ?>
                                            <tr>
                                                <td><?php echo $operation->id; ?></td> 
                                                <td><?php echo $operation->getProduct()->name; ?></td>
                                                <td><?php echo $operation->getProduct()->description; ?></td>
                                                <td><?php echo $operation->q; ?></td>
                                                <td><?php echo $operation->getOperationType()->name; ?></td>
                                                <td><?php
                                                    if($operation->operation_type_id == 4) echo $operation->reason_for_return; 
                                                    if($operation->operation_type_id == 3) echo $operation->reason;
                                                    ?></td>
                                                <td><?php echo $operation->created_at; ?></td>  
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <?php if ($page > 1): ?>
                                            <li class="page-item"><a class="page-link" href="index.php?view=reports&limit=<?php echo $limit; ?>&page=1">««</a></li>
                                            <li class="page-item"><a class="page-link" href="index.php?view=reports&limit=<?php echo $limit; ?>&page=<?php echo $page - 1; ?>">‹</a></li>
                                        <?php endif; ?>
                                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                                <a class="page-link" href="index.php?view=reports&limit=<?php echo $limit; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <?php if ($page < $totalPages): ?>
                                            <li class="page-item"><a class="page-link" href="index.php?view=reports&limit=<?php echo $limit; ?>&page=<?php echo $page + 1; ?>">›</a></li>
                                            <li class="page-item"><a class="page-link" href="index.php?view=reports&limit=<?php echo $limit; ?>&page=<?php echo $totalPages; ?>">»»</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">No hay operaciones para mostrar.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Modal para advertir sobre fechas vacías -->
<div class="modal fade" id="dateWarningModal" tabindex="-1" aria-labelledby="dateWarningModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dateWarningModalLabel">Advertencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Debes rellenar ambas fechas antes de procesar.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
     $(document).ready(function() {
    //codigo para validar que las fechas esten llenas 
    $('#processButton').on('click', function() {
            // Obtener los valores de las fechas
            var startDate = $('input[name="sd"]').val();
            var endDate = $('input[name="ed"]').val();

            // Validar si las fechas están vacías
            if (!startDate || !endDate) {
                // Mostrar el modal de advertencia
                $('#dateWarningModal').modal('show');
            } else {
                // Si las fechas son válidas, enviar el formulario
                $('#salesForm').submit();
            }
        });
    });

</script>
