<?php
// Configuración de paginación
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Obtener clientes
$clients = PersonData::getClients(); 

// Obtener la lista de ventas con filtros de cliente y fechas
$sells = array();
if (isset($_GET["sd"]) && isset($_GET["ed"]) && $_GET["sd"] != "" && $_GET["ed"] != "") {
    if ($_GET["client_id"] == "") {
        $sells = SellData::getAllByDateOp($_GET["sd"], $_GET["ed"], 2);
    } else {
        $sells = SellData::getAllByDateBCOp($_GET["client_id"], $_GET["sd"], $_GET["ed"], 2);
    }
} else {
    $sells = SellData::getSells(); // Obtener todas las ventas si no hay filtros 
}

// Calcular el total de páginas
$total = count($sells);
$totalPages = ceil($total / $limit);
$sells = array_slice($sells, $offset, $limit); // Paginación de los datos
?>

<div class="row">
    <div class="col-md-12">
        <h1><i class="bi bi-cart"></i> Lista de Ventas</h1>
        <form class="mt-3">
            <input type="hidden" name="view" value="sellreports"> 
            <div class="row">
                <div class="col-md-3 col-sm-6 mb-2">
                    <select name="client_id" class="form-select">
                        <option value="">-- TODOS --</option>
                        <?php foreach ($clients as $p): ?>
                        <option value="<?php echo $p->id; ?>" <?php echo isset($_GET["client_id"]) && $_GET["client_id"] == $p->id ? 'selected' : ''; ?>><?php echo $p->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 mb-2">
                    <input type="date" name="sd" value="<?php echo isset($_GET["sd"]) ? $_GET["sd"] : ''; ?>" class="form-control">
                </div>
                <div class="col-md-3 col-sm-6 mb-2">
                    <input type="date" name="ed" value="<?php echo isset($_GET["ed"]) ? $_GET["ed"] : ''; ?>" class="form-control">
                </div>
                <div class="col-md-3 col-sm-6 mb-2">
                    <button type="submit" class="btn btn-success w-100">Procesar</button>
                </div>
            </div>
        </form>

        <div class="clearfix"></div>

        <?php if (count($sells) > 0) { ?>

        <div class="card mt-5">
            <div class="card-header">
                VENTAS 
            </div>  

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

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th></th>
                                <th>Producto</th>
                                <th>Total</th>
                                <th>Fecha</th>
                                <?php if ($_SESSION['is_admin'] === 1) { ?>
                                <th></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sells as $sell) { ?>
                            <tr>
                                <td style="width:30px;">
                                    <a href="index.php?view=onesell&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-link"><i class="bi bi-eye"></i></a>
                                </td>
                                <td>
                                    <?php
                                    $operations = OperationData::getAllProductsBySellId($sell->id);
                                    echo count($operations);
                                    ?> 
                                </td>
                                <td> 
                                    <?php
                                    $total = $sell->total;
                                    echo "<b>C$ ".number_format($total)."</b>";
                                    ?>
                                </td>
                                <td><?php echo $sell->created_at; ?></td>

                                <?php if ($_SESSION['is_admin'] === 1) { ?>
                                <td style="width:30px;">
                                    <button 
                                        class="btn btn-xs btn-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#confirmDeleteModal" 
                                        data-href="index.php?view=delsell&id=<?php echo $sell->id; ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

 <!-- Paginación centrada debajo de la tabla -->
 <div class="d-flex justify-content-center mt-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?view=products&limit=<?php echo $limit; ?>&page=1">««</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?view=products&limit=<?php echo $limit; ?>&page=<?php echo $page - 1; ?>">‹</a>
                                </li>
                            <?php endif; ?>

                            <?php
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPages, $page + 2);
                            for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="index.php?view=products&limit=<?php echo $limit; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?view=products&limit=<?php echo $limit; ?>&page=<?php echo $page + 1; ?>">›</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?view=products&limit=<?php echo $limit; ?>&page=<?php echo $totalPages; ?>">»»</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>

        <?php } else { ?>
        <div class="jumbotron">
            <h2>No hay ventas</h2>
            <p>No se encontraron resultados para el rango seleccionado.</p>
        </div>
        <?php } ?>
    </div>
</div>
