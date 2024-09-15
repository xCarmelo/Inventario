<div class="container">
    <div class="row">
        <div class="col-12">
            <h1><i class="bi bi-building"></i> Directorio de Proveedores</h1>
            <div class="d-flex justify-content-between mb-3 mt-5">
                <a href="index.php?view=newprovider" class="btn btn-primary">
                    <i class="bi bi-truck me-2"></i> Nuevo Proveedor
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header"> 
                PROVEEDORES
            </div>
            <div class="card-body">
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;

                $users = PersonData::getProviders();
                if (count($users) > 0) {
                    $totalUsers = count($users);
                    $totalPages = ceil($totalUsers / $limit);
                    $offset = ($page - 1) * $limit;
                    $curr_users = array_slice($users, $offset, $limit);
                ?>

                <!-- Selección del límite de proveedores y número de página -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <form method="GET" action="index.php">
                            <input type="hidden" name="view" value="providers">
                            <label for="limit">Mostrar </label>
                            <select name="limit" id="limit" onchange="this.form.submit()">
                                <option value="5" <?php echo ($limit == 5) ? 'selected' : ''; ?>>5</option>
                                <option value="10" <?php echo ($limit == 10) ? 'selected' : ''; ?>>10</option>
                                <option value="20" <?php echo ($limit == 20) ? 'selected' : ''; ?>>20</option>
                                <option value="50" <?php echo ($limit == 50) ? 'selected' : ''; ?>>50</option>
                            </select>
                            proveedores por página
                        </form>
                    </div>
                    <div>
                        <span>Estás en la página <?php echo $page; ?> de <?php echo $totalPages; ?></span>
                    </div>
                </div>

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
                            <?php foreach ($curr_users as $user): ?>
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

                <!-- Paginación centrada debajo de la tabla -->
                <div class="d-flex justify-content-center mt-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?view=providers&limit=<?php echo $limit; ?>&page=1">««</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?view=providers&limit=<?php echo $limit; ?>&page=<?php echo $page - 1; ?>">‹</a>
                                </li>
                            <?php endif; ?>

                            <?php
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPages, $page + 2);
                            for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="index.php?view=providers&limit=<?php echo $limit; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?view=providers&limit=<?php echo $limit; ?>&page=<?php echo $page + 1; ?>">›</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?view=providers&limit=<?php echo $limit; ?>&page=<?php echo $totalPages; ?>">»»</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
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


<!-- Modal para mensajes de éxito o error -->
<div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultModalLabel">Resultado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="resultMessage"></p>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
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

         // Mostrar el resultado según los parámetros de la URL
        const urlParams = new URLSearchParams(window.location.search);
        const successMessage = urlParams.get('success');
        const errorMessage = urlParams.get('error');

        if (successMessage || errorMessage) {
            $('#resultMessage').text(successMessage || errorMessage);
            $('#resultModal').modal('show');

            // Limpiar los parámetros de la URL después de mostrar el mensaje
            window.history.replaceState({}, document.title, window.location.pathname);
        }

    });
</script>
    