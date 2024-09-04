<?php
$product = ProductData::getById($_GET["id"]);
$categories = CategoryData::getAll();

if($product!=null): 
?>

<div class="card">
    <div class="card-header text-white">
        <?php echo $product->name ?> <small>Editar Producto</small>
    </div>
    <div class="card-body">
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
                        <!-- Puedes añadir botones aquí si es necesario -->
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

        <form class="row g-3" method="post" enctype="multipart/form-data" action="index.php?view=updateproduct&id=<?php echo $product->id; ?>" role="form">
            <div class="col-md-6">
                <label for="image" class="form-label">Imagen*</label>
                <input type="file" name="image" id="image" accept="image/*" class="form-control" placeholder="">
                <?php if($product->image!=""):?>
                    <br>
                    <img src="storage/products/<?php echo $product->image;?>" class="img-thumbnail" style="max-width: 150px;">
                <?php endif;?>
            </div>

            <div class="col-md-6">
                <label for="name" class="form-label">Nombre*</label>
                <input type="text" name="name" class="form-control" id="name" value="<?php echo $product->name; ?>" placeholder="Nombre del Producto" required>
                
                <div class="col-md-12 mt-5">
                    <label for="category_id" class="form-label">Categoría</label>
                    <select name="category_id" class="form-control">
                        <option value="">-- NINGUNA --</option>
                        <?php foreach($categories as $category):?>
                            <option value="<?php echo $category->id;?>" <?php if($product->category_id!=null && $product->category_id==$category->id){ echo "selected";}?>><?php echo $category->name;?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <label for="price_in" class="form-label">Precio de Entrada*</label>
                <input type="number" name="price_in" class="form-control" value="<?php echo $product->price_in; ?>" id="price_in" placeholder="Precio de entrada" required title="Ingresa un precio válido" step="0.01">
            </div>

            <div class="col-md-6">
                <label for="price_out" class="form-label">Precio de Salida*</label>
                <input type="number" name="price_out" class="form-control" id="price_out" value="<?php echo $product->price_out; ?>" placeholder="Precio de salida" required title="Ingresa un precio válido">
            </div>

            <div class="col-md-6">
                <label for="presentation" class="form-label">Presentación</label>
                <input type="text" name="presentation" class="form-control" id="presentation" value="<?php echo $product->presentation; ?>" placeholder="Presentación del Producto" title="Ingresa una presentación válida">
            </div>

            <div class="col-md-6">
                <label for="inventary_min" class="form-label">Mínima en inventario:</label>
                <input type="number" name="inventary_min" class="form-control" value="<?php echo $product->inventary_min;?>" id="inventary_min" placeholder="Mínima en Inventario (Default 10)" required title="Ingresa un valor numérico">
            </div>
            
            <div class="col-md-6">
                <label for="description" class="form-label">Descripción</label>
                <textarea name="description" class="form-control" id="description" placeholder="Descripción del Producto" required title="Ingresa una descripción válida"><?php echo $product->description;?></textarea>
            </div>

            <div class="col-md-6">
                <label for="is_active" class="form-label">¿Está activo?</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" <?php if($product->is_active){ echo "checked";}?>> 
                </div>
            </div>


            <div class="col-12">
                <p class="alert alert-info">* Campos obligatorios</p>
            </div>

            <div class="col-12">
                <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                <button type="submit" class="btn btn-success">Actualizar Producto</button>
            </div>
        </form>
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
