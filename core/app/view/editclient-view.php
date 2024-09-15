<?php $user = PersonData::getById($_GET["id"]);?>
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
                            <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
                        </div>
                    </div>
                </form>

                <?php
                // Limpiar los errores y los datos de sesión después de usarlos
                unset($_SESSION['errors']);
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
                        <?php foreach ($_SESSION['errors'] as $error) : ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
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
    });
</script>
