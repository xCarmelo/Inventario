<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Categorías</h1>
            <div class="mb-3">
                <a href="index.php?view=newcategory" class="btn btn-secondary btn-sm">
                    <i class="fa fa-th-list"></i> Nueva Categoría
                </a>
            </div>
            <div class="card">
                <div class="card-header">
                    CATEGORÍAS
                </div>
                <div class="card-body">
                    <?php
                    $categories = CategoryData::getAll();
                    if (count($categories) > 0) {
                        echo '<table class="table table-bordered table-hover">';
                        echo '<thead><tr><th>Nombre</th><th></th></tr></thead>';
                        foreach ($categories as $category) {
                            echo '<tr>';
                            echo '<td>'. $category->name. '</td>';
                            echo '<td>';
                            echo '<div class="btn-group" role="group">';
                            echo '<a href="index.php?view=editcategory&id='. $category->id. '" class="btn btn-sm btn-warning"><i class="bi bi-pencil-fill"></i></a>';
                            echo '<button class="btn btn-sm btn-danger ms-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-href="index.php?view=delcategory&id='. $category->id. '"><i class="bi bi-trash-fill"></i></button>';
                            echo '</div>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                    } else {
                        echo '<p class="alert alert-danger">No hay categorías</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación para Eliminación -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar esta categoría? Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a id="confirmDeleteBtn" class="btn btn-danger" href="#">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#confirmDeleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var url = button.data('href'); // Extraer la URL del atributo data-href

            var modal = $(this);
            modal.find('#confirmDeleteBtn').attr('href', url);
        });
    });
</script>
