<?php
$product = ProductData::getById($_GET["id"]);
$categories = CategoryData::getAll();

if($product!=null): 
?>

<div class="row">
    <div class="col-md-12">
        <h1><?php echo $product->name ?> <small>Editar Producto</small></h1>

        <!-- Modal -->
        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Producto Actualizado</h5>
                    </div>
                    <div class="modal-body">
                        La información del producto se ha actualizado exitosamente.
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

        <!-- Mostrar modal si se ha actualizado el producto -->
        <?php if (isset($_GET['updated'])): ?>
            <script>
                $(document).ready(function(){
                    $('#updateModal').modal('show');
                    setTimeout(function(){
                        window.location.href = 'index.php?view=products'; // Cambia 'products' a la vista o URL que deseas redirigir
                    }, 2000); // Redirigir después de 2 segundos
                });
            </script>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                EDITAR PRODUCTO
            </div>
            <div class="card-body">
                <form class="form-horizontal" method="post" id="addproduct" enctype="multipart/form-data" action="index.php?view=updateproduct&id=<?php echo $product->id; ?>" role="form">
                    <div class="form-group">
                        <label for="image" class="col-lg-3 control-label">Imagen*</label>
                        <div class="col-md-8">
                            <input type="file" name="image" id="image" accept="image/*" class="form-control" placeholder="">
                            <?php if($product->image!=""):?>
                                <br>
                                <img src="storage/products/<?php echo $product->image;?>" class="img-thumbnail" style="max-width: 150px;">
                            <?php endif;?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="barcode" class="col-lg-3 control-label">Código de barras*</label>
                        <div class="col-md-8">
                            <input type="text" name="barcode" class="form-control" id="barcode" value="<?php echo $product->barcode; ?>" placeholder="Código de barras del Producto" required pattern="[0-9]+" title="Ingresa un código de barras válido (solo números)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-lg-3 control-label">Nombre*</label>
                        <div class="col-md-8">
                            <input type="text" name="name" class="form-control" id="name" value="<?php echo $product->name; ?>" placeholder="Nombre del Producto" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="category_id" class="col-lg-3 control-label">Categoría</label>
                        <div class="col-md-8">
                            <select name="category_id" class="form-control">
                                <option value="">-- NINGUNA --</option>
                                <?php foreach($categories as $category):?>
                                    <option value="<?php echo $category->id;?>" <?php if($product->category_id!=null && $product->category_id==$category->id){ echo "selected";}?>><?php echo $category->name;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-lg-3 control-label">Descripción</label>
                        <div class="col-md-8">
                            <textarea name="description" class="form-control" id="description" placeholder="Descripción del Producto" required title="Ingresa una descripción válida"><?php echo $product->description;?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="price_in" class="col-lg-3 control-label">Precio de Entrada*</label>
                        <div class="col-md-8">
                            <input type="number" name="price_in" class="form-control" value="<?php echo $product->price_in; ?>" id="price_in" placeholder="Precio de entrada" required title="Ingresa un precio válido" step="0.01">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="price_out" class="col-lg-3 control-label">Precio de Salida*</label>
                        <div class="col-md-8">
                            <input type="number" name="price_out" class="form-control" id="price_out" value="<?php echo $product->price_out; ?>" placeholder="Precio de salida" required title="Ingresa un precio válido">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="unit" class="col-lg-3 control-label">Unidad*</label>
                        <div class="col-md-8">
                            <input type="text" name="unit" class="form-control" id="unit" value="<?php echo $product->unit; ?>" placeholder="Unidad del Producto" required title="Ingresa una unidad válida">
                        </div>
                    </div> 

                    <div class="form-group">
                        <label for="presentation" class="col-lg-3 control-label">Presentación</label>
                        <div class="col-md-8">
                            <input type="text" name="presentation" class="form-control" id="presentation" value="<?php echo $product->presentation; ?>" placeholder="Presentación del Producto" title="Ingresa una presentación válida">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inventary_min" class="col-lg-3 control-label">Mínima en inventario:</label>
                        <div class="col-md-8">
                            <input type="number" name="inventary_min" class="form-control" value="<?php echo $product->inventary_min;?>" id="inventary_min" placeholder="Mínima en Inventario (Default 10)" required title="Ingresa un valor numérico">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="is_active" class="col-lg-3 control-label">¿Está activo?</label>
                        <div class="col-md-8">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_active" <?php if($product->is_active){ echo "checked";}?>> 
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-3 col-lg-8">
                            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                            <button type="submit" class="btn btn-success">Actualizar Producto</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br><br>
    </div>
</div>

<script>
    document.getElementById('addproduct').addEventListener('submit', function(e) {
        var fileInput = document.getElementById('image');
        var filePath = fileInput.value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        if(fileInput.files.length > 0 && !allowedExtensions.exec(filePath)){
            alert('Por favor, cargue un archivo de imagen válido (jpg, jpeg, png, gif).');
            fileInput.value = '';
            e.preventDefault();
        }
    });
</script>

<?php endif; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lógica para actualizar el producto
    $product_id = $_POST['product_id'];
    exit();
}
?>
