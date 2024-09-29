<?php
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    if ($id === false) {
        // Redirigir a una página de error o mostrar un mensaje de error
        header("Location: index.php?view=categories");
        exit;
    }
    $user = CategoryData::getById($_GET["id"]);
?>

<div class="row">
    <div class="col-md-12">
        <h1>Editar Categoria</h1>
        <br>
        <div class="card">
            <div class="card-header"> 
                EDITAR CATEGORIA
            </div>
            <div class="card-body">
                <form class="form-horizontal" method="post" id="updatecategory" action="index.php?view=updatecategory" role="form">
                    <div class="form-group">
                        <label for="categoria" class="col-lg-2 control-label">Nombre*</label>
                        <div class="col-md-6 mt-3">
                            <input type="text" name="categoria" value="<?php echo htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8'); ?>" class="form-control" id="name" placeholder="Nombre" required pattern="^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\s]{3,30}$" title="La categoría debe contener entre 3 y 30 caracteres alfanuméricos." />
                            <div class="input-group mt-3 mb-3">
                                <div class="input-group-append">
                                    <?php if(isset($_SESSION['error_msg'])) { ?>
                                    <div class="alert alert-danger mt-3">
                                        <?php echo $_SESSION['error_msg'];?>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?>">
                            <button type="submit" class="btn btn-primary">Actualizar Categoria</button>
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
                La categoría se actualizó correctamente.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="successCloseBtn">Cerrar</button>
                <a href="index.php?view=categories" class="btn btn-primary">Continuar</a>
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
                Hubo un error al actualizar la categoría. Por favor, inténtalo de nuevo.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>  
<?php unset($_SESSION['errors']); ?>

<script>
$(document).ready(function() {
    // Verificar si se pasó un parámetro en la URL para mostrar el modal correspondiente
    const urlParams = new URLSearchParams(window.location.search);
    const result = urlParams.get('result');
    
    if (result === 'success') {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    } 

    $('#errorModal').modal('show');

    // Cerrar el modal de éxito cuando se hace clic en el botón "Cerrar"
    $('#successCloseBtn').click(function() {
        var successModal = bootstrap.Modal.getInstance(document.getElementById('successModal'));
        successModal.hide();
    });

    // Si existe un parámetro 'result' en la URL, eliminar solo ese parámetro
    const url = new URL(window.location.href);
        if (url.searchParams.get('result')) {
            url.searchParams.delete('result'); // Eliminar solo el parámetro 'result'

            // Actualizar la URL sin recargar la página, manteniendo otros parámetros como 'view'
            window.history.replaceState({}, document.title, url.pathname + "?" + url.searchParams.toString());
        }
});

</script>
