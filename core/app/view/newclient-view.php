<div class="row">
    <div class="col-md-12">
        <h1>Nuevo Cliente</h1>
        <br> 
        <div class="card">
            <div class="card-header">
                NUEVO CLIENTE
            </div>
            <div class="card-body">  
            <form class="form-horizontal" method="post" id="addproduct" action="index.php?view=addclient" role="form">
                <div class="row">
                    <div class="col-md-6">
                        <label for="validationCustom01" class="form-label">Nombre*</label>
                        <input value="<?php echo isset($_SESSION['form_data']['name']) ? $_SESSION['form_data']['name'] : ''; ?>" 
                            type="text" name="name" 
                            class="form-control <?php echo isset($_SESSION['errors']['name']) ? 'is-invalid' : ''; ?>" 
                            id="validationCustom01" placeholder="Nombre" 
                            pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ\s]{2,80}$" 
                            title="Ingresa un nombre válido (solo letras, espacios y acentos) de al menos 2 caracteres y hasta 80 caracteres" 
                            required>
                        <div class="invalid-feedback">
                            <?php echo isset($_SESSION['errors']['name']) ? $_SESSION['errors']['name'] : ''; ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="validationCustom02" class="form-label">Apellido*</label>
                        <input value="<?php echo isset($_SESSION['form_data']['lastname']) ? $_SESSION['form_data']['lastname'] : ''; ?>" 
                            type="text" name="lastname" 
                            class="form-control <?php echo isset($_SESSION['errors']['lastname']) ? 'is-invalid' : ''; ?>" 
                            id="validationCustom02" placeholder="Apellido" 
                            pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ\s]{2,50}$" 
                            title="Ingresa un apellido válido (solo letras, espacios y acentos) de al menos 2 caracteres y hasta 50 caracteres" 
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
                            type="text" name="address1" 
                            class="form-control <?php echo isset($_SESSION['errors']['address1']) ? 'is-invalid' : ''; ?>" 
                            id="validationCustom03" placeholder="Dirección" 
                            pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ0-9\s,-]{5,100}$" 
                            title="Ingresa una dirección válida (solo letras, números, espacios, guiones y comas) de al menos 5 caracteres y hasta 100 caracteres" 
                            required>
                        <div class="invalid-feedback">
                            <?php echo isset($_SESSION['errors']['address1']) ? $_SESSION['errors']['address1'] : ''; ?>
                        </div>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="validationCustom04" class="form-label">Email*</label>
                        <input max="320" value="<?php echo isset($_SESSION['form_data']['email1']) ? $_SESSION['form_data']['email1'] : ''; ?>" 
                            type="email" name="email1" 
                            class="form-control <?php echo isset($_SESSION['errors']['email1']) ? 'is-invalid' : ''; ?>" 
                            id="validationCustom04" placeholder="Email" 
                            title="El correo electrónico debe ser válido y en un formato estándar (ejemplo@dominio.com)" 
                            required>
                        <div class="invalid-feedback">
                            <?php echo isset($_SESSION['errors']['email1']) ? $_SESSION['errors']['email1'] : ''; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mt-2">
                        <label for="validationCustom05" class="form-label">Teléfono*</label>
                        <input value="<?php echo isset($_SESSION['form_data']['phone1']) ? $_SESSION['form_data']['phone1'] : ''; ?>" 
                            type="text" name="phone1" 
                            class="form-control <?php echo isset($_SESSION['errors']['phone1']) ? 'is-invalid' : ''; ?>" 
                            id="validationCustom05" placeholder="Teléfono" 
                            pattern="[0-9]{8}" 
                            title="Ingresa un número de teléfono válido (8 dígitos)" 
                            required>
                        <div class="invalid-feedback">
                            <?php echo isset($_SESSION['errors']['phone1']) ? $_SESSION['errors']['phone1'] : ''; ?>
                        </div>
                    </div>
                </div>

                <p class="alert alert-info mt-4">* Campos obligatorios</p>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-primary">Agregar Cliente</button>
                    </div>
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
                    <h5 class="modal-title" id="errorModalLabel">
                        <i class="bi bi-exclamation-circle text-danger"></i> Error
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Hubo un error al agregar el cliente. Por favor, inténtalo de nuevo.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

<script>
    $(document).ready(function() {
        // Mostrar el modal de éxito si está presente
        var successModal = $('#successModal');
        if (successModal.length > 0) {
            successModal.modal('show');
        }

        // Mostrar el modal de error si está presente
        var errorModal = $('#errorModal');
        if (errorModal.length > 0) {
            errorModal.modal('show'); 
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

<?php
// Limpiar los errores y los datos de sesión después de usarlos
unset($_SESSION['errors']);
unset($_SESSION['form_data']);
?>