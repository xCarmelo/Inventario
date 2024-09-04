<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4"><i class="bi bi-people-fill"></i> Directorio de Clientes</h1>
            <?php if($_SESSION['is_admin'] === 1): ?>
            <div class="mb-3 mt-4">
                <a href="index.php?view=newclient" class="btn btn-primary btn-sm">
                    <i class="bi bi-person-plus-fill me-2"></i> Nuevo Cliente
                </a>
            </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-header">
                    CLIENTES
                </div>
                <div class="card-body">
                    <?php
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;

                    $clients = PersonData::getClients();
                    if (count($clients) > 0) {
                        $totalClients = count($clients);
                        $totalPages = ceil($totalClients / $limit);
                        $offset = ($page - 1) * $limit;
                        $curr_clients = array_slice($clients, $offset, $limit);
                    ?>

                    <!-- Selección del límite de clientes y número de página -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <form method="GET" action="index.php">
                                <input type="hidden" name="view" value="clients">
                                <label for="limit">Mostrar </label>
                                <select name="limit" id="limit" onchange="this.form.submit()">
                                    <option value="5" <?php echo ($limit == 5) ? 'selected' : ''; ?>>5</option>
                                    <option value="10" <?php echo ($limit == 10) ? 'selected' : ''; ?>>10</option>
                                    <option value="20" <?php echo ($limit == 20) ? 'selected' : ''; ?>>20</option>
                                    <option value="50" <?php echo ($limit == 50) ? 'selected' : ''; ?>>50</option>
                                </select>
                                clientes por página
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
                                    <?php if($_SESSION['is_admin'] === 1): ?>
                                    <th>Acciones</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($curr_clients as $client): ?>
                                <tr>
                                    <td><?php echo $client->name . ' ' . $client->lastname; ?></td>
                                    <td><?php echo $client->address1; ?></td>
                                    <td><?php echo $client->email1; ?></td>
                                    <td><?php echo $client->phone1; ?></td>
                                    <?php if($_SESSION['is_admin'] === 1): ?>
                                    <td style="width:130px;">
                                        <div class="btn-group" role="group">
                                            <a href="index.php?view=editclient&id=<?php echo $client->id; ?>" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger ms-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-href="index.php?view=delclient&id=<?php echo $client->id; ?>">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <?php endif; ?>
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
                                        <a class="page-link" href="index.php?view=clients&limit=<?php echo $limit; ?>&page=1">««</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="index.php?view=clients&limit=<?php echo $limit; ?>&page=<?php echo $page - 1; ?>">‹</a>
                                    </li>
                                <?php endif; ?>

                                <?php
                                $startPage = max(1, $page - 2);
                                $endPage = min($totalPages, $page + 2);
                                for ($i = $startPage; $i <= $endPage; $i++): ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a class="page-link" href="index.php?view=clients&limit=<?php echo $limit; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="index.php?view=clients&limit=<?php echo $limit; ?>&page=<?php echo $page + 1; ?>">›</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="index.php?view=clients&limit=<?php echo $limit; ?>&page=<?php echo $totalPages; ?>">»»</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>

                    <?php
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
