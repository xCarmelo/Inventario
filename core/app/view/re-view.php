<div class="container">
    <div class="row">
        <div class="col-12">
            <h1><i class="bi bi-cart-check"></i> Realizar Compra</h1>
            <p class="mt-5"><b>Buscar producto por nombre</b></p>
            <form>
                <div class="row"> 
                    <div class="col-md-6 col-12 mb-2 mb-md-0">
                        <input type="hidden" name="view" value="re">
                        <input type="text" name="product" class="form-control" placeholder="Nombre del producto">
                    </div>
                    <div class="col-md-3 col-12"> 
                        <button type="submit" class="btn btn-primary w-100 fw-bold"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                    </div>
                </div>
            </form> 
        </div>
    </div>

    <?php if(isset($_GET["product"])): ?>
        <?php
        $products = ProductData::getLike($_GET["product"]);
        if(count($products) > 0){
        ?>
        <div class="card mt-4">
            <div class="card-header">Resultados de la Búsqueda</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Código</th>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Precio unitario</th>
                                <th>En inventario</th>
                                <th>Cantidad</th>
                                <th>Acciones</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $products_in_cero = 0;
                            foreach($products as $product):
                                if($product->is_active != 0):
                                $q = OperationData::getQYesF($product->id);
                            ?>
                            <form method="post" action="index.php?view=addtore">
                                <tr class="<?php if($q <= $product->inventary_min){ echo 'table-danger'; } ?>">
                                    <td><?php echo $product->id; ?></td>
                                    <td>
                                        <?php if ($product->image != ""): ?>
                                            <img src="storage/products/<?php echo $product->image; ?>" style="width:64px;" class="custom-modal-trigger">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $product->name; ?></td>
                                    <td><?php echo $product->description; ?></td>
                                    <td><?php echo $product->presentation; ?></td>
                                    <td><b>C$<?php echo $product->price_in; ?></b></td>
                                    <td><?php echo $q; ?></td>
                                    <td>
                                        <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                        <input type="number" class="form-control" required min="1" name="q" placeholder="Cantidad de producto ...">
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-refresh"></i> Agregar</button>
                                    </td>
                                </tr>
                            </form>
                            <?php endif;     endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    <?php endif; ?>

    <?php if(isset($_SESSION["errors"])): ?>
    <div class="card mt-4">
        <div class="card-header">Errores</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="table-danger">
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Mensaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION["errors"] as $error):
                            $product = ProductData::getById($error["product_id"]);
                        ?>
                        <tr class="table-danger">
                            <td><?php echo $product->id; ?></td>
                            <td><?php echo $product->name; ?></td>
                            <td><b><?php echo $error["message"]; ?></b></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php unset($_SESSION["errors"]); endif; ?>

    <?php if(isset($_SESSION["reabastecer"])): 
        $total = 0;
    ?>
    <div class="card mt-4">
        <div class="card-header">Lista de Reabastecimiento</div>
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
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($_SESSION["reabastecer"] as $p):
                            $product = ProductData::getById($p["product_id"]);
                        ?>
                        <tr>
                            <td><?php echo $product->id; ?></td>
                            <td><?php echo $p["q"]; ?></td>
                            <td><?php echo $product->unit; ?></td>
                            <td><?php echo $product->name; ?></td>
                            <td><b>C$ <?php echo number_format($product->price_in); ?></b></td>
                            <td><b>C$ <?php $pt = $product->price_in * $p["q"]; $total += $pt; echo number_format($pt); ?></b></td>
                            <td>
                                <a href="index.php?view=clearre&product_id=<?php echo $product->id; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div id="alerts"></div> <!-- Contenedor de alertas movido aquí -->
            <form method="post" class="form-horizontal" id="processsell" action="index.php?view=processre">
                <h2>Resumen</h2>
                <div class="form-group row">
                    <label for="client_id" class="col-lg-2 col-form-label">Proveedor</label>
                    <div class="col-lg-10">
                        <?php 
                        $clients = PersonData::getProviders();
                        ?>
                        <select name="client_id" class="form-control">
                            <option value="">-- NINGUNO --</option>
                            <?php foreach($clients as $client): if($client->active != 0): ?>
                                <option value="<?php echo $client->id; ?>"><?php echo $client->name . " " . $client->lastname; ?></option>
                            <?php endif; endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="money" class="col-lg-2 col-form-label">Efectivo</label>
                    <div class="col-lg-10">
                    <input type="number" name="money" required class="form-control" id="money" placeholder="Efectivo" pattern="[1-9][0-9]*" title="Ingrese un valor numérico entero mayor que 0">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 offset-md-6">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Total</td>
                                    <td><b>C$ <?php echo number_format($total); ?></b></td>
                                </tr>
                            </table>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 offset-lg-2">
                            <div class="d-flex justify-content-evenly btn_content">
                                <a href="index.php?view=clearre" class="btn btn-sm btn-danger active rounded fw-bold" style="border-radius: 10px; margin-right: 10px; font-size:1rem;">
                                    <i class="glyphicon glyphicon-remove"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-sm btn-primary active rounded fw-bold" style="border-radius: 10px; font-size:1rem;">
                                    <i class="fa fa-refresh"></i> Procesar
                                </button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
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

<!-- Modal para Ampliar Imágenes -->
<div class="modal fade custom-img-modal" id="imgModal" tabindex="-1" aria-labelledby="imgModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img id="modalImage" src="" alt="Imagen del producto" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function showAlert(message, type) {
            var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                            '' +
                            '<span aria-hidden="true">&times;</span></button>' +
                            message +
                            '</div>';
            $('#alerts').html(alertHtml);
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        }

        $("#processsell").submit(function(e) {
            e.preventDefault(); 

            var money = parseFloat($("#money").val()) || 0;
            var total = <?php echo $total; ?>;

            if (money < total) {
                showAlert("No se puede efectuar la operación, el dinero en efectivo es insuficiente.", 'danger');
                return;
            }

            // Configura el mensaje del modal
            var change = (money - total).toFixed(2);
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
    });
</script>

<!-- JavaScript para el Modal de Imágenes -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    var images = document.getElementsByClassName('custom-modal-trigger');
    var modal = new bootstrap.Modal(document.getElementById('imgModal'));
    var modalImage = document.getElementById('modalImage');

    for (var i = 0; i < images.length; i++) {
        images[i].addEventListener('mouseover', function() {
            modalImage.src = this.src;
            modal.show();
        });

        images[i].addEventListener('mouseleave', function() {
            modal.hide();
        });
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
