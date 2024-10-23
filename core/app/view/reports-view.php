<?php
$products = ProductData::getAll();
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : "";
?>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1><i class="bi bi-file-earmark-bar-graph"></i> Reportes</h1>
                <form class="mt-5">
                    <input type="hidden" name="view" value="reports">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-2">
                            <select name="product_id" class="form-control">
                                <option value="">--  TODOS --</option>
                                <?php foreach($products as $p): ?>
                                <option value="<?php echo $p->id; ?>" <?php echo ($product_id == $p->id) ? 'selected' : ''; ?>><?php echo $p->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-2">
                            <input type="date" name="sd" value="<?php if(isset($_GET["sd"])) { echo $_GET["sd"]; } ?>" class="form-control">
                        </div>
                        <div class="col-md-3 col-sm-6 mb-2">
                            <input type="date" name="ed" value="<?php if(isset($_GET["ed"])) { echo $_GET["ed"]; } ?>" class="form-control">
                        </div>
                        <div class="col-md-3 col-sm-6 mb-2">
                            <input type="submit" class="btn btn-success btn-block w-100" value="Procesar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">MOVIMIENTOS</div> 
                    <div class="card-body">
                        <?php if (isset($_GET["sd"]) && isset($_GET["ed"])): ?>
                            <?php if ($_GET["sd"] != "" && $_GET["ed"] != ""): ?>
                                <?php
                                $operations = array();
                                if ($product_id == "") {
                                    $operations = OperationData::getAllByDateOfficial($_GET["sd"], $_GET["ed"]);
                                } else {
                                    $operations = OperationData::getAllByDateOfficialBP($product_id, $_GET["sd"], $_GET["ed"]);
                                }
                                
                                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
                                $totalOperations = count($operations);
                                $totalPages = ceil($totalOperations / $limit);
                                $offset = ($page - 1) * $limit;
                                $curr_operations = array_slice($operations, $offset, $limit);
                                ?>

                                <?php if (count($curr_operations) > 0): ?>
                                    <!-- Selección del límite de operaciones y número de página -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <form method="GET" action="index.php">
                                                <input type="hidden" name="view" value="reports">
                                                <input type="hidden" name="sd" value="<?php echo $_GET['sd']; ?>">
                                                <input type="hidden" name="ed" value="<?php echo $_GET['ed']; ?>">
                                                <label for="limit">Mostrar </label>
                                                <select name="limit" id="limit" onchange="this.form.submit()">
                                                    <option value="5" <?php echo ($limit == 5) ? 'selected' : ''; ?>>5</option>
                                                    <option value="10" <?php echo ($limit == 10) ? 'selected' : ''; ?>>10</option>
                                                    <option value="20" <?php echo ($limit == 20) ? 'selected' : ''; ?>>20</option>
                                                    <option value="50" <?php echo ($limit == 50) ? 'selected' : ''; ?>>50</option>
                                                </select>
                                                operaciones por página
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
                                                        <td><?php echo $operation->reason_for_return; ?></td>
                                                        <td><?php echo $operation->created_at; ?></td> 
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
                                                        <a class="page-link" href="index.php?view=reports&sd=<?php echo $_GET['sd']; ?>&ed=<?php echo $_GET['ed']; ?>&limit=<?php echo $limit; ?>&page=1">««</a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a class="page-link" href="index.php?view=reports&sd=<?php echo $_GET['sd']; ?>&ed=<?php echo $_GET['ed']; ?>&limit=<?php echo $limit; ?>&page=<?php echo $page - 1; ?>">‹</a>
                                                    </li>
                                                <?php endif; ?>

                                                <?php
                                                $startPage = max(1, $page - 2);
                                                $endPage = min($totalPages, $page + 2);
                                                for ($i = $startPage; $i <= $endPage; $i++): ?>
                                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                                        <a class="page-link" href="index.php?view=reports&sd=<?php echo $_GET['sd']; ?>&ed=<?php echo $_GET['ed']; ?>&limit=<?php echo $limit; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                                    </li>
                                                <?php endfor; ?>

                                                <?php if ($page < $totalPages): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="index.php?view=reports&sd=<?php echo $_GET['sd']; ?>&ed=<?php echo $_GET['ed']; ?>&limit=<?php echo $limit; ?>&page=<?php echo $page + 1; ?>">›</a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a class="page-link" href="index.php?view=reports&sd=<?php echo $_GET['sd']; ?>&ed=<?php echo $_GET['ed']; ?>&limit=<?php echo $limit; ?>&page=<?php echo $totalPages; ?>">»»</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </nav>
                                    </div>
                                <?php else: ?>
                                    <div class="jumbotron">
                                        <h2>No hay operaciones</h2>
                                        <p>El rango de fechas seleccionado no proporcionó ningún resultado de operaciones.</p>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="">
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
    <br><br><br><br>
</section>
