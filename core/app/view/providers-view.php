<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Directorio de Proveedores</h1>
            <div class="d-flex justify-content-between mb-3">
                <a href="index.php?view=newprovider" class="btn btn-secondary">
                    <i class='fa fa-truck'></i> Nuevo Proveedor
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    PROVEEDORES
                </div>
                <div class="card-body">
                    <?php
                    $users = PersonData::getProviders();
                    if (count($users) > 0) {
                        // si hay usuarios
                    ?>
                       <div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Nombre completo</th>
                <th>Dirección</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user->name . " " . $user->lastname; ?></td>
                    <td><?php echo $user->address1; ?></td>
                    <td><?php echo $user->email1; ?></td>
                    <td><?php echo $user->phone1; ?></td>
                    <td style="width:130px;" class="btn-group btn-group-sm">
                        <a href="index.php?view=editprovider&id=<?php echo $user->id; ?>" class="btn btn-warning btn-sm d-inline btn-style">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-sm d-inline btn-style" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-href="index.php?view=delprovider&id=<?php echo $user->id; ?>">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

                    <?php
                    } else {
                        echo "<p class='alert alert-danger'>No hay proveedores</p>";
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
                ¿Estás seguro de que deseas eliminar este proveedor? Esta acción no se puede deshacer.
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
