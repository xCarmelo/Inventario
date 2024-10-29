

<div class="container"> 
    <div class="row">
        <div class="col-12">
            <h1><i class="bi bi-cart"></i> COMPRAS</h1>
            <div class="clearfix"></div>

            <div class="col-md-10">
                <!-- Filtro por fecha -->
                <div class="row">
                    <!-- Formulario de filtro por fecha -->
                    <form method="GET" action="index.php" class="col-md-10 my-3 mt-5 d-flex">
                        <input type="hidden" name="view" value="res">
                        <div class="row w-100">
                            <div class="col-md-5">
                                <input type="date" name="sd" id="sd" class="form-control" value="<?php echo isset($_GET['sd']) ? $_GET['sd'] : ''; ?>">
                            </div>
                            <div class="col-md-5">
                                <input type="date" name="ed" id="ed" class="form-control" value="<?php echo isset($_GET['ed']) ? $_GET['ed'] : ''; ?>">
                            </div>
                            <div class="col-md-2 align-self-end">
                                <button type="submit" class="btn btn-success w-200 text-white form-control">Filtrar</button>
                            </div>
                        </div>
                    </form>

                    <!-- Form con icono de refresh -->
                    <div class="col-md-2 d-flex justify-content-center align-items-center pt-4">
                        <form action="index.php?view=res" method="post">
                            <input type="text" value="all" hidden name="option">
                            <button type="submit" class="btn btn-primary w-100 mt-1">
                                <i class="bi bi-arrow-clockwise"></i> Refresh
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-header">
                    COMPRAS
                </div>
                <div class="card-body"> 

                    <?php
                    // Configuración de paginación
                    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;

                    // Obtener la lista de compras con filtro de fecha
                    if (isset($_GET['sd']) && isset($_GET['ed'])) {
                        $products = SellData::getAllByDateOp($_GET['sd'], $_GET['ed'], 1);
                    } else {
                        $products = SellData::getRes();
                    }

                    $total = count($products); // Total de productos
                    $totalPages = ceil($total / $limit);
                    $products = array_slice($products, $offset, $limit); // Aplicar la paginación

                    if (count($products) > 0) {
                    ?>
                    <!-- Selección de límite y paginación -->
                    <div class="d-flex justify-content-between mb-3 mt-3">
                        <div>
                            <b>Mostrar:</b>
                            <select id="limitSelect" class="form-select d-inline-block w-auto">
                                <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10</option>
                                <option value="25" <?php echo $limit == 25 ? 'selected' : ''; ?>>25</option>
                                <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50</option>
                            </select>
                            <b>Compras por página</b> 
                        </div>
                        <div>
                            <p class="mb-0 me-3">Estás en la página <?php echo $page; ?> de <?php echo $totalPages; ?></p>
                        </div>
                    </div>

                    <div class="table-responsive"> 
                        <table class="table table-bordered table-hover">
                            <thead class="table-primary">
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
                                    <button class="btn btn-xs btn-danger d-flex align-items-center text-white" data-bs-toggle="modal" data-bs-target="#confirmDevolucionModal" data-href="index.php?view=delre&id=<?php echo $operation->sell_id; ?>">
                                        <span>Devolución</span>
                                        <i class="bi bi-arrow-return-left ms-2"></i>
                                    </button> 
                                </td>
                                    <?php endif;?>
                                </tr>

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="d-flex justify-content-center mt-3">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="index.php?view=res&limit=<?php echo $limit; ?>&page=1">««</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="index.php?view=res&limit=<?php echo $limit; ?>&page=<?php echo $page - 1; ?>">‹</a>
                                    </li>
                                <?php endif; ?>

                                <?php
                                $startPage = max(1, $page - 2);
                                $endPage = min($totalPages, $page + 2);
                                for ($i = $startPage; $i <= $endPage; $i++): ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a class="page-link" href="index.php?view=res&limit=<?php echo $limit; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="index.php?view=res&limit=<?php echo $limit; ?>&page=<?php echo $page + 1; ?>">›</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="index.php?view=res&limit=<?php echo $limit; ?>&page=<?php echo $totalPages; ?>">»»</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
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