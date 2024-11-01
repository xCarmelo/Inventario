<?php 
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if ($id === false) {
    // Redirigir a una página de error o mostrar un mensaje de error
    header("Location: index.php?view=products");
    exit;
}

$product = ProductData::getById($id);
$categories = CategoryData::getAll(); 
?>

<div class="row">
    <div class="col-md-12"> 
        <h1>Editar Producto</h1>

        <div class="card">
            <div class="card-header text-white">Editar Producto</div>
            <div class="card-body">
                <form class="row g-3" method="post" enctype="multipart/form-data" id="editproduct" action="index.php?view=updateproduct" role="form">
                <div class="col-md-6">
                    <label for="image" class="form-label">Imagen</label>
                    <input type="file" name="image" id="image" class="form-control <?php echo isset($_SESSION['errors']['image']) ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?php echo isset($_SESSION['errors']['image']) ? $_SESSION['errors']['image'] : ''; ?>
                    </div>

                    <div class="form-group">
                        <label for="current_image">Imagen actual</label>
                        <div class="mb-3">
                            <?php if (!empty($product->image)):?>
                                <img src="storage/products/<?php echo $product->image; ?>" alt="Imagen del producto" class="img-thumbnail" style="max-width: 200px;">
                            <?php else: ?>
                                <p>No hay imagen disponible para este producto.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="name" class="form-label">Nombre*</label>
                    <input type="text" name="name" id="name" class="form-control <?php echo isset($_SESSION['errors']['name']) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_SESSION['form_data']['name']) ? $_SESSION['form_data']['name'] : $product->name; ?>" placeholder="Nombre del Producto" pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ\s0-9]{2,80}$" title="Ingresa el nombre del producto" required>
                    <div class="invalid-feedback">
                        <?php echo isset($_SESSION['errors']['name']) ? $_SESSION['errors']['name'] : ''; ?>
                    </div>
                    <div class="col-md-12 mt-5">
                        <label for="category_id" class="form-label">Categoría*</label>
                        <select name="category_id" class="form-control <?php echo isset($_SESSION['errors']['category_id']) ? 'is-invalid' : ''; ?>">
                            <option value="0">-- NINGUNA --</option>
                            <?php foreach($categories as $category): ?>
                                <option value="<?php echo $category->id;?>" <?php echo (isset($_SESSION['form_data']['category_id']) ? $_SESSION['form_data']['category_id'] : $product->category_id) == $category->id ? 'selected' : ''; ?>>
                                    <?php echo $category->name;?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?php echo isset($_SESSION['errors']['category_id']) ? $_SESSION['errors']['category_id'] : ''; ?>
                        </div>
                    </div>
    
                    <div class="col-md-12 mt-5">
                        <label for="price_in" class="form-label">Precio de Entrada*</label>
                        <input type="text" id="miNumero" name="price_in" id="price_in" class="form-control <?php echo isset($_SESSION['errors']['price_in']) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_SESSION['form_data']['price_in']) ? $_SESSION['form_data']['price_in'] : $product->price_in; ?>" placeholder="Precio de entrada" min="0" step="0.01" title="Ingresa el precio de entrada como un número" required>
                        <div class="invalid-feedback">
                            <?php echo isset($_SESSION['errors']['price_in']) ? $_SESSION['errors']['price_in'] : ''; ?>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <label for="price_out" class="form-label">Precio de Salida*</label>
                    <input type="text" id="miNumero" name="price_out" id="price_out" class="form-control <?php echo isset($_SESSION['errors']['price_out']) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_SESSION['form_data']['price_out']) ? $_SESSION['form_data']['price_out'] : $product->price_out; ?>" placeholder="Precio de salida" min="0" step="0.01" title="Ingresa un número positivo" required>
                    <div class="invalid-feedback">
                        <?php echo isset($_SESSION['errors']['price_out']) ? $_SESSION['errors']['price_out'] : ''; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <input hidden type="text" value="Sin presentacion" name="presentation" id="presentation" class="form-control <?php echo isset($_SESSION['errors']['presentation']) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_SESSION['form_data']['presentation']) ? $_SESSION['form_data']['presentation'] : $product->presentation; ?>" placeholder="Presentación del Producto">
                </div>

                <div class="col-md-6">
                    <label for="inventary_min" class="form-label">Mínima en Inventario*</label>
                    <input type="number" name="inventary_min" id="inventary_min" class="form-control <?php echo isset($_SESSION['errors']['inventary_min']) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_SESSION['form_data']['inventary_min']) ? $_SESSION['form_data']['inventary_min'] : $product->inventary_min; ?>" placeholder="Mínima en Inventario">
                    <div class="invalid-feedback">
                        <?php echo isset($_SESSION['errors']['inventary_min']) ? $_SESSION['errors']['inventary_min'] : ''; ?>
                    </div> 
                </div>
 
                <div class="col-md-6">
                    <label for="is_active" class="form-label">¿Está activo?</label>
                    <div class="form-check">
                        <input class="form-check-input <?php echo isset($_SESSION['errors']['is_active']) ? 'is-invalid' : ''; ?>" type="checkbox" name="is_active" <?php if($product->is_active){ echo "checked";}?>>
                        <div class="invalid-feedback">
                            <?php if (isset($_SESSION['errors']['is_active'])) { ?>
                                <?= $_SESSION['errors']['is_active'] ?>
                            <?php } ?>
                        </div>
                    </div>
                </div> 

                <div class="col-md-12">
                    <label for="description" class="form-label">Descripción*</label>
                    <textarea name="description" id="description" class="form-control <?php echo isset($_SESSION['errors']['description']) ? 'is-invalid' : ''; ?>" placeholder="Descripción del Producto"><?php echo isset($_SESSION['form_data']['description']) ? $_SESSION['form_data']['description'] : $product->description; ?></textarea>
                    <div class="invalid-feedback">
                        <?php echo isset($_SESSION['errors']['description']) ? $_SESSION['errors']['description'] : ''; ?>
                    </div>
                </div>

                <div class="col-12">
                    <p class="alert alert-info">* Campos obligatorios</p>
                </div>
                
                <div class="col-12">
                    <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                    <button type="submit" class="btn btn-primary">Actualizar Producto</button>
                </div>
            </form>
            <?php
                unset($_SESSION['form_data']);
                ?>
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
                El producto se actualizo correctamente.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a href="index.php?view=products" class="btn btn-primary">Continuar</a>
            </div>
        </div>
    </div>
