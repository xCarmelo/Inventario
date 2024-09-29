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
                        <input placeholder="Categoria" type="text" name="categoria" required pattern="^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\s]{3,30}$" title="La categoría debe contener entre 3 y 30 caracteres alfanuméricos." class="form-control" />
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
                    <a href="index.php?view=categories" class="btn btn-primary">Ir a Categoria</a> <!-- Segundo botón -->
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
                            <li>Error al agregar la categoria</li>
                    </ul>
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