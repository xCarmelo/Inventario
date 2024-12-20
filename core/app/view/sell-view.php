<div class="row">
<div class="row">
    <div class="col-12">
    <h1><i class="bi bi-cash-coin"></i> Venta</h1>
        <p class="mt-4"><b>Buscar producto por nombre</b></p>
        <form id="searchp">
            <div class="row">
                <div class="col-md-6 col-12 mb-2 mb-md-0">
                    <input type="hidden" name="view" value="sell">
                    <input title="El nombre del producto solo puede contener letras, números, espacios, guiones y puntos. Debe tener entre 1 y 100 caracteres." pattern="^[A-Za-zÁÉÍÓÚÑáéíóúñ\s0-9\-'\.]{1,100}$" type="text" id="product_code" name="product" class="form-control" placeholder="Nombre">
                    <!-- Contenedor para el mensaje de error -->
                    <small id="product_code_error" class="text-danger" style="display:none;">Formato inválido. Solo se permiten letras, números, espacios, guiones, comillas simples y puntos (máximo 100 caracteres).</small>
                </div>
                <div class="col-md-3 col-12">
                    <button type="submit" class="btn btn-primary w-100  fw-bold"><i class="glyphicon glyphicon-search"></i> Buscar</button>
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

            // Validación del campo product_code
            var productCodeInput = $("#product_code")[0];
            if (!productCodeInput.checkValidity()) {
                $("#product_code_error").show(); // Muestra el mensaje de error
                return;
            } else {
                $("#product_code_error").hide(); // Oculta el mensaje de error si es válido
            }

            // Lógica para buscar el producto
            $.get("./?action=searchproduct", $("#searchp").serialize(), function(data){
                $("#show_search_results").html(data);
            });

            $("#product_code").val("");
        });

        // También podrías ocultar el mensaje cuando el usuario empiece a escribir
        $("#product_code").on("input", function() {
            if (this.checkValidity()) {
                $("#product_code_error").hide();
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
                    <th>Codigo</th>
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

    <!--- Carrito de compras :) -->
    <?php if(isset($_SESSION["cart"])):
        $total = 0;
    ?>
    <div class="container my-5">
        <div class="card">
            <div class="card-header">
                RESUMEN DE LA VENTA
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
                                <th>Precio Unitario</th>
                                <th>Precio Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION["cart"] as $p):
                                $product = ProductData::getById($p["product_id"]);
                            ?>
                            <tr>
                                <td><?php echo $product->id; ?></td>
                                <td><?php echo $p["q"]; ?></td>
                                <td><?php echo $product->unit; ?></td>  
                                <td><?php echo $product->name; ?></td>
                                <td><b>C$<?php echo number_format($p["newprice"]); ?></b></td>
                                <td><b>C$<?php $pt = $p["newprice"] * $p["q"]; $total += $pt; echo number_format($pt); ?></b></td>
                                <td><a href="index.php?view=clearcart&product_id=<?php echo $product->id; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="alerts"></div> <!-- Contenedor de alertas movido aquí -->

    <form method="post" class="form-horizontal" id="processsell" action="index.php?view=processsell">
        <h2 class="mb-4">Resumen</h2>
        <div class="mb-3 row">
            <label for="client" class="col-sm-2 col-form-label">Cliente</label>
            <div class="col-sm-10">
                <?php 
                $clients = PersonData::getClients(); 
                ?>
                <select name="client_id" class="form-select">
                    <option value="">-- NINGUNO --</option>
                    <?php foreach($clients as $client):  if($client->active != 0):?> 
                    <option value="<?php echo $client->id; ?>"><?php echo $client->name." ".$client->lastname; ?></option>
                    <?php endif; endforeach; ?>
                </select>
            </div> 
        </div>
        <div class="mb-3 row">
            <label for="money" class="col-sm-2 col-form-label">Efectivo</label>
            <div class="col-sm-10">
                <input type="number" name="money" required class="form-control" id="money" placeholder="Efectivo">
            </div>
        </div>
        <input id="totalSell" type="hidden" name="total" value="<?php echo $total; ?>" class="form-control" placeholder="Total">
        <div class="mb-4 row">
            <div class="col-md-6 offset-md-6">
                <table class="table table-bordered">
                    <tr>
                        <td><p>Total</p></td>
                        <td hidden><p><b>C$ <span id="total_with_discount"><?php echo number_format($total); ?></span></b></p></td>
                        <td><p><b>C$ <span id="total_with_discount"><?php echo number_format($total); ?></span></b></p></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-lg-4 offset-lg-8" style="margin-bottom: 2rem;">
        <div class="d-flex justify-content-evenly btn_content">
    <a href="index.php?view=clearcart" class="btn btn-sm btn-danger active rounded" style="border-radius: 10px; margin-right: 10px; font-size: 1rem;">
        <i class="glyphicon glyphicon-remove"></i> Cancelar
    </a>
    <button type="submit" class="btn btn-sm btn-primary active rounded" style="border-radius: 10px; font-size:1rem;">
        <i class="glyphicon glyphicon-usd"></i> Finalizar Venta
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

        function updateTotal() {
            var discount = parseFloat($('#discount').val()) || 0;
            var total = <?php echo $total; ?>;
            
            if (discount > total) {
                showAlert('El descuento no puede ser mayor que el total.', 'danger');
                $('#discount').val(0);
                discount = 0;
            }
            
            var totalWithDiscount = total - discount;
            $('#total_with_discount').text(totalWithDiscount.toFixed(2));
            $('#totalSell').val(totalWithDiscount.toFixed(2));
        }
 
        $('#discount').on('input', updateTotal);
        updateTotal(); 

        $("#processsell").submit(function(e) {
            e.preventDefault(); 

            var discount = parseFloat($("#discount").val()) || 0;
            var money = parseFloat($("#money").val()) || 0;
            var total = <?php echo $total; ?>;
            var totalWithDiscount = total - discount;

            if (discount > total) {
                showAlert("El descuento no puede ser mayor que el total.", 'danger');
                return;
            }

            if (money < totalWithDiscount) {
                showAlert("No se puede efectuar la operación, el dinero en efectivo es insuficiente.", 'danger');
                return;
            }

            // Configura el mensaje del modal
            var change = (money - totalWithDiscount).toFixed(2);
            $("#confirmModal .modal-body").text("Cambio: C$" + change);

            // Muestra el modal
            $("#confirmModal").modal('show');

            // Maneja la confirmación del modal
            $("#modalConfirm").one('click', function() {
                $("#processsell")[0].submit();
            });

            // Maneja la cancelación del modal
            $("#modalCancel").one('click', function() {
                $("#confirmModal").modal('hide');
            });
            $("#modalCance").one('click', function() {
                $("#confirmModal").modal('hide');
            });
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


<!-- Placeholder for alerts -->
<div id="alerts"></div>

<?php endif; ?>

<?php unset($_SESSION['errors']); ?>
