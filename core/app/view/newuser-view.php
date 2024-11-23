<div class="row">
    <div class="col-md-12">
        <h1>Agregar Usuario</h1>
        <br>
        <div class="card">
            <div class="card-header text-white">Usuarios</div>
            <div class="card-body">
                <form class="form-horizontal" method="post" id="adduser" action="index.php?view=adduser" role="form">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="validationCustom01" class="form-label">Nombre*</label>
                            <input value="<?php echo isset($_SESSION['form_data']['name']) ? $_SESSION['form_data']['name'] : ''; ?>" type="text" name="name" class="form-control <?php echo isset($_SESSION['errors']['name']) ? 'is-invalid' : ''; ?>" id="validationCustom01" placeholder="Nombre" pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ\s]{2,80}$" title="Ingresa un nombre válido (solo letras, espacios y acentos) de al menos 2 caracteres" required>
                            <div class="invalid-feedback">
                                <?php echo isset($_SESSION['errors']['name']) ? $_SESSION['errors']['name'] : ''; ?>
                            </div>
                        </div> 

                        <div class="col-md-6">
                            <label for="validationCustom02" class="form-label">Apellido*</label>
                            <input value="<?php echo isset($_SESSION['form_data']['lastname']) ? $_SESSION['form_data']['lastname'] : ''; ?>" type="text" name="lastname" class="form-control <?php echo isset($_SESSION['errors']['lastname']) ? 'is-invalid' : ''; ?>" id="validationCustom02" placeholder="Apellido" pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ\s]{2,50}$" title="Ingresa un apellido válido (solo letras, espacios y acentos) de al menos 2 caracteres" required>
                            <div class="invalid-feedback">
                                <?php echo isset($_SESSION['errors']['lastname']) ? $_SESSION['errors']['lastname'] : ''; ?>
                            </div>
                        </div>
                    </div> 

                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <label for="validationCustom03" class="form-label">Nombre de usuario*</label>
                            <input value="<?php echo isset($_SESSION['form_data']['username']) ? $_SESSION['form_data']['username'] : ''; ?>" type="text" name="username" class="form-control <?php echo isset($_SESSION['errors']['username']) ? 'is-invalid' : ''; ?>" id="validationCustom03" placeholder="Nombre de usuario" pattern="^[A-Za-z0-9_]{2,50}$" title="Ingresa un nombre de usuario válido de al menos 2 caracteres, sin acento" min="2" required>
                            <div class="invalid-feedback">
                                <?php echo isset($_SESSION['errors']['username']) ? $_SESSION['errors']['username'] : ''; ?>
                            </div>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label for="validationCustom04" class="form-label">Email*</label>
                            <input value="<?php echo isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : ''; ?>" type="email" name="email" class="form-control <?php echo isset($_SESSION['errors']['email']) ? 'is-invalid' : ''; ?>" id="validationCustom04" placeholder="Email" required>
                            <div class="invalid-feedback">
                                <?php echo isset($_SESSION['errors']['email']) ? $_SESSION['errors']['email'] : ''; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <label for="validationCustom05" class="form-label">Teléfono*</label>
                            <input min="8" value="<?php echo isset($_SESSION['form_data']['phone']) ? $_SESSION['form_data']['phone'] : ''; ?>" type="number" name="phone" class="form-control <?php echo isset($_SESSION['errors']['phone']) ? 'is-invalid' : ''; ?>" id="validationCustom05" placeholder="Teléfono" pattern="[0-9]{8}" title="Ingresa un número de teléfono válido (8 dígitos)" required>
                            <div class="invalid-feedback">
                                <?php echo isset($_SESSION['errors']['phone']) ? $_SESSION['errors']['phone'] : ''; ?>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2"> 
                            <label for="password" class="form-label">Contraseña*</label>
                            <input pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&amp;*(),.?&quot;:{}|&lt;&gt;])[A-Za-z\d!@#$%^&amp;*(),.?&quot;:{}|&lt;&gt;]{8,}$"
                                minlength="8"
                                value="<?php echo isset($_SESSION['form_data']['password']) ? $_SESSION['form_data']['password'] : ''; ?>"
                                type="password"
                                name="password"
                                class="form-control <?php echo isset($_SESSION['errors']['password']) ? 'is-invalid' : ''; ?>"
                                id="password"
                                placeholder="Contraseña"
                                title="La contraseña debe tener al menos 8 caracteres, incluyendo una letra mayúscula, una letra minúscula, un número y un carácter especial."
                                required>
                            <div class="invalid-feedback">
                                <?php echo isset($_SESSION['errors']['password']) ? $_SESSION['errors']['password'] : ''; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin">
                            <label class="form-check-label" for="is_admin">Es administrador</label>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <p class="alert alert-info">* Campos obligatorios</p>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Agregar Usuario</button>
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
                    <a href="index.php?view=users" class="btn btn-primary">Ir a Usuarios</a>
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
                    Hubo un error al agregar el usuario. Por favor, inténtalo de nuevo.
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
                    