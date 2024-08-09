<div class="container">
    <div class="row">
        <div class="col-md-12">
        <h1><i class="bi bi-people-fill"></i> Directorio de Clientes</h1>
            <div class="mb-3 mt-5">
            <a href="index.php?view=newclient" class="btn btn-primary btn-sm">
                <i class="bi bi-person-plus-fill me-2"></i> Nuevo Cliente
            </a>
        </div>

            <div class="card">
                <div class="card-header">
                    CLIENTES
                </div>
                <div class="card-body">
                    <?php
                    $clients = PersonData::getClients();
                    if (count($clients) > 0) {
                        echo '<div class="table-responsive">';
                        echo '<table class="table table-bordered table-hover">';
                        echo '<thead><tr><th>Nombre completo</th><th>Dirección</th><th>Email</th><th>Teléfono</th><th>Acciones</th></tr></thead>';
                        echo '<tbody>';
                        foreach ($clients as $client) {
                            echo '<tr>';
                            echo '<td>'. $client->name. ' '. $client->lastname. '</td>';
                            echo '<td>'. $client->address1. '</td>';
                            echo '<td>'. $client->email1. '</td>';
                            echo '<td>'. $client->phone1. '</td>';
                            echo '<td style="width:130px;">';
                            echo '<div class="btn-group" role="group">';
                            echo '<a href="index.php?view=editclient&id='. $client->id. '" class="btn btn-sm btn-warning"><i class="bi bi-pencil-fill"></i></a>';
                            echo '<button class="btn btn-sm btn-danger ms-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-href="index.php?view=delclient&id='. $client->id. '"><i class="bi bi-trash-fill"></i></button>';
                            echo '</div>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                    } else {
                        echo '<p class="alert alert-danger">No hay clientes</p>';
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
                ¿Estás seguro de que deseas eliminar este cliente? Esta acción no se puede deshacer.
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
