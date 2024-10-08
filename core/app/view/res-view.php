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
                    // Configuración de paginación
                    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;

                    // Obtener la lista de compras
                    $products = SellData::getRes();
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
    </div>
</div>

<!-- Modal para mensajes de éxito o error -->
<div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultModalLabel">Resultado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="resultMessage"></p>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>  

<!-- Script para cambiar el límite de paginación -->
<script>
    $(document).ready(function() {
        $('#limitSelect').on('change', function() {
            var limit = $(this).val();
            window.location.href = "?view=res&page=1&limit=" + limit;
        });

         // Mostrar el resultado según los parámetros de la URL
        const urlParams = new URLSearchParams(window.location.search);
        const successMessage = urlParams.get('success');
        const errorMessage = urlParams.get('error');

        if (successMessage) {
            $('#resultMessage').text(successMessage);
            $('#resultModal').modal('show');
        } else if (errorMessage) {
            $('#resultMessage').text(errorMessage);
            $('#resultModal').modal('show');
        }

        mama = () => {
            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);

            params.delete('result');
            params.delete('success'); // Add this line to remove the 'success' parameter as well

            const newUrl = url.pathname + '?' + params.toString();
            window.history.replaceState({}, document.title, newUrl);
        };

        mama();
    });
</script>
<?php unset($_SESSION['errors']); ?>
