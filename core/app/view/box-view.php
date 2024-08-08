<div class="row">
    <div class="col-md-12">
        <h1><i class='fa fa-archive'></i> Caja</h1>
        <div class="btn-group pull-right">
            <a href="./index.php?view=boxhistory" class="btn btn-primary mr-2 rounded">
                <i class="fa fa-clock-o"></i> Historial
            </a>
            <button class="btn btn-success mx-4 rounded" data-bs-toggle="modal" data-bs-target="#confirmProcessModal">
                Procesar Ventas <i class="fa fa-arrow-right"></i>
            </button>
            <button class="btn btn-info rounded" data-bs-toggle="modal" data-bs-target="#initialBalanceModal">
                Saldo Inicial <i class="fa fa-money"></i>
            </button>
        </div>
        <div class="clearfix"></div>
        <br>

        <?php
        $products = SellData::getSellsUnBoxed();
        if (count($products) > 0) {
            $total_total = 0;
        ?>
        <div class="card">
            <div class="card-header">
                CAJA
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
                                        $total += $sell->total;
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
                <h2 class="text-info mt-4">Saldo Inicial: C$ <span id="initialBalanceDisplay">0.00</span></h2>
                <h2 class="text-success mt-3">Total: C$ <span id="totalDisplay"><?php echo number_format($total_total, 2, ".", ","); ?></span></h2>
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

<!-- Modal de Confirmación -->
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
                <a id="confirmProcessBtn" class="btn btn-success" href="#">Procesar</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Saldo Inicial -->
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

<script>
    $(document).ready(function() {
        // Cargar saldo inicial desde Local Storage
        const initialBalance = localStorage.getItem('initialBalance') || 0;
        $('#initialBalanceDisplay').text(parseFloat(initialBalance).toFixed(2));
        updateTotalDisplay();

        // Guardar saldo inicial en Local Storage
        $('#saveInitialBalanceBtn').click(function() {
            const newBalance = parseFloat($('#initialBalanceInput').val());
            if (!isNaN(newBalance)) {
                localStorage.setItem('initialBalance', newBalance.toFixed(2));
                $('#initialBalanceDisplay').text(newBalance.toFixed(2));
                updateTotalDisplay();
                $('#initialBalanceModal').modal('hide');
            } else {
                alert('Por favor, ingrese un número válido.');
            }
        });

        $('#confirmProcessModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var url = button.data('href'); // Extraer la URL del atributo data-href

            var modal = $(this);
            modal.find('#confirmProcessBtn').attr('href', url);
        });

        function updateTotalDisplay() {
            const initialBalance = parseFloat(localStorage.getItem('initialBalance') || 0);
            const total = parseFloat("<?php echo $total_total; ?>");
            const grandTotal = initialBalance + total;
            $('#totalDisplay').text(grandTotal.toFixed(2));
        }
    });
</script>