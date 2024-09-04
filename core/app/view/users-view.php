<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1><i class="bi bi-list-task"></i> Lista de Usuarios</h1>
            <div class="mb-3 mt-5">
                <a href="index.php?view=newuser" class="btn btn-primary btn-sm">
                    <i class="bi bi-person-plus-fill"></i> Nuevo Usuario
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    USUARIOS
                </div>
                <div class="card-body">
                    <?php
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;

                    $users = UserData::getAll();
                    if (count($users) > 0) {
                        $totalUsers = count($users);
                        $totalPages = ceil($totalUsers / $limit);
                        $offset = ($page - 1) * $limit;
                        $curr_users = array_slice($users, $offset, $limit);
                    ?>

                    <!-- Selección del límite de usuarios y número de página -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <form method="GET" action="index.php">
                                <input type="hidden" name="view" value="users">
                                <label for="limit">Mostrar </label>
                                <select name="limit" id="limit" onchange="this.form.submit()">
                                    <option value="5" <?php echo ($limit == 5) ? 'selected' : ''; ?>>5</option>
                                    <option value="10" <?php echo ($limit == 10) ? 'selected' : ''; ?>>10</option>
                                    <option value="20" <?php echo ($limit == 20) ? 'selected' : ''; ?>>20</option>
                                    <option value="50" <?php echo ($limit == 50) ? 'selected' : ''; ?>>50</option>
                                </select>
                                usuarios por página
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
                                    <th>Nombre de usuario</th>
                                    <th>Email</th>
                                    <th>Activo</th>
                                    <th>Admin</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($curr_users as $user): ?>
                                <tr>
                                    <td><?php echo $user->name . " " . $user->lastname; ?></td>
                                    <td><?php echo $user->username; ?></td>
                                    <td><?php echo $user->email; ?></td>
                                    <td>
                                        <?php if ($user->is_active): ?>
                                        <i class="bi bi-check-lg"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($user->is_admin): ?>
                                        <i class="bi bi-check-lg"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td style="width:30px;">
                                        <a href="index.php?view=edituser&id=<?php echo $user->id; ?>" class="btn btn-warning btn-xs">Editar</a>
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
                                        <a class="page-link" href="index.php?view=users&limit=<?php echo $limit; ?>&page=1">««</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="index.php?view=users&limit=<?php echo $limit; ?>&page=<?php echo $page - 1; ?>">‹</a>
                                    </li>
                                <?php endif; ?>

                                <?php
                                $startPage = max(1, $page - 2);
                                $endPage = min($totalPages, $page + 2);
                                for ($i = $startPage; $i <= $endPage; $i++): ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a class="page-link" href="index.php?view=users&limit=<?php echo $limit; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="index.php?view=users&limit=<?php echo $limit; ?>&page=<?php echo $page + 1; ?>">›</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="index.php?view=users&limit=<?php echo $limit; ?>&page=<?php echo $totalPages; ?>">»»</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>

                    <?php
                    } else {
                        echo '<p class="alert alert-warning">No hay usuarios.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
