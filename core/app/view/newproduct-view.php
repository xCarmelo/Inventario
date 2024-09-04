<?php 
$categories = CategoryData::getAll();
?>
<div class="row">
    <div class="col-md-12">
        <h1>Nuevo Producto</h1> 

        <div class="card">
    <div class="card-header text-white">Agregar Producto</div>
    <div class="card-body">
        <form class="row g-3" method="post" enctype="multipart/form-data" id="addproduct" action="index.php?view=addproduct" role="form">
            <div class="col-md-6">
                <label for="image" class="form-label">Imagen</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label for="name" class="form-label">Nombre*</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Nombre del Producto" title="Ingresa el nombre del producto" required>
            </div>
            
            <div class="col-md-6">
                <label for="category_id" class="form-label">Categoría</label>
                <select name="category_id" class="form-control">
                    <option value="">-- NINGUNA --</option>
                    <?php foreach($categories as $category): ?>
                        <option value="<?php echo $category->id;?>"><?php echo $category->name;?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-6">
                <label for="price_in" class="form-label">Precio de Entrada*</label>
                <input type="number" name="price_in" id="price_in" class="form-control" placeholder="Precio de entrada" title="Ingresa el precio de entrada como un número" min="0" step="0.01" required>
            </div>
                        
            <div class="col-md-6">
                <label for="price_out" class="form-label">Precio de Salida*</label>
                <input type="number" name="price_out" id="price_out" class="form-control" placeholder="Precio de salida" title="Ingresa un número positivo" min="0" step="0.01" required>
            </div>
            
            <div class="col-md-6">
                <label for="presentation" class="form-label">Presentación</label>
                <input type="text" name="presentation" id="presentation" class="form-control" placeholder="Presentación del Producto">
            </div>
            
            <div class="col-md-6">
                <label for="inventary_min" class="form-label">Mínima en Inventario</label>
                <input type="number" name="inventary_min" id="inventary_min" class="form-control" placeholder="Mínima en Inventario (Default 10)" title="Ingresa un número positivo" min="0" step="1">
            </div>

            <div class="col-md-12">
                <label for="description" class="form-label">Descripción</label>
                <textarea name="description" id="description" class="form-control" placeholder="Descripción del Producto" title="Ingresa una descripción del producto"></textarea>
            </div>

            <div class="col-12">
                <p class="alert alert-info">* Campos obligatorios</p>
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Agregar Producto</button>
            </div>
        </form>
    </div>
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
