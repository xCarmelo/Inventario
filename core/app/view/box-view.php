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
        $totalPages = ceil($totalSells / $limit);

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
                            <thead class="table-primary">
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
        
        <!-- Mini tabla para Saldo Inicial y Total -->
        <div class="container mt-5">
        <div class="row justify-content-star">
            <div class="col-md-7">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td class="text-info text-lg"><h5>Saldo Inicial:</h5></td>
                    <td class="text-end text-info" style="font-size: 20px;">C$ <span id="initialBalanceDisplay">0.00</span></td>
                </tr>
                <tr>
                    <td class="text-success"><h5>Total Incluyendo Saldo Inicial:</h5></td>
                    <td class="text-end text-success" style="font-size: 20px;">C$ <span id="totalDisplay"><?php echo isset($total_total) ? number_format($total_total, 2, ".", ",") : '0.00'; ?></span></td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>
        </div>
        
        <!-- Paginación centrada debajo de la tabla -->
        <?php if ($totalSells > 0): ?>
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
        <?php endif; ?>
    </div>
</div>

<!-- Modal para confirmar el procesamiento de ventas -->
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

<!-- Modal para ingresar el saldo inicial -->
<div class="modal fade" id="initialBalanceModal" tabindex="-1" aria-labelledby="initialBalanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="initialBalanceModalLabel">Ingresar/Actualizar Saldo Inicial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="initialBalanceInput">Saldo Inicial (C$):</label>
                <input type="number" id="initialBalanceInput" class="form-control" min="0" title="Por favor, ingresa un número válido y positivo para el saldo inicial.">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveInitialBalanceBtn" data-bs-dismiss="modal">Guardar Saldo Inicial</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para mensaje de validación -->
<div class="modal fade" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="validationModalLabel">Error de Validación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="validationMessage">El saldo inicial debe ser un número positivo.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const initialBalanceInput = document.getElementById('initialBalanceInput'); // Campo de input para el saldo inicial
        const saveInitialBalanceBtn = document.getElementById('saveInitialBalanceBtn'); // Botón para guardar saldo inicial
        const initialBalanceDisplay = document.getElementById('initialBalanceDisplay'); // Elemento para mostrar saldo inicial
        const totalDisplay = document.getElementById('totalDisplay'); // Elemento para mostrar el total

        // Obtener el saldo inicial desde localStorage o establecer en 0 si no existe
        let initialBalance = parseFloat(localStorage.getItem('initialBalance')) || 0;
        initialBalanceDisplay.textContent = initialBalance.toFixed(2);

        // Obtener el total actual excluyendo el saldo inicial (por ejemplo, basado en ventas)
        let salesTotal = parseFloat(totalDisplay.textContent.replace(/,/g, '')) || 0;

        // Función para actualizar el total incluyendo el saldo inicial
        function updateTotalDisplay() {
            // Actualizar el total incluyendo el saldo inicial
            let totalWithInitialBalance = salesTotal + initialBalance;
            totalDisplay.textContent = totalWithInitialBalance.toFixed(2); // Mostrar con 2 decimales
        }

        // Actualizar la primera vez
        updateTotalDisplay();

        // Validar que el saldo inicial sea un número positivo
        function validateInitialBalance(value) {
            return !isNaN(value) && value >= 0;
        }

        // Guardar el saldo inicial cuando se presiona el botón
        saveInitialBalanceBtn.addEventListener('click', function() {
            const newInitialBalance = parseFloat(initialBalanceInput.value);

            if (validateInitialBalance(newInitialBalance)) {
                // Actualizar el saldo inicial en localStorage
                initialBalance = newInitialBalance;
                localStorage.setItem('initialBalance', initialBalance);
                initialBalanceDisplay.textContent = initialBalance.toFixed(2);

                // Actualizar el total mostrado
                updateTotalDisplay();
            } else {
                 // Mostrar el modal de validación si el saldo inicial no es válido
                $('#validationMessage').text('Por favor, ingrese un número válido y positivo.');
                $('#validationModal').modal('show');
            }
        });

        $('#confirmProcessModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Botón que activó el modal
                    var url = button.data('href'); // Extraer la URL del atributo data-href

                    var modal = $(this);
                    modal.find('#confirmProcessBtn').attr('href', url);
                });

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

