<div class="row">
    <div class="col-md-12">
    <h1><i class="bi bi-cart"></i> Lista de Ventas</h1>
        <div class="clearfix"></div>

        <?php
        $products = SellData::getSells();

        if(count($products) > 0){
        ?>

        <div class="card mt-5">
        <div class="card-header">
            VENTAS
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
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($products as $sell): ?>
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
                                <td style="width:30px;">
                                    <button 
                                        class="btn btn-xs btn-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#confirmDeleteModal" 
                                        data-href="index.php?view=delsell&id=<?php echo $sell->id; ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <?php
        } else {
        ?>
        <div class="jumbotron">
            <h2>No hay ventas</h2>
            <p>No se ha realizado ninguna venta.</p>
        </div>
        <?php
        }
        ?>

        <!-- Modal de Confirmación -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que deseas eliminar esta venta? Esta acción no se puede deshacer.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <a id="confirmDeleteBtn" class="btn btn-danger" href="#">Eliminar</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#confirmDeleteModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget); // Botón que activó el modal
                    var url = button.data('href'); // Extraer la URL del atributo data-href

                    var modal = $(this);
                    modal.find('#confirmDeleteBtn').attr('href', url);
                });
            });
        </script>
    </div>
</div>
