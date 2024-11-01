<div class="row">
    <div class="col-md-12">
        <h1>Nuevo Proveedor</h1>
        <br>
        <div class="card">
            <div class="card-header">
                NUEVO PROVEEDOR
            </div>
            <div class="card-body">
            <form class="form-horizontal" method="post" id="addprovider" action="index.php?view=addprovider" role="form">
                <div class="row">
                    <div class="col-md-6">
                        <label for="validationCustom01" class="form-label">Nombre*</label>
                        <input value="<?php echo isset($_SESSION['form_data']['name']) ? $_SESSION['form_data']['name'] : ''; ?>" 
                            type="text" 
                            name="name" 
                            class="form-control <?php echo isset($_SESSION['errors']['name']) ? 'is-invalid' : ''; ?>" 
                            id="validationCustom01" 
                            placeholder="Nombre" 
                            pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ\s]{2,255}$" 
                            title="El nombre debe tener entre 2 y 255 caracteres y solo puede contener letras y espacios." 
                            required>
                        <div class="invalid-feedback">
                            <?php echo isset($_SESSION['errors']['name']) ? $_SESSION['errors']['name'] : ''; ?>
                        </div>
                    </div> 

                    <div class="col-md-6">
                        <label for="validationCustom02" class="form-label">Apellido*</label>
                        <input value="<?php echo isset($_SESSION['form_data']['lastname']) ? $_SESSION['form_data']['lastname'] : ''; ?>" 
                            type="text" 
                            name="lastname" 
                            class="form-control <?php echo isset($_SESSION['errors']['lastname']) ? 'is-invalid' : ''; ?>" 
                            id="validationCustom02" 
                            placeholder="Apellido" 
                            pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ\s]{2,50}$" 
                            title="El apellido debe tener entre 2 y 50 caracteres y solo puede contener letras y espacios." 
                            required>
                        <div class="invalid-feedback">
                            <?php echo isset($_SESSION['errors']['lastname']) ? $_SESSION['errors']['lastname'] : ''; ?>
                        </div>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-md-6 mt-2">
                        <label for="validationCustom03" class="form-label">Dirección*</label>
                        <input value="<?php echo isset($_SESSION['form_data']['address1']) ? $_SESSION['form_data']['address1'] : ''; ?>" 
                            type="text" 
                            name="address1" 
                            class="form-control <?php echo isset($_SESSION['errors']['address1']) ? 'is-invalid' : ''; ?>" 
                            id="validationCustom03" 
                            placeholder="Dirección" 
                            pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ0-9\s,-]{5,100}$" 
                            title="La dirección debe tener entre 5 y 100 caracteres. Solo se permiten letras, números, espacios, comas y guiones." 
                            required>
                        <div class="invalid-feedback">
                            <?php echo isset($_SESSION['errors']['address1']) ? $_SESSION['errors']['address1'] : ''; ?>
                        </div>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="validationCustom04" class="form-label">Email*</label>
                        <input value="<?php echo isset($_SESSION['form_data']['email1']) ? $_SESSION['form_data']['email1'] : ''; ?>" 
                            type="email" 
                            name="email1" 
                            class="form-control <?php echo isset($_SESSION['errors']['email1']) ? 'is-invalid' : ''; ?>" 
                            id="validationCustom04" 
                            placeholder="Email" 
                            required
                            title="Ingrese un correo electrónico válido en formato usuario@dominio.com.">
                        <div class="invalid-feedback">
                            <?php echo isset($_SESSION['errors']['email1']) ? $_SESSION['errors']['email1'] : ''; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mt-2">
                        <label for="validationCustom05" class="form-label">Teléfono*</label>
                        <input value="<?php echo isset($_SESSION['form_data']['phone1']) ? $_SESSION['form_data']['phone1'] : ''; ?>" 
                            type="text" 
                            name="phone1" 
                            class="form-control <?php echo isset($_SESSION['errors']['phone1']) ? 'is-invalid' : ''; ?>" 
                            id="validationCustom05" 
                            placeholder="Teléfono" 
                            pattern="[0-9]{8}" 
                            title="El número de teléfono debe tener exactamente 8 dígitos y solo puede contener números." 
                            required>
                        <div class="invalid-feedback">
                            <?php echo isset($_SESSION['errors']['phone1']) ? $_SESSION['errors']['phone1'] : ''; ?>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <p class="alert alert-info mt-4">* Campos obligatorios</p>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Agregar Proveedor</button>
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
                Hubo un error al agregar el proveedor. Por favor, inténtalo de nuevo.
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