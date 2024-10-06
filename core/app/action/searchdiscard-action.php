<?php if (!empty($_GET["product"]) && $_GET["product"] !== ""): ?>
    <div class="card mt-5">
        <div class="card-header mt-1">
            <span>Resultados de la Búsqueda</span>
        </div>
        <div class="card-body">
            <?php
            $products = ProductData::getLike($_GET["product"]);
            if (count($products) > 0):
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Unidad</th>
                                <th>Motivo del Descarte</th>
                                <th>En inventario</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $products_in_cero = 0;

                            foreach ($products as $product):
                                $q = OperationData::getQYesF($product->id);
                                $product_id_to_find = $product->id;

                                $reason = ""; // Inicializar motivo de descarte vacío

                                if (isset($_SESSION["cartdiscard"]) && is_array($_SESSION["cartdiscard"])) {
                                    $cart = $_SESSION["cartdiscard"];
                                    foreach ($cart as $item) {
                                        if ($item["product_id"] == $product_id_to_find) {
                                            $reason = $item["reason"]; // Recuperar motivo de descarte si existe
                                            break;
                                        }
                                    }
                                }

                                if ($q > 0):
                                    ?>
                                    <tr class="<?php echo ($q <= $product->inventary_min) ? 'table-danger' : ''; ?>">
                                        <td>
                                            <?php if ($product->image != ""): ?>
                                                <img src="storage/products/<?php echo $product->image; ?>" style="width:64px;" class="custom-modal-trigger">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($product->name); ?></td>
                                        <td><?php echo htmlspecialchars($product->unit); ?></td>
                                        <td>
                                            <input id="discardReason_<?php echo $product->id; ?>" type="text" name="reason" placeholder="Motivo del descarte" value="<?php echo htmlspecialchars($reason); ?>">
                                        </td>
                                        <td><?php echo htmlspecialchars($q); ?></td>
                                        <td style="width:250px;">
                                            <form class="discard-form" method="post" action="index.php?view=addtodiscard">
                                                <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                                <input type="hidden" name="reason" id="reason_<?php echo $product->id; ?>" value="">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" required name="q" placeholder="Cantidad ..." pattern="[0-9]+" title="Ingresa una cantidad válida" min="1">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Agregar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                <?php else: $products_in_cero++; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if($products_in_cero > 0) {
                    echo "<p class='alert alert-warning'>Se omitieron <b>$products_in_cero productos</b> que no tienen existencias en el inventario. <a href='index.php?module=inventary'>Ir al Inventario</a></p>";
                } ?>
            <?php
            else:
                echo "<p class='alert alert-danger'>No se encontró el producto</p>";
            endif;
            ?>
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
        // Al enviar el formulario, asegurarse de que el motivo de descarte se envíe correctamente
        $(".discard-form").on("submit", function(e) {
            e.preventDefault(); // Evitar envío predeterminado

            let productId = $(this).find("input[name='product_id']").val();
            let discardReason = $(`#discardReason_${productId}`).val(); // Tomar el valor del motivo de descarte

            $(this).find(`#reason_${productId}`).val(discardReason); // Asignar el motivo al campo hidden

            $(this).off("submit").submit(); // Enviar el formulario después de asignar
        });

        // Manejo del modal para ampliar imágenes
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
    });
</script>
<?php endif; ?>
