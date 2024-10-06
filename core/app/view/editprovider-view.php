<?php 
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if ($id === false) {
    // Redirigir a una página de error o mostrar un mensaje de error
    header("Location: index.php?view=providers");
    exit;
}
$user = PersonData::getById($_GET["id"]); 
?>
<div class="row">
    <div class="col-md-12">
        <h1>Editar Proveedor</h1>
        <br> 
        <div class="card">
            <div class="card-header">
                EDITAR PROVEEDOR
            </div>
            <div class="card-body"> 
                <form class="form-horizontal" method="post" id="updateprovider" action="index.php?view=updateprovider" role="form">
                    <div class="row">
                            <div class="col-md-4">
                                <label for="validationCustom01" class="form-label">Nombre*</label>
                                <input value="<?php echo isset($_SESSION['form_data']['name']) ? $_SESSION['form_data']['name'] : $user->name; ?>" type="text" name="name" class="form-control <?php echo isset($_SESSION['errors']['name']) ? 'is-invalid' : ''; ?>" id="validationCustom01" placeholder="Nombre" pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ\s]{2,80}$" title="Ingresa un nombre válido (solo letras, espacios y acentos) de al menos 2 caracteres" required>
                                <div class="invalid-feedback">
                                    <?php echo isset($_SESSION['errors']['name']) ? $_SESSION['errors']['name'] : ''; ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="validationCustom02" class="form-label">Apellido*</label>
                                <input value="<?php echo isset($_SESSION['form_data']['lastname']) ? $_SESSION['form_data']['lastname'] : $user->lastname; ?>" type="text" name="lastname" class="form-control <?php echo isset($_SESSION['errors']['lastname']) ? 'is-invalid' : ''; ?>" id="validationCustom02" placeholder="Apellido" pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ\s]{2,50}$" title="Ingresa un apellido válido (solo letras, espacios y acentos) de al menos 2 caracteres" required>
                                <div class="invalid-feedback">
                                    <?php echo isset($_SESSION['errors']['lastname']) ? $_SESSION['errors']['lastname'] : ''; ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="validationCustom03" class="form-label">Dirección*</label>
                                <input value="<?php echo isset($_SESSION['form_data']['address1']) ? $_SESSION['form_data']['address1'] : $user->address1; ?>" type="text" name="address1" class="form-control <?php echo isset($_SESSION['errors']['address1']) ? 'is-invalid' : ''; ?>" id="validationCustom03" placeholder="Dirección" pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ0-9\s,-]{5,50}$" title="Ingresa una dirección válida (solo letras, números, espacios, guiones y comas) de al menos 5 caracteres" required>
                                <div class="invalid-feedback">
                                    <?php echo isset($_SESSION['errors']['address1']) ? $_SESSION['errors']['address1'] : ''; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label for="validationCustom04" class="form-label mt-2">Email*</label>
                                <input value="<?php echo isset($_SESSION['form_data']['email1']) ? $_SESSION['form_data']['email1'] : $user->email1; ?>" type="email" name="email1" class="form-control <?php echo isset($_SESSION['errors']['email1']) ? 'is-invalid' : ''; ?>" id="validationCustom04" placeholder="Email" required>
                                <div class="invalid-feedback">
                                    <?php echo isset($_SESSION['errors']['email1']) ? $_SESSION['errors']['email1'] : ''; ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="validationCustom05" class="form-label mt-2">Teléfono*</label>
                                <input value="<?php echo isset($_SESSION['form_data']['phone1']) ? $_SESSION['form_data']['phone1'] : $user->phone1; ?>" type="text" name="phone1" class="form-control <?php echo isset($_SESSION['errors']['phone1']) ? 'is-invalid' : ''; ?>" id="validationCustom05" placeholder="Teléfono" pattern="[0-9]{8}" title="Ingresa un número de teléfono válido (8 dígitos)" required>
                                <div class="invalid-feedback">
                                    <?php echo isset($_SESSION['errors']['phone1']) ? $_SESSION['errors']['phone1'] : ''; ?>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="user_id" value="<?php echo $user->id;?>">
                        
                        <p class="alert alert-info mt-4">* Campos obligatorios</p>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" class="btn btn-primary">Actualizar proveedor</button>
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
                El proveedor se agregó correctamente.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a href="index.php?view=providers" class="btn btn-primary">Continuar</a>
            </div>
        </div>
    </div>
</div> 
<?php unset($_SESSION['success']); ?>
<?php endif; ?>

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
                Hubo un error al editar al proveedor. Por favor, inténtalo de nuevo.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div> 
    </div> 
</div>

<?php unset($_SESSION['errors']);?>
<?php endif; ?>

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

    // Si existe un parámetro 'result' en la URL, eliminar solo ese parámetro
    const url = new URL(window.location.href);
        if (url.searchParams.get('result')) {
            url.searchParams.delete('result'); // Eliminar solo el parámetro 'result'

            // Actualizar la URL sin recargar la página, manteniendo otros parámetros como 'view'
            window.history.replaceState({}, document.title, url.pathname + "?" + url.searchParams.toString());
        }
});
</script>
