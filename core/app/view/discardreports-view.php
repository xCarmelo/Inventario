<?php
// Configuración de paginación
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Obtener clientes
$clients = PersonData::getClients(); 

// Obtener la lista de ventas con filtros de cliente y fechas
$operations = array();
if (isset($_GET["sd"]) && isset($_GET["ed"]) && $_GET["sd"] != "" && $_GET["ed"] != "") {
    if (isset($_GET["client_id"]) == "") {
        $operations = OperationData::getAllByDateOp($_GET["sd"], $_GET["ed"], 3);
    } else {
    }
} else {
    $operations = OperationData::getAllDiscard(); // Obtener todas las ventas si no hay filtros  
}

if(isset($_POST['option']))$operations = OperationData::getAllDiscard(); 

// Calcular el total de páginas
$total = count($operations);
$totalPages = ceil($total / $limit);
$operations = array_slice($operations, $offset, $limit); // Paginación de los datos
?>

<!-- HTML para la visualización y paginación -->
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1><i class="bi bi-graph-down-arrow"></i> Reporte de Descartes</h1>
                
                <!-- Filtros y Opciones -->
                <div class="row">
                    <div class="col-md-10">
                        <form class="mt-5" id="salesForm" method="get">
                            <input type="hidden" name="view" value="discardreports">
                            <input type="hidden" name="page" value="<?php echo $page; ?>">
                            <div class="row">
                                <div class="col-md-4 col-sm-6 mb-2">
                                    <label for="startDate" class="form-label">Fecha Inicial</label>
                                    <input type="date" name="sd" value="<?php echo isset($_GET["sd"]) ? $_GET["sd"] : ''; ?>" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-6 mb-2">
                                    <label for="startDate" class="form-label">Fecha Final</label>
                                    <input type="date" name="ed" value="<?php echo isset($_GET["ed"]) ? $_GET["ed"] : ''; ?>" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-6 mb-2">
                                    <label for="startDate" class="form-label">.</label>
                                    <button type="button" id="processButton" class="btn btn-success w-100 text-white">Procesar</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Form con icono de refresh -->
                    <div class="col-md-2">
                    <label for="endDate" class="form-label" style="color:#ebedef;">.</label><br>
                    <label for="endDate" class="form-label" style="color:#ebedef;">.</label>
                        <form class="mt-3" action="index.php?view=discardreports" method="post">
                            <input type="hidden" name="option" value="all">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-arrow-clockwise"></i> Refresh
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php if (count($operations) > 0): ?>

                <!-- Tabla de resultados -->
                <div class="card mt-5">
                    <div class="card-header">REPORTE DE DESCARTES</div>
                    <!-- Controles de paginación y límite -->
                    <div class="d-flex justify-content-between mb-3 mt-3 ms-3">
                <div>
                    <b>Mostrar:</b>
                    <select id="limitSelect" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                        <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10</option>
                        <option value="25" <?php echo $limit == 25 ? 'selected' : ''; ?>>25</option>
                        <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50</option>
                    </select>
                    <b>Ventas por página</b>
                </div>
                <div>
                    <p class="mb-0 me-3">Estas en la página <?php echo $page; ?> de <?php echo $totalPages; ?></p>
                </div>
            </div>

            <?php if (!empty($operations)): ?>
                    <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Id</th>
                                            <th>Producto</th>
                                            <th>Descripción</th>
                                            <th>Motivo del descarte</th>
                                            <th>Cantidad</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($operations as $operation): ?>
                                            <?php 
                                            $id = is_object($operation) ? $operation->id : (isset($operation['id']) ? $operation['id'] : null);
                                            $product_id = is_object($operation) ? $operation->product_id : (isset($operation['product_id']) ? $operation['product_id'] : null);
                                            $reason = is_object($operation) ? $operation->reason : (isset($operation['reason']) ? $operation['reason'] : 'N/A');
                                            $quantity = is_object($operation) ? $operation->q : (isset($operation['q']) ? $operation['q'] : 0);
                                            $created_at = is_object($operation) ? $operation->created_at : (isset($operation['created_at']) ? $operation['created_at'] : 'N/A');
                                            
                                            $product = $product_id ? ProductData::getById($product_id) : null;
                                            ?>
                                            <tr>
                                                <td><?php echo $id; ?></td>
                                                <td><?php echo $product ? $product->name : 'Producto desconocido'; ?></td>
                                                <td><?php echo $product ? $product->description : 'Descripción no disponible'; ?></td>
                                                <td><?php echo htmlspecialchars($reason); ?></td>
                                                <td><?php echo number_format($quantity); ?></td>
                                                <td><?php echo $created_at; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                                            
                <!-- Paginación centrada debajo de la tabla -->
                <div class="d-flex justify-content-center mt-3">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <?php if ($page > 1): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="index.php?view=discardreports&limit=<?php echo $limit; ?>&page=1">««</a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="index.php?view=discardreports&limit=<?php echo $limit; ?>&page=<?php echo $page - 1; ?>">‹</a>
                                                </li>
                                            <?php endif; ?>

                                            <?php
                                            $startPage = max(1, $page - 2);
                                            $endPage = min($totalPages, $page + 2);
                                            for ($i = $startPage; $i <= $endPage; $i++): ?>
                                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                                    <a class="page-link" href="index.php?view=discardreports&limit=<?php echo $limit; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                                </li>
                                            <?php endfor; ?>

                                            <?php if ($page < $totalPages): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="index.php?view=discardreports&limit=<?php echo $limit; ?>&page=<?php echo $page + 1; ?>">›</a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="index.php?view=discardreports&limit=<?php echo $limit; ?>&page=<?php echo $totalPages; ?>">»»</a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <?php endif ?>
                        <?php else: ?>
                            <div class="jumbotron mt-5">
                                <h2>No hay operaciones</h2>
                                <p>No se encontraron operaciones para mostrar.</p>
                            </div>
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
