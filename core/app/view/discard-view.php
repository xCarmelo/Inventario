<div class="row">
    <div class="row">
        <div class="col-12">
            <h1><i class="bi bi-trash"></i> Descarte</h1>
            <p class="mt-4"><b>Buscar producto por nombre </b></p>
            <form id="searchp">
                <div class="row">
                    <div class="col-md-6 col-12 mb-2 mb-md-0">
                        <input type="hidden" name="view" value="discard">
                        <input type="text" id="product_code" name="product" class="form-control" placeholder="Nombre o código del producto">
                    </div>
                    <div class="col-md-3 col-12">
                        <button type="submit" class="btn btn-primary w-100 fw-bold"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="show_search_results"></div>
    <script>
        $(document).ready(function(){
            $("#searchp").on("submit", function(e){
                e.preventDefault();
                $.get("./?action=searchdiscard", $("#searchp").serialize(), function(data){
                    $("#show_search_results").html(data); 
                });
                $("#product_code").val("");
            });

            $("#product_code").keydown(function(e){
                if(e.which == 17 || e.which == 74){
                    e.preventDefault();
                }else{
                    console.log(e.which);
                }
            });
        });
    </script>

    <?php if(isset($_SESSION["errors"])): ?>
        <div class="card">
            <h2>Errores</h2>
            <p></p>
            <table class="table table-bordered table-hover">
                <tr class="danger">
                    <th>Código</th>
                    <th>Producto</th>  
                    <th>Mensaje</th>
                </tr>
                <?php foreach ($_SESSION["errors"] as $error):
                    $product = ProductData::getById($error["product_id"]);
                ?>
                    <tr class="danger">
                        <td><?php echo $product->id; ?></td>
                        <td><?php echo $product->name; ?></td>
                        <td><b><?php echo $error["message"]; ?></b></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php unset($_SESSION["errors"]); ?>
    <?php endif; ?>

    <!--- Carrito de desechos :) -->
    <?php if(isset($_SESSION["cartdiscard"])):
        $total = 0;
    ?>
    <div class="container my-5">
        <div class="card">
            <div class="card-header">
                RESUMEN DEL DESCARTE
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Código</th>
                                <th>Cantidad</th>
                                <th>Unidad</th>
                                <th>Producto</th>
                                <th>Motivo del Descarte</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION["cartdiscard"] as $p):
                                $product = ProductData::getById($p["product_id"]);
                            ?>
                            <tr>
                                
                                <td><?php echo $product->id; ?></td>
                                <td><?php echo $p["q"]; ?></td>
                                <td><?php echo $product->unit; ?></td>  
                                <td><?php echo $product->name; ?></td>
                                <td><?php echo $p["reason"]; ?></td>
                                <td><a href="index.php?view=cleardiscard&product_id=<?php echo $product->id; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="alerts"></div> <!-- Contenedor de alertas movido aquí -->

    <form method="post" class="form-horizontal" id="processdiscard" action="index.php?view=processdiscard">
        <!-- <h2 class="mb-4">Resumen</h2>
        <div class="mb-3 row">
            <label for="reason" class="col-sm-2 col-form-label">Motivo</label>
            <div class="col-sm-10">
                <input type="text" name="reason" required class="form-control" id="reason" placeholder="Motivo del descarte">
            </div>
        </div>-->
        <div class="col-lg-4 offset-lg-8" style="margin-bottom: 2rem;">
            <div class="d-flex justify-content-evenly btn_content">
                <a href="index.php?view=cleardiscard" class="btn btn-sm btn-danger active rounded" style="border-radius: 10px; margin-right: 10px; font-size: 1rem;">
                    <i class="glyphicon glyphicon-remove"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-sm btn-primary active rounded" style="border-radius: 10px; font-size:1rem;">
                    <i class="glyphicon glyphicon-trash"></i> Finalizar Descarte
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalCancel">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- El mensaje de confirmación será insertado aquí -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modalCance">Cancelar</button>
                <button type="button" class="btn btn-primary" id="modalConfirm">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function showAlert(message, type) {
            var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                            message +
                            '</div>';
            $('#alerts').html(alertHtml);
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        }

        $("#processdiscard").submit(function(e) {
            e.preventDefault(); 

            var reason = $("#reason").val();
            

            // Configura el mensaje del modal
            $("#confirmModal .modal-body").text("¿Está seguro de que desea finalizar el descarte?");

            // Muestra el modal
            $("#confirmModal").modal('show'); 

            // Maneja la confirmación del modal
            $("#modalConfirm").one('click', function() {
                $("#processdiscard")[0].submit();
            });

            // Maneja la cancelación del modal
            $("#modalCancel").one('click', function() {
                $("#confirmModal").modal('hide');
            });
            $("#modalCance").one('click', function() {
                $("#confirmModal").modal('hide');
            });
        });
    });
</script>
<!-- Placeholder for alerts -->
<div id="alerts"></div>

<?php endif; ?>