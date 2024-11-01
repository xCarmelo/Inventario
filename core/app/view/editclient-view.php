<?php
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if ($id === false) {
    // Redirigir a una página de error o mostrar un mensaje de error
    header("Location: index.php?view=clients");
    exit;
}

 $user = PersonData::getById($_GET["id"]);?> 
<div class="row">
    <div class="col-md-12">
        <h1>Editar Cliente</h1>
        <br> 
        <div class="card">
            <div class="card-header">
                EDITAR CLIENTE
            </div>
            <div class="card-body">
            <form class="form-horizontal" method="post" id="editclient" action="index.php?view=updateclient" role="form">
                <div class="row">
                    <div class="col-md-4">
                        <label for="validationCustom01" class="form-label">Nombre*</label>
                        <input value="<?php echo isset($_SESSION['form_data']['name']) ? $_SESSION['form_data']['name'] : $user->name; ?>" type="text" name="name" class="form-control <?php echo isset($_SESSION['errors']['name']) ? 'is-invalid' : ''; ?>" id="validationCustom01" placeholder="Nombre" pattern="^[A-Za-zÁÉÍÓÚÑáéíóúñ\s0-9\-'\.]{1,100}$" title="El nombre del producto solo puede contener letras, números, espacios, guiones y puntos. Debe tener entre 1 y 100 caracteres." required>
                        <div class="invalid-feedback">
                            <?php echo isset($_SESSION['errors']['name']) ? $_SESSION['errors']['name'] : ''; ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="validationCustom02" class="form-label">Precio de Entrada*</label>
                        <input value="<?php echo isset($_SESSION['form_data']['price_in']) ? $_SESSION['form_data']['price_in'] : ''; ?>" type="text" name="price_in" class="form-control <?php echo isset($_SESSION['errors']['price_in']) ? 'is-invalid' : ''; ?>" id="validationCustom02" placeholder="Precio de Entrada" pattern="^[0-9]{1,10}(\.[0-9]{1,3})?$" title="El precio de entrada debe ser un número positivo de hasta 10 dígitos y sin decimales." required>
                        <div class="invalid-feedback">
                            <?php echo isset($_SESSION['errors']['price_in']) ? $_SESSION['errors']['price_in'] : ''; ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="validationCustom03" class="form-label">Precio de Salida*</label>
                        <input value="<?php echo isset($_SESSION['form_data']['price_out']) ? $_SESSION['form_data']['price_out'] : ''; ?>" type="text" name="price_out" class="form-control <?php echo isset($_SESSION['errors']['price_out']) ? 'is-invalid' : ''; ?>" id="validationCustom03" placeholder="Precio de Salida" pattern="^[0-9]{1,10}(\.[0-9]{1,3})?$" title="El precio de salida debe ser un número positivo de hasta 10 dígitos y sin decimales." required>
                        <div class="invalid-feedback">
                            <?php echo isset($_SESSION['errors']['price_out']) ? $_SESSION['errors']['price_out'] : ''; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="validationCustom04" class="form-label mt-2">Categoría*</label>
                        <input value="<?php echo isset($_SESSION['form_data']['category_id']) ? $_SESSION['form_data']['category_id'] : ''; ?>" type="text" name="category_id" class="form-control <?php echo isset($_SESSION['errors']['category_id']) ? 'is-invalid' : ''; ?>" id="validationCustom04" placeholder="ID de Categoría" pattern="^[1-9][0-9]*$" title="Debes seleccionar una categoría válida." required>
                        <div class="invalid-feedback">
                            <?php echo isset($_SESSION['errors']['category_id']) ? $_SESSION['errors']['category_id'] : ''; ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="validationCustom05" class="form-label mt-2">Presentación*</label>
                        <input value="<?php echo isset($_SESSION['form_data']['presentation']) ? $_SESSION['form_data']['presentation'] : ''; ?>" type="text" name="presentation" class="form-control <?php echo isset($_SESSION['errors']['presentation']) ? 'is-invalid' : ''; ?>" id="validationCustom05" placeholder="Presentación" pattern="^[A-Za-zÁÉÍÓÚÑáéíóúñ\s\-'\.0-9]{2,50}$" title="La presentación debe tener entre 2 y 50 caracteres, y solo puede contener letras, números, espacios, guiones y puntos." required>
                        <div class="invalid-feedback">
                            <?php echo isset($_SESSION['errors']['presentation']) ? $_SESSION['errors']['presentation'] : ''; ?>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <label for="validationCustom06" class="form-label mt-2">Descripción*</label>
                        <input value="<?php echo isset($_SESSION['form_data']['description']) ? $_SESSION['form_data']['description'] : ''; ?>" type="text" name="description" class="form-control <?php echo isset($_SESSION['errors']['description']) ? 'is-invalid' : ''; ?>" id="validationCustom06" placeholder="Descripción" pattern="^[A-Za-zÁÉÍÓÚÑáéíóúñ\s0-9\-'\.,!?¡¿]{3,1000}$" title="La descripción puede contener letras, números, signos de puntuación básicos y debe tener entre 3 y 1000 caracteres." required>
                        <div class="invalid-feedback">
                            <?php echo isset($_SESSION['errors']['description']) ? $_SESSION['errors']['description'] : ''; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="validationCustom07" class="form-label mt-2">Inventario Mínimo*</label>
                        <input value="<?php echo isset($_SESSION['form_data']['inventary_min']) ? $_SESSION['form_data']['inventary_min'] : ''; ?>" type="text" name="inventary_min" class="form-control <?php echo isset($_SESSION['errors']['inventary_min']) ? 'is-invalid' : ''; ?>" id="validationCustom07" placeholder="Inventario Mínimo" pattern="^[1-9][0-9]{0,3}$" title="El inventario mínimo debe ser un número entero positivo entre 1 y 9999." required>
                        <div class="invalid-feedback">
                            <?php echo isset($_SESSION['errors']['inventary_min']) ? $_SESSION['errors']['inventary_min'] : ''; ?>
                        </div>
                    </div>
                </div>

                <p class="alert alert-info mt-4">* Campos obligatorios</p>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-primary">Actualizar Producto</button>
                    </div>
                </div>
            </form>

                <?php
                // Limpiar los errores y los datos de sesión después de usarlos
                unset($_SESSION['form_data']);
                ?>
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
                    <h5 class="modal-title" id="successModalLabel">¡Éxito!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo $_SESSION['success']; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <a href="index.php?view=clients" class="btn btn-primary">Ir a Clientes</a> <!-- Segundo botón -->
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
                    <h5 class="modal-title" id="errorModalLabel">¡Error!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                            <li>Error al editar al cliente</li>
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
        // Mostrar el modal de éxito si está presente
        $('#successModal').modal('show');

        // Mostrar el modal de error si está presente
        $('#errorModal').modal('show');

        // Si existe un parámetro 'result' en la URL, eliminar solo ese parámetro
        const url = new URL(window.location.href);
        if (url.searchParams.get('result')) {
            url.searchParams.delete('result'); // Eliminar solo el parámetro 'result'

            // Actualizar la URL sin recargar la página, manteniendo otros parámetros como 'view'
            window.history.replaceState({}, document.title, url.pathname + "?" + url.searchParams.toString());
        }
    });
</script>
