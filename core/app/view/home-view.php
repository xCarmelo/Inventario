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

// Información para las tarjetas
$totalProducts = count($products);
$totalClients = count(PersonData::getClients());
$totalProviders = count(PersonData::getProviders());
$totalCategories = count(CategoryData::getAll());

// Paginación y límite de productos para las alertas de inventario
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
$totalProductsAlert = count($products_array);
$totalPages = ceil($totalProductsAlert / $limit);
$offset = ($page - 1) * $limit;
$curr_products = array_slice($products_array, $offset, $limit);
?>
<div class="container mt-3">
    <div class="row">
    <div class="container-fluid bg-light p-5 text-center" style="margin-top: -65px;">
    <div class="row">
            <div class="col-md-12 ">
                <h1 class="display-4 fw-bold" style="color: #4f5d73;">Mundo Católico San Agustín</h1>
                <p class="lead text-muted" style="font-size: 1.5rem; letter-spacing: 1px; line-height: 1.6; font-weight: 500;">
                    ¡Todo en artículos religiosos para tu fe!
                </p>
                <hr style="border-top: 3px solid #007bff; width: 50%; margin: 0 auto;">
            </div>
        </div>
    </div>

    </div>

    <div class="container">
    <div class="row g-4 justify-content-center">
        <!-- Tarjetas de estadísticas -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary text-white me-3 d-flex justify-content-center align-items-center rounded-circle" style="width: 50px; height: 50px;">
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

        <?php if($_SESSION['is_admin'] === 1): ?>
        <!-- Tarjeta CLIENTES -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-info text-white me-3 d-flex justify-content-center align-items-center rounded-circle" style="width: 50px; height: 50px;">
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

        <!-- Tarjeta PROVEEDORES -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-warning text-white me-3 d-flex justify-content-center align-items-center rounded-circle" style="width: 50px; height: 50px;">
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
        <?php endif; ?>


        <!-- Tarjeta CATEGORIAS -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-danger text-white me-3 d-flex justify-content-center align-items-center rounded-circle" style="width: 50px; height: 50px;">
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
</div>
<br>


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">ALERTAS DE INVENTARIO</div>
                <div class="card-body">
                    <?php if (count($products_array) > 0): ?>
                        <!-- Selección del límite de productos y número de página -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <form method="GET" action="index.php">
                                    <input type="hidden" name="view" value="home"> <!-- Cambia "home" por el nombre correcto de la vista -->
                                    <label for="limit">Mostrar </label>
                                    <select name="limit" id="limit" onchange="this.form.submit()">
                                        <option value="5" <?php echo ($limit == 5) ? 'selected' : ''; ?>>5</option>
                                        <option value="10" <?php echo ($limit == 10) ? 'selected' : ''; ?>>10</option>
                                        <option value="20" <?php echo ($limit == 20) ? 'selected' : ''; ?>>20</option>
                                        <option value="50" <?php echo ($limit == 50) ? 'selected' : ''; ?>>50</option>
                                    </select>
                                    productos por página
                                </form>
                            </div>
                            <div>
                                <span>Estás en la página <?php echo $page; ?> de <?php echo $totalPages; ?></span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre del producto</th>
                                        <th>Descripción</th>
                                        <th>En Stock</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($curr_products as $product): 
                                            if($product->is_active != 0):

                                        $q = OperationData::getQYesF($product->id); ?>
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
                                    <?php endif; endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación centrada debajo de la tabla -->
                        <div class="d-flex justify-content-center mt-3">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <?php if ($page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="index.php?view=home&limit=<?php echo $limit; ?>&page=1">««</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="index.php?view=home&limit=<?php echo $limit; ?>&page=<?php echo $page - 1; ?>">‹</a>
                                        </li>
                                    <?php endif; ?>

                                    <?php
                                    $startPage = max(1, $page - 2);
                                    $endPage = min($totalPages, $page + 2);
                                    for ($i = $startPage; $i <= $endPage; $i++): ?>
                                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                            <a class="page-link" href="index.php?view=home&limit=<?php echo $limit; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($page < $totalPages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="index.php?view=home&limit=<?php echo $limit; ?>&page=<?php echo $page + 1; ?>">›</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="index.php?view=home&limit=<?php echo $limit; ?>&page=<?php echo $totalPages; ?>">»»</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>

                    <?php else: ?>
                        <div class="p-5 mb-4 bg-light rounded-3">
                            <h2>No hay alertas</h2>
                            <p>Por el momento no hay alertas de inventario, estas se muestran cuando el inventario ha alcanzado el nivel mínimo.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
