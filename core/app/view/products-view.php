<?php $filtro_active_user = isset($_SESSION['filtroActiveUser'])?$_SESSION['filtroActiveUser']:1;?>

<div class="row">
    <div class="col-md-12">
        <h1><i class="bi bi-box-seam"></i> Productos</h1> 
        <?php if($_SESSION['is_admin'] === 1): ?>
        <div class="mt-4">
            <a href="index.php?view=newproduct" class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i> Agregar Producto
            </a> 
        </div>
        <?php endif; ?> 
        <br>

        <!-- Formulario de búsqueda --> 
        <div class="d-flex mt-3">
                <!-- Formulario 1 -->
                <form class="d-flex w-100" method="post" action="index.php?action=searchAleatori">
                    <input type="text" name="vista" value="products" hidden>
                    <input title="El nombre solo puede contener letras, espacios, guiones. Debe tener entre 1 y 50 caracteres." 
                        pattern="^[A-Za-zÁÉÍÓÚÑáéíóúñ\s0-9\-'\.]{1,50}$" 
                        class="form-control me-2" 
                        type="text" 
                        name="search" 
                        autofocus 
                        placeholder="Buscar..." 
                        value="<?php echo isset($_SESSION['SearchItemproducts']) ? $_SESSION['SearchItemproducts'] : ''; ?>">
                    <button class="btn btn-outline-success d-flex align-items-center" type="submit">
                        <span class="me-1">Buscar</span>
                    </button>
                </form>

                
                <!--es para filtrar los proveedores desactivados-->
                <form class="ms-2" method="post" action="index.php?action=filtroActiveUser">
                <div style="padding-left: 30px;" class="form-check form-check-lg btn btn-outline-primary d-flex align-items-center justify-content-center">
                    <input <?php if($filtro_active_user == 0):?> checked <?php endif?> type="checkbox" class="form-check-input" name="userInactive" id="userInactive" onchange="this.form.submit();">
                    <label class="form-check-label ms-2" for="userInactive">Eliminados</label>
                    <input type="text" hidden value="products" name="view">
                </div>
                </form>

                <!-- Formulario 2: Botón al lado del botón "Buscar" -->
                <form class="ms-2" method="post" action="index.php?action=eliminarSesion">
                    <button type="submit" class="btn btn-outline-primary d-flex align-items-center justify-content-center">
                        <i class="bi bi-arrow-repeat"></i>
                    </button>
                    <input type="text" name="vista" value="products" hidden>
                </form>
            </div>

            <br>

        <div class="card">
            <div class="card-header">
                PRODUCTOS
            </div>
            <div class="card-body">
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;

                //********************************** */
                if(isset($_SESSION['SearchItemproducts']))
                {
                    $products = ProductData::getLike($_SESSION['SearchItemproducts']);  
                }
                else
                    $products = ProductData::getAll();
                /****************************************** */

                
                // Filtrar productos eliminados si es necesario
                if ($filtro_active_user == 0) {
                    $products = array_filter($products, function($product) {
                        return $product->is_active == 0; // Solo productos eliminados
                    });
                } else {
                    $products = array_filter($products, function($product) {
                        return $product->is_active == 1; // Solo productos activos
                    });
                }

                if (count($products) > 0) {
                   
                    $totalProducts = count($products);
                    $totalPages = ceil($totalProducts / $limit);
                    $offset = ($page - 1) * $limit;
                    $curr_products = array_slice($products, $offset, $limit); // Obtener los productos de la página actual
                ?>

                <!-- Selección del límite de productos y número de página -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <form method="GET" action="index.php">
                            <input type="hidden" name="view" value="products">
                            <label for="limit">Mostrar </label>
                            <select name="limit" id="limit" onchange="this.form.submit()">
                                <option value="5" <?php echo ($limit == 5) ? 'selected' : ''; ?>>5</option>
                                <option value="10" <?php echo ($limit == 10) ? 'selected' : ''; ?>>10</option>
                                <option value="20" <?php echo ($limit == 20) ? 'selected' : ''; ?>>20</option>
                                <option value="50" <?php echo ($limit == 50) ? 'selected' : ''; ?>>50</option>
                            </select>
                            productos por página
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
                                <th>Codigo</th>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>   
                                <?php if($_SESSION['is_admin'] === 1): ?>
                                <th>Acciones</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($curr_products as $product): 
                                if($product->is_active == $filtro_active_user):
                                ?>

                            <tr>
                                <td><?php echo $product->id; ?></td>
                                <td>
                                    <?php if ($product->image != ""): ?>
                                        <img src="storage/products/<?php echo $product->image; ?>" style="width:64px;" class="custom-modal-trigger">
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $product->name; ?></td>
                                <td><?php echo $product->description; ?></td>   

                                <?php if($filtro_active_user == 0):?>
                                    <?php if ($_SESSION['is_admin'] === 1):?>
                                    <td style="width:30px;">
                                        <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-primary ms-1" data-bs-toggle="modal" data-bs-target="#confirmHabilitarModal" data-href="index.php?view=delproduct&id=<?php echo $product->id; ?>&active=1"><i class="bi bi-arrow-counterclockwise"></i>Habilitar</button>                                     </div>
                                    </td>
                                    <?php endif;?>
                                    <?php else: ?>
                                <?php if($_SESSION['is_admin'] === 1): ?>
                                <td style="width:120px;">
                                    <div class="btn-group" role="group">
                                        <a href="index.php?view=editproduct&id=<?php echo $product->id; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                        <button class="btn btn-sm btn-danger ms-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-href="index.php?view=delproduct&id=<?php echo $product->id; ?>"><i class="bi bi-trash"></i></button>
                                    </div>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php endif; endif; endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación centrada debajo de la tabla -->
                <div class="d-flex justify-content-center mt-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?view=products&limit=<?php echo $limit; ?>&page=1">««</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?view=products&limit=<?php echo $limit; ?>&page=<?php echo $page - 1; ?>">‹</a>
                                </li>
                            <?php endif; ?>

                            <?php
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPages, $page + 2);
                            for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="index.php?view=products&limit=<?php echo $limit; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?view=products&limit=<?php echo $limit; ?>&page=<?php echo $page + 1; ?>">›</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?view=products&limit=<?php echo $limit; ?>&page=<?php echo $totalPages; ?>">»»</a>
                                </li>
                            <?php endif; ?> 
                        </ul>
                    </nav>
                </div>

                <?php
                } else {
                ?>
                <div class="jumbotron">
                    <p class="alert alert-danger">Sin Articulos disponibles</p>
                </div>
                <?php
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
                ¿Estás seguro de que deseas eliminar este producto?  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a id="confirmDeleteBtn" class="btn btn-danger" href="#">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Ampliar Imágenes -->
<div class="modal fade custom-img-modal" id="imgModal" tabindex="-1" aria-labelledby="imgModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img id="modalImage" src="" alt="Imagen del producto" class="img-fluid">
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

<!-- Modal de Confirmación para Habilitar product -->
<div class="modal fade" id="confirmHabilitarModal" tabindex="-1" aria-labelledby="confirmHabilitarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmHabilitarModalLabel">Confirmar Habilitación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas habilitar este producto?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a id="confirmHabilitarBtn" class="btn btn-primary" href="#">Habilitar</a>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para el Modal de Imágenes --> 
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

        var images = document.getElementsByClassName('custom-modal-trigger');
        var modal = new bootstrap.Modal(document.getElementById('imgModal'));
        var modalImage = document.getElementById('modalImage');

        for (var i = 0; i < images.length; i++) {
            images[i].addEventListener('mouseover', function() {
                modalImage.src = this.src;
                modal.show();
            });

            images[i].addEventListener('mouseleave', function() {
                modal.hide();
            });    
        } 

        mama = () => {
            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);

            params.delete('result');
            params.delete('success'); // Add this line to remove the 'success' parameter as well

            const newUrl = url.pathname + '?' + params.toString();
            window.history.replaceState({}, document.title, newUrl);
        };

        mama(); 
    });
</script>
