<?php
$clients = PersonData::getClients();
$operations = array();

if (isset($_GET["sd"]) && isset($_GET["ed"]) && $_GET["sd"] != "" && $_GET["ed"] != "") {
    $limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    if ($_GET["client_id"] == "") {
        $operations = SellData::getAllByDateOp($_GET["sd"], $_GET["ed"], 2);
    } else {
        $operations = SellData::getAllByDateBCOp($_GET["client_id"], $_GET["sd"], $_GET["ed"], 2);
    }

    $totalOperations = count($operations);
    $totalPages = ceil($totalOperations / $limit);

    // Filtrar operaciones por paginación
    $operations = array_slice($operations, $offset, $limit);
}
?>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1><i class="bi bi-graph-up-arrow"></i> Reportes de Ventas</h1>
                <form class="mt-5">
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
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">REPORTE DE VENTAS</div>
                    <div class="card-body">
                        <?php if (isset($_GET["sd"]) && isset($_GET["ed"])): ?>
                            <?php if ($_GET["sd"] != "" && $_GET["ed"] != ""): ?>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <label for="limit" class="form-label">Mostrar:</label>
                                        <select id="limit" name="limit" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                                            <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10</option>
                                            <option value="25" <?php echo $limit == 25 ? 'selected' : ''; ?>>25</option>
                                            <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50</option>
                                            <option value="100" <?php echo $limit == 100 ? 'selected' : ''; ?>>100</option>
                                        </select>
                                    </div>
                                    <div>
                                        <p class="mb-0">Página <?php echo $page; ?> de <?php echo $totalPages; ?></p>
                                    </div>
                                </div>
                                <?php if (count($operations) > 0): ?>
                                    <?php $supertotal = 0; ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Total</th>
                                                    <th>Fecha</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($operations as $operation): ?>
                                                    <tr>
                                                        <td><?php echo $operation->id; ?></td>
                                                        <td>C$ <?php echo number_format($operation->total - $operation->discount, 2, '.', ','); ?></td>
                                                        <td><?php echo $operation->created_at; ?></td>
                                                    </tr>
                                                    <?php $supertotal += ($operation->total - $operation->discount); ?>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
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
                                    <h1>Total de ventas: C$ <?php echo number_format($supertotal, 2, '.', ','); ?></h1>
                                <?php else: ?>
                                    <div class="jumbotron">
                                        <h2>No hay operaciones</h2>
                                        <p>El rango de fechas seleccionado no proporcionó ningún resultado de operaciones.</p>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="jumbotron">
                                    <h2>Fechas Incorrectas</h2>
                                    <p>Puede ser que no seleccionó un rango de fechas, o el rango seleccionado es incorrecto.</p>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