</div> 


<?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) : ?>
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
                Hubo un error al editar el producto. Por favor, inténtalo de nuevo.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div> 
    </div> 
</div>
<?php unset($_SESSION['errors']); ?>
<?php endif; ?> 

<script>
$(document).ready(function() {
    // Verificar si se pasó un parámetro en la URL para mostrar el modal correspondiente
    const urlParams = new URLSearchParams(window.location.search);
    const result = urlParams.get('result');
    if (result === 'success') {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    } 
    



    // Validar que el precio de entrada y salida sean numero y puedan inpluir decimales
    function validarNumero() {
    const numero = document.getElementById("miNumero").value;
      const regex = /^[0-9]*(\.[0-9]+)?$/; // Permite cualquier número decimal
    if (!regex.test(numero)) {
        alert("Por favor, ingresa un número válido");
    }
    }

    // Si existe un parámetro 'result' en la URL, eliminar solo ese parámetro
    const url = new URL(window.location.href);
        if (url.searchParams.get('result')) {
            url.searchParams.delete('result'); // Eliminar solo el parámetro 'result'

            // Actualizar la URL sin recargar la página, manteniendo otros parámetros como 'view'
            window.history.replaceState({}, document.title, url.pathname + "?" + url.searchParams.toString());
        }
});

</script>
