<?php if(isset($_GET["product"])): ?>
    <?php
    // Se obtienen los productos que coinciden con la búsqueda
    $products = ProductData::getLike($_GET["product"]); 
    if(count($products) > 0): ?>
    
    <h3>Resultados de la Búsqueda</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Unidad</th>
                    <th>Precio unitario</th>
                    <th>En inventario</th>
                    <th>Cantidad</th>
                    <th style="width:100px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $products_in_cero = 0;
                foreach($products as $product):
                    if($product->isa_ctive != 0):
                    $q = OperationData::getQYesF($product->id);
                    
                    // Si hay productos en inventario
                    if($q > 0): ?>
                        <tr class="<?php echo ($q <= $product->inventary_min) ? 'table-danger' : ''; ?>">
                            <td style="width:80px;"><?php echo htmlspecialchars($product->id); ?></td>
                            <td><?php echo htmlspecialchars($product->name); ?></td>
                            <td><?php echo htmlspecialchars($product->unit); ?></td>
                            <td><b>C$<?php echo htmlspecialchars($product->price_out); ?></b></td>
                            <td><?php echo htmlspecialchars($q); ?></td>
                            <td>
                                <form method="post" action="index.php?view=addtocart">
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product->id); ?>">
                                    <input type="number" class="form-control" required name="q" placeholder="Cantidad de producto ...">
                                    <td style="width:183px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="glyphicon glyphicon-shopping-cart"></i> Agregar a la venta
                                        </button>
                                    </td>
                                </form>
                            </td>
                        </tr>
                    <?php else: 
                        $products_in_cero++;
                    endif;
                endif; endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($products_in_cero > 0): ?>
        <p class='alert alert-warning'>
            Se omitieron <b><?php echo htmlspecialchars($products_in_cero); ?> productos</b> que no tienen existencias en el inventario. 
            <a href='index.php?module=inventary'>Ir al Inventario</a>
        </p>
    <?php endif; ?>

    <?php endif; ?>
    <br><hr><hr><br>
<?php endif; ?>
