<div class="row">
    <div class="col-md-12">
        <h1>Nueva Categoria</h1>
        <br>

        <div id="error-messages" class="alert alert-danger" style="display: none;">
            <ul></ul> 
        </div>
    <div class="card">
        <div class="card-header">
                NUEVA CATEGORIA
        </div>

            <div class="card-body">
                <form class="form-horizontal" method="post" id="addcategory" action="index.php?view=addcategory" role="form">
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
                    <div class="col-md-6 mt-3">
                        <input type="text" name="categoria" required pattern="^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\s]{3,30}$" title="La categoría debe contener entre 3 y 30 caracteres alfanuméricos." class="form-control" />
                    <div class="input-group mt-3 mb-3">
                        <div class="input-group-append ">
                            <?php if(isset($_SESSION['error_msg'])) { ?>
                            <div class="alert alert-danger mt-3">
                            <?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-primary">Agregar Categoria</button>
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
                La categoría se agregó correctamente.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a href="index.php?view=categories" class="btn btn-primary">Continuar</a>
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
                Hubo un error al agregar la categoría. Por favor, inténtalo de nuevo.
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

    // Mostrar errores de validación o de la base de datos
    <?php if (isset($_SESSION['error_msg'])) { ?>
        var errorMessages = $("#error-messages");
        var errorList = errorMessages.find("ul");
        errorList.append("<li><?php echo $_SESSION['error_msg']; ?></li>");
        <?php unset($_SESSION['error_msg']); ?>
        errorMessages.show();
    <?php } ?>
});


</script>
