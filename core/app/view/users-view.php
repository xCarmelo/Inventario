<?php $filtro_active_user = isset($_SESSION['filtroActiveUser'])?$_SESSION['filtroActiveUser']:1;?>

<div class="container">
    <div class="row"> 
        <div class="col-md-12">
            <h1><i class="bi bi-list-task"></i> Lista de Usuarios</h1>
            <div class="mb-3 mt-5">
                <a href="index.php?view=newuser" class="btn btn-primary btn-sm">
                    <i class="bi bi-person-plus-fill"></i> Nuevo Usuario
                </a>
            </div> 

            <br>

        <!-- Formulario 1 -->
        <div class="d-flex mt-3">
        <form class="d-flex w-100" method="post" action="index.php?action=searchAleatori">
                    <input type="text" name="vista" value="users" hidden>
                    <input title="El nombre solo puede contener letras, espacios, guiones. Debe tener entre 1 y 50 caracteres." 
                        pattern="^[A-Za-zÁÉÍÓÚÑáéíóúñ\s0-9\-'\.]{1,50}$" 
                        class="form-control me-2" 
                        type="text" 
                        name="search" 
                        autofocus 
                        placeholder="Buscar..." 
                        value="<?php echo isset($_SESSION['SearchItemusers']) ? $_SESSION['SearchItemusers'] : ''; ?>">
                    <button class="btn btn-outline-success d-flex align-items-center" type="submit">
                        <span class="me-1">Buscar</span>
                    </button>
                </form>

                <!--es para filtrar los usuarios desactivados-->
                <form class="ms-2" method="post" action="index.php?action=filtroActiveUser">
                <div style="padding-left: 30px;" class="form-check form-check-lg btn btn-outline-primary d-flex align-items-center justify-content-center">
                    <input <?php if($filtro_active_user == 0):?> checked <?php endif?> type="checkbox" class="form-check-input" name="userInactive" id="userInactive" onchange="this.form.submit();">
                    <label class="form-check-label ms-2" for="userInactive">Eliminados</label>
                    <input type="text" hidden value="users" name="view">
                </div>
                </form>
                
                <form class="ms-2" method="post" action="index.php?action=eliminarSesion">

                    <button type="submit" class="btn btn-outline-primary d-flex align-items-center justify-content-center">
                        <i class="bi bi-arrow-repeat"></i>
                    </button>
                    <input type="text" name="vista" value="users" hidden>
                </form>
            </div>
            <br>

            <div class="card">
                <div class="card-header">  
                    USUARIOS
                </div>
                <div class="card-body">
                    <?php
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;

                    if(isset($_SESSION['SearchItemusers']))
                    {
                        $users = UserData::getLike($_SESSION['SearchItemusers']);
                    }
                    else
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
                            <thead class="table-primary">
                                <tr>
                                    <th>Nombre completo</th>
                                    <th>Nombre de usuario</th>
                                    <th>Email</th>
                                    <th>Admin</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($curr_users as $user): 
                                    if($user->is_active == $filtro_active_user):
                                    ?>
 
                                <tr>
                                    <td><?php echo $user->name . " " . $user->lastname; ?></td>
                                    <td><?php echo $user->username; ?></td>
                                    <td><?php echo $user->email; ?></td>
                                    <td>
                                        <?php if ($user->is_admin): ?>
                                        <i class="bi bi-check-lg"></i>
                                        <?php endif; ?>
                                    </td>

                                    <?php if($filtro_active_user == 0):?>
                                    <td style="width:30px;">
                                        <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-primary ms-1" data-bs-toggle="modal" data-bs-target="#confirmHabilitarModal" data-href="index.php?view=activeUser&id=<?php echo $user->id; ?>"><i class="bi bi-arrow-counterclockwise"></i>Habilitar</button>                                     </div>
                                    </td> 
                                    
                                    <?php else:?>
                                    <td style="width:30px;"> 
                                        <div class="btn-group" role="group">
                                        <a href="index.php?view=edituser&id=<?php echo $user->id; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                        
                                        <?php if($_SESSION['user_id'] != $user->id):?>
                                        <button class="btn btn-sm btn-danger ms-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-href="index.php?view=inactiveUser&id=<?php echo $user->id; ?>"><i class="bi bi-trash"></i></button>
                                        <?php endif?>
                                    </div>
                                    </td> 
                                    <?php endif;?>

                                </tr>
                                <?php endif; endforeach; ?>
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
                        echo '<p class="alert alert-danger">No hay usuarios.</p>';
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
                ¿Estás seguro de que deseas eliminar este usuario? 
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

<!-- Modal de Confirmación para Habilitar Usuario -->
<div class="modal fade" id="confirmHabilitarModal" tabindex="-1" aria-labelledby="confirmHabilitarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmHabilitarModalLabel">Confirmar Habilitación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas habilitar este usuario?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a id="confirmHabilitarBtn" class="btn btn-primary" href="#">Habilitar</a>
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

          // Manejar la apertura del modal de habilitación
        $('#confirmHabilitarModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var url = button.data('href'); // Extraer la URL del atributo data-href

            var modal = $(this);
            modal.find('#confirmHabilitarBtn').attr('href', url); // Establecer la URL en el botón de confirmación
        });

         // Mostrar el resultado según los parámetros de la URL
        const urlParams = new URLSearchParams(window.location.search);
        const successMessage = urlParams.get('success');
        const errorMessage = urlParams.get('error');

        if (successMessage) {
            $('#resultMessage').text(successMessage);
            $('#resultModal').modal('show');
        } else if (errorMessage) {
            $('#resultMessage').text(errorMessage);
            $('#resultModal').modal('show');
        }

        mama = () => {
            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);

            params.delete('result');
            params.delete('error');
            params.delete('success'); // Add this line to remove the 'success' parameter as well

            const newUrl = url.pathname + '?' + params.toString();
            window.history.replaceState({}, document.title, newUrl);
        };

        mama();

    });
</script>    

<?php unset($_SESSION['errors']); unset($_SESSION['success']);?>