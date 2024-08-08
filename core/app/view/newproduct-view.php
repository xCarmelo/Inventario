<?php 
$categories = CategoryData::getAll();
?>
<div class="row">
    <div class="col-md-12">
        <h1>Nuevo Producto</h1>

        <div class="card">
            <div class="card-header">
                NUEVO PRODUCTO  
            </div>
            <div class="card-body">

                <form class="form-horizontal" method="post" enctype="multipart/form-data" id="addproduct" action="index.php?view=addproduct" role="form">

                    <div class="form-group">
                        <label for="image" class="col-lg-2 control-label">Imagen</label>
                        <div class="col-md-6">
                            <input type="file" name="image" id="image" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="barcode" class="col-lg-2 control-label">Codigo de Barras*</label>
                        <div class="col-md-6">
                            <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Codigo de Barras del Producto" title="Ingresa un código de barras válido">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-lg-2 control-label">Nombre*</label>
                        <div class="col-md-6">
                            <input type="text" name="name" required class="form-control" id="name" placeholder="Nombre del Producto" title="Ingresa el nombre del producto">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="col-lg-2 control-label">Categoria</label>
                        <div class="col-md-6">
                            <select name="category_id" class="form-control">
                                <option value="">-- NINGUNA --</option>
                                <?php foreach($categories as $category): ?>
                                    <option value="<?php echo $category->id;?>"><?php echo $category->name;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-lg-2 control-label">Descripcion</label>
                        <div class="col-md-6">
                            <textarea name="description" class="form-control" id="description" placeholder="Descripcion del Producto" title="Ingresa una descripción del producto"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price_in" class="col-lg-2 control-label">Precio de Entrada*</label>
                        <div class="col-md-6">
                            <input type="number" name="price_in" required class="form-control" id="price_in" placeholder="Precio de entrada" title="Ingresa el precio de entrada como un número">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price_out" class="col-lg-2 control-label">Precio de Salida*</label>
                        <div class="col-md-6">
                            <input type="number" name="price_out" required class="form-control" id="price_out" placeholder="Precio de salida" title="Ingresa un número positivo" pattern="[0-9]+">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="unit" class="col-lg-2 control-label">Unidad*</label>
                        <div class="col-md-6">
                            <input type="text" name="unit" required class="form-control" id="unit" placeholder="Unidad del Producto">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="presentation" class="col-lg-2 control-label">Presentación</label>
                        <div class="col-md-6">
                            <input type="text" name="presentation" class="form-control" id="presentation" placeholder="Presentación del Producto">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inventary_min" class="col-lg-2 control-label">Mínima en inventario:</label>
                        <div class="col-md-6">
                            <input type="number" name="inventary_min" class="form-control" id="inventary_min" placeholder="Mínima en Inventario (Default 10)" title="Ingresa un número positivo" pattern="[0-9]+">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="q" class="col-lg-2 control-label">Inventario inicial:</label>
                        <div class="col-md-6">
                            <input type="number" name="q" class="form-control" id="q" placeholder="Inventario inicial" title="Ingresa un número positivo" pattern="[0-9]+">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-primary">Agregar Producto</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Modal de éxito -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">
                    <i class="bi bi-check-circle text-success"></i> Éxito
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                El producto se agregó correctamente.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="successCloseBtn">Cerrar</button>
                <a href="index.php?view=products" class="btn btn-primary">Continuar</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal de error -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">
                    <i class="bi bi-exclamation-circle text-danger"></i> Error
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Hubo un error al agregar el producto. Por favor, inténtalo de nuevo.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    // Verificar si se pasó un parámetro en la URL para mostrar el modal correspondiente
    const urlParams = new URLSearchParams(window.location.search);
    const result = urlParams.get('result');
    if (result === 'success') {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    } else if (result === 'error') {
        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    }

    // Redirigir a la lista de productos cuando se cierra el modal de éxito
    var successModalEl = document.getElementById('successModal');
    successModalEl.addEventListener('hide.bs.modal', function () {
        window.location.href = 'index.php?view=products';
    });

    // Redirigir a la lista de productos cuando se hace clic en el botón "Cerrar" del modal de éxito
    $('#successCloseBtn').click(function() { 
        window.location.href = 'index.php?view=products';
    });
});
</script>
