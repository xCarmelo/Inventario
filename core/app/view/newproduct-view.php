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
                    <label for="image" class="form-label" accept="image/jpeg,image/png">Imagen</label>
                    <input title="Solo se permiten archivos jpeg, JPG y PNG" type="file" name="image" id="image" class="form-control <?php echo isset($_SESSION['errors']['image']) ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?php echo isset($_SESSION['errors']['image']) ? $_SESSION['errors']['image'] : ''; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="name" class="form-label">Nombre*</label> 
                    <input type="text" name="name" id="name" class="form-control <?php echo isset($_SESSION['errors']['name']) ? 'is-invalid' : ''; ?>" 
                        value="<?php echo isset($_SESSION['form_data']['name']) ? $_SESSION['form_data']['name'] : ''; ?>" 
                        placeholder="Nombre del Producto" 
                        pattern="^[A-Za-zÁÉÍÓÚÑáéíóúñ\s0-9\-\'\.]{1,100}$" 
                        title="El nombre del producto solo puede contener letras, números, espacios, guiones y puntos. Debe tener entre 1 y 100 caracteres."
                        required>
                    <div class="invalid-feedback">
                        <?php echo isset($_SESSION['errors']['name']) ? $_SESSION['errors']['name'] : ''; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="category_id" class="form-label">Categoría*</label>
                    <select name="category_id" class="form-control <?php echo isset($_SESSION['errors']['category_id']) ? 'is-invalid' : ''; ?>">
                        <option value="0">-- NINGUNA --</option>
                        <?php foreach($categories as $category): if($category->is_active == 1 ):?>
                                
                            <option value="<?php echo $category->id; ?>" <?php echo isset($_SESSION['form_data']['category_id']) && $_SESSION['form_data']['category_id'] == $category->id ? 'selected' : ''; ?>>
                                <?php echo $category->name; ?>
                            </option>
                        <?php endif; endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        <?php echo isset($_SESSION['errors']['category_id']) ? $_SESSION['errors']['category_id'] : ''; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="price_in" class="form-label">Precio de Entrada*</label>
                    <input type="text" name="price_in" id="price_in" class="form-control <?php echo isset($_SESSION['errors']['price_in']) ? 'is-invalid' : ''; ?>" 
                        value="<?php echo isset($_SESSION['form_data']['price_in']) ? $_SESSION['form_data']['price_in'] : ''; ?>" 
                        placeholder="Precio de entrada" 
                        pattern="^[0-9]{1,10}(\.[0-9]{1,3})?$" 
                        title="El precio de entrada debe ser un número positivo de hasta 10 dígitos"
                        required>
                    <div class="invalid-feedback">
                        <?php echo isset($_SESSION['errors']['price_in']) ? $_SESSION['errors']['price_in'] : ''; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="price_out" class="form-label">Precio de Salida*</label>
                    <input type="text" name="price_out" id="price_out" class="form-control <?php echo isset($_SESSION['errors']['price_out']) ? 'is-invalid' : ''; ?>" 
                        value="<?php echo isset($_SESSION['form_data']['price_out']) ? $_SESSION['form_data']['price_out'] : ''; ?>" 
                        placeholder="Precio de salida" 
                        pattern="^[0-9]{1,10}(\.[0-9]{1,3})?$" 
                        title="El precio de salida debe ser un número positivo de hasta 10 dígitos."
                        required>
                    <div class="invalid-feedback">
                        <?php echo isset($_SESSION['errors']['price_out']) ? $_SESSION['errors']['price_out'] : ''; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <input hidden type="text" value="Sin presentacion" name="presentation">
                </div>

                <div class="col-md-6">
                    <label for="inventary_min" class="form-label">Mínima en Inventario*</label>
                    <input type="number" name="inventary_min" id="inventary_min" class="form-control <?php echo isset($_SESSION['errors']['inventary_min']) ? 'is-invalid' : ''; ?>" 
                        value="<?php echo isset($_SESSION['form_data']['inventary_min']) ? $_SESSION['form_data']['inventary_min'] : ''; ?>" 
                        placeholder="Mínima en Inventario" 
                        pattern="^[1-9][0-9]{0,3}$" 
                        title="El inventario mínimo debe ser un número entero positivo entre 1 y 9999.">
                    <div class="invalid-feedback">
                        <?php echo isset($_SESSION['errors']['inventary_min']) ? $_SESSION['errors']['inventary_min'] : ''; ?>
                    </div>
                </div>

                <div class="col-md-12">
                    <label for="description" class="form-label">Descripción*</label>
                    <textarea name="description" id="description" class="form-control <?php echo isset($_SESSION['errors']['description']) ? 'is-invalid' : ''; ?>" 
                            placeholder="Descripción del Producto" 
                            pattern="^[A-Za-zÁÉÍÓÚÑáéíóúñ\s0-9\-'\.,!?¡¿]{3,1000}$" 
                            title="La descripción puede contener letras, números, signos de puntuación básicos y debe tener entre 3 y 1000 caracteres."><?php echo isset($_SESSION['form_data']['description']) ? $_SESSION['form_data']['description'] : ''; ?></textarea>
                    <div class="invalid-feedback">
                        <?php echo isset($_SESSION['errors']['description']) ? $_SESSION['errors']['description'] : ''; ?>
                    </div>
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

<!-- Modal de éxito -->
<?php if (isset($_SESSION['success'])) : ?>
    <div class="modal fade show" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">
                        <i class="bi bi-check-circle text-success"></i> Éxito
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo $_SESSION['success']; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <a href="index.php?view=products" class="btn btn-primary">Ir a Productos</a>
                </div>
            </div>
        </div> 
    </div>

    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<!-- Modal de error -->
<?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) : ?>
    <div class="modal fade show" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">
                        <i class="bi bi-exclamation-circle text-danger"></i> Error
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                            <li>Hubo un error al agregar el producto. Por favor, inténtalo de nuevo.</li>
                    </ul>
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
    // Show modals if they exist
    if ($('#successModal').length > 0) {
        var successModalEl = document.getElementById('successModal');
        var successModal = new bootstrap.Modal(successModalEl);
        successModal.show();
    }
    if ($('#errorModal').length > 0) {
        var errorModalEl = document.getElementById('errorModal');
        var errorModal = new bootstrap.Modal(errorModalEl);
        errorModal.show();
    }

    // Mostrar errores específicos del formulario si existen en la sesión
    if (typeof errores !== 'undefined') {
        // Iterar sobre los errores y mostrarlos en el formulario
        Object.keys(errores).forEach(function(key) {
            var errorElement = document.getElementById(key + '_error');
            if (errorElement) {
                errorElement.textContent = errores[key];
                errorElement.style.display = 'block';
            }
        });
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
