<div class="row">
    <div class="col-md-12">
        <h1><i class="bi bi-archive"></i> Caja</h1>
        <div class="btn-group pull-right mt-5">
            <a href="./index.php?view=boxhistory" class="btn btn-primary mr-2 rounded">
                <i class="bi bi-clock-history"></i> Historial
            </a>
            <?php if($_SESSION['is_admin'] === 1): ?>
            <button class="btn btn-success mx-4 rounded" data-bs-toggle="modal" data-bs-target="#confirmProcessModal">
                Procesar Ventas <i class="bi bi-arrow-right"></i>
            </button>
            <button class="btn btn-info rounded" data-bs-toggle="modal" data-bs-target="#initialBalanceModal">
                Saldo Inicial <i class="bi bi-cash-coin"></i>
            </button>
            <?php endif; ?>
        </div>
        <div class="clearfix"></div>
        <br>

        <?php
       // Configuración de la paginación
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $offset = ($page - 1) * $limit;
                    
        // Obtener las ventas actuales
        $products = SellData::getSellsUnBoxed(); // Obtener todas las ventas no procesadas
        $totalSells = count($products); // Total de ventas no procesadas
                    
        // Calcular el total de páginas
        $totalPages = ceil($totalSells / $limit); // Asegúrate de definir esta variable
                    
        // Calcular las ventas a mostrar en la página actual
        $products = array_slice($products, $offset, $limit);

        if (count($products) > 0) {
            $total_total = 0;
                ?>
                <div class="card">
                    <div class="card-header">
                        CAJA
                    </div>

                     <!-- Información de la página actual y límite -->
                     <div class="d-flex justify-content-between align-items-center mt-3 ms-3">
                         <div> 
                                <form method="get" class="d-inline">
                                    <input type="hidden" name="view" value="box">
                                    <b>Mostrar:</b>
                                    <select name="limit" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                                        <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10 por página</option>
                                        <option value="25" <?php echo $limit == 25 ? 'selected' : ''; ?>>25 por página</option>
                                        <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50 por página</option>
                                    </select>
                                    <b class="me-3">Ventas por página</b>
                                </form>
                            </div>
                            <div class="me-3">
                                <span>Estás en la página: <?php echo $page; ?> de <?php echo ceil($totalSells / $limit); ?></span>
                            </div>
                        </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Producto</th>
                                        <th>Total</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $sell): ?>
                                    <tr>
                                        <td style="width:30px;"></td>
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
                                                $total = $sell->total;
                                            }
                                            $total_total += $total;
                                            echo "<b>C$ " . number_format($total, 2, ".", ",") . "</b>";
                                            ?>
                                        </td>
                                        <td><?php echo $sell->created_at; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <div class="mt-4">
   
                </div>
                        <!-- Mostrar Saldo Inicial y Total Incluyendo Saldo Inicial -->
                        <h2 class="text-info mt-4">Saldo Inicial: C$ <span id="initialBalanceDisplay">0.00</span></h2>
                        <h2 class="text-success mt-3">Total Incluyendo Saldo Inicial: C$ <span id="totalDisplay"><?php echo number_format($total_total, 2, ".", ","); ?></span></h2>
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
                </div>
                <?php
                } else {
                ?>
                <div class="jumbotron">
                    <h2>No hay ventas</h2>
                    <p>No se ha realizado ninguna venta.</p>
                </div>
                <?php } ?>
                <br><br><br><br><br><br><br><br><br><br>
            </div>
        </div>

        <div class="modal fade" id="confirmProcessModal" tabindex="-1" aria-labelledby="confirmProcessModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmProcessModalLabel">Confirmar Procesamiento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que deseas procesar todas las ventas? Esta acción no se puede deshacer.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <a id="confirmProcessBtn" class="btn btn-success" href="./index.php?view=processbox">Procesar</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="initialBalanceModal" tabindex="-1" aria-labelledby="initialBalanceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="initialBalanceModalLabel">Ingresar/Actualizar Saldo Inicial</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="initialBalanceInput" class="form-label">Saldo Inicial</label>
                            <input type="number" class="form-control" id="initialBalanceInput" placeholder="Ingrese el saldo inicial">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-info" id="saveInitialBalanceBtn">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exponer el total de ventas a JavaScript -->
        <script>
            var totalSales = <?php echo json_encode($total_total); ?>;
        </script>

        <script>
            $(document).ready(function() {
                // Función para actualizar la visualización del saldo inicial y el total
                function updateTotalDisplay() {
                    const initialBalance = parseFloat(localStorage.getItem('initialBalance') || 0);
                    $('#initialBalanceDisplay').text(initialBalance.toFixed(2));
                    const totalIncludingInitial = initialBalance + totalSales;
                    $('#totalDisplay').text(totalIncludingInitial.toFixed(2));
                }

                // Cargar y mostrar el saldo inicial al cargar la página
                updateTotalDisplay();

                // Guardar el saldo inicial en Local Storage y actualizar la visualización
                $('#saveInitialBalanceBtn').click(function() {
                    const newBalance = parseFloat($('#initialBalanceInput').val());
                    if (!isNaN(newBalance)) {
                        localStorage.setItem('initialBalance', newBalance.toFixed(2));
                        updateTotalDisplay();
                        $('#initialBalanceModal').modal('hide');
                    } else {
                        alert('Por favor, ingrese un número válido.');
                    }
                });

                // Actualizar el enlace de confirmación en el modal de procesamiento
                $('#confirmProcessModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget); // Botón que activó el modal
                    var url = button.data('href'); // Extraer la URL del atributo data-href

                    var modal = $(this);
                    modal.find('#confirmProcessBtn').attr('href', url);
                });
            });
        </script>
