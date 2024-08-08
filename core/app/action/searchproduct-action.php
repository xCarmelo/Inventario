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
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Unidad</th>
                                <th>Precio unitario</th>
                                <th>Precio a vender</th>
                                <th>En inventario</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $products_in_cero = 0;

                            foreach ($products as $product):
                                $q = OperationData::getQYesF($product->id);
                                $product_id_to_find = $product->id; // Usar el ID del producto para buscar

                                $newprice = number_format($product->price_out); // Precio por defecto
                                
                                if (isset($_SESSION["cart"]) && is_array($_SESSION["cart"])) {
                                    $cart = $_SESSION["cart"];
                                    foreach ($cart as $item) {
                                        if ($item["product_id"] == $product_id_to_find) {
                                            $newprice = $item["newprice"];
                                            break;
                                        }
                                    }
                                }

                                if ($q > 0):
                                    ?>
                                    <tr class="<?php echo ($q <= $product->inventary_min) ? 'table-danger' : ''; ?>">
                                        <td style="width:80px;"><?php echo $product->id; ?></td>
                                        <td><?php echo $product->name; ?></td>
                                        <td><?php echo $product->unit; ?></td>
                                        <td>C$ <?php echo number_format($product->price_out); ?></td>
                                        <td>
                                            <input id="newprice" type="number" value="<?php echo $newprice; ?>" placeholder="<?php echo number_format($newprice); ?>" pattern="^[1-9]\d*$">
                                        </td>
                                        <td><?php echo $q; ?></td>
                                        <td style="width:250px;">
                                            <form method="post" action="index.php?view=addtocart">
                                                <input id="priceProduct" type="hidden" name="newprice" value="<?php echo $newprice; ?>" placeholder="<?php echo number_format($product->price_out); ?>">
                                                <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                                <div class="input-group">
                                                    <script>
                                                        $(document).ready(function() {
                                                            const newPriceInput = document.getElementById("newprice");

                                                            $("#newprice").on("keydown", function(event) {
                                                                if ($(this).val().length === 1) {
                                                                    $("#priceProduct").val($("#priceProduct").attr("placeholder"));
                                                                }
                                                            });

                                                            newPriceInput.addEventListener("keyup", function() {
                                                                let newPrice = $("#newprice").val();
                                                                let priceProductInput = $("#priceProduct");

                                                                if (newPrice > 0) {
                                                                    priceProductInput.val(newPrice);
                                                                }
                                                            });
                                                        });
                                                    </script>
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
<?php endif; ?>
