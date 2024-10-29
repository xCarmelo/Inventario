<?php
// Configuración de paginación
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Obtener clientes
$clients = PersonData::getClients(); 

// Obtener la lista de ventas con filtros de cliente y fechas
$sells = array();
if (isset($_GET["sd"]) && isset($_GET["ed"]) && $_GET["sd"] != "" && $_GET["ed"] != "") {
    if ($_GET["client_id"] == "") {
        $sells = SellData::getAllByDateOp($_GET["sd"], $_GET["ed"], 2);
    } else {
        $sells = SellData::getAllByDateBCOp($_GET["client_id"], $_GET["sd"], $_GET["ed"], 2);
    }
} else {
    $sells = SellData::getSells(); // Obtener todas las ventas si no hay filtros  
}

if(isset($_POST['option']))$sells = SellData::getSells(); 

// Calcular el total de páginas
$total = count($sells);
$totalPages = ceil($total / $limit);
$sells = array_slice($sells, $offset, $limit); // Paginación de los datos
?>

<div class="row">
    <div class="col-md-12">
        <h1><i class="bi bi-cart"></i> Lista de Ventas</h1>
        <div class="row">
    <div class="col-md-10">
            <form class="mt-3">
                <input type="hidden" name="view" value="sells">  
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-2">
                        <select name="client_id" class="form-select">
                            <option value="">-- TODOS --</option>
                            <?php foreach ($clients as $p): ?>
                            <option value="<?php echo $p->id; ?>" <?php echo isset($_GET["client_id"]) && $_GET["client_id"] == $p->id ? 'selected' : ''; ?>><?php echo $p->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-2">
                        <input type="date" name="sd" value="<?php echo isset($_GET["sd"]) ? $_GET["sd"] : ''; ?>" class="form-control">
                    </div>
                    <div class="col-md-3 col-sm-6 mb-2">
                        <input type="date" name="ed" value="<?php echo isset($_GET["ed"]) ? $_GET["ed"] : ''; ?>" class="form-control">
                    </div>
                    <div class="col-md-3 col-sm-6 mb-2">
                        <button type="submit" class="btn btn-success w-100 text-white">Procesar</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Form con icono de refresh -->
        <div class="col-md-2">
            <form class="mt-3" action="index.php?view=sells" method="post">
                <input type="text" value="all" hidden name="option">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-arrow-clockwise"></i> Refresh
                </button>
            </form>
        </div>
    </div>


        <div class="clearfix"></div>

        <?php if (count($sells) > 0) { ?>

        <div class="card mt-5">
            <div class="card-header">
                VENTAS 
            </div>  

            <div class="d-flex justify-content-between mb-3 mt-3 ms-3">
            <div>
                <b>Mostrar:</b>
                <select id="limitSelect" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                    <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10</option>
                    <option value="25" <?php echo $limit == 25 ? 'selected' : ''; ?>>25</option>
                    <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50</option>
                </select>
                <b>Ventas por página</b>
            </div>
            <div>
                <p class="mb-0 me-3">Estas en la página <?php echo $page; ?> de <?php echo $totalPages; ?></p>
            </div>
        </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th></th>
                                <th>Producto</th>
                                <th>Total</th>
                                <th>Fecha</th>
                                <?php if ($_SESSION['is_admin'] === 1) { ?>
                                <th></th>
                                <?php } ?>
                            </tr> 
                        </thead>
                        <tbody>
                            <?php foreach ($sells as $sell) { ?>
                            <tr>
                                <td style="width:30px;">
                                    <a href="index.php?view=onesell&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-link"><i class="bi bi-eye"></i></a>
                                </td> 
                                <td>
                                    <?php 
                                    $operations = OperationData::getAllProductsBySellId($sell->id);
                                    echo count($operations);
                                    ?> 
                                </td>
                                <td> 
                                    <?php 
                                    $total = $sell->total;
                                    echo "<b>C$ ".number_format($total)."</b>";
                                    ?>
                                </td>
                                <td><?php echo $sell->created_at; ?></td>

                                <?php if ($_SESSION['is_admin'] === 1) { ?>
                                <td style="width:30px;">
                                <button class="btn btn-xs btn-danger d-flex align-items-center text-white" data-bs-toggle="modal" data-bs-target="#confirmDevolucionModal" data-href="index.php?view=delsell&id=<?php echo $sell->id; ?>">
                                    <span>Devolución</span>
                                    <i class="bi bi-arrow-return-left ms-2"></i>
                                </button>



                                </td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
            </div>
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
            </div>

        <?php } else { ?>
        <div class="jumbotron mt-4">
            <h2>No hay ventas</h2>
            <p>No se encontraron resultados para el rango seleccionado.</p>
        </div>
        <?php } ?>
    </div>
</div>


<!-- Modal de Confirmación --> 
<div class="modal fade" id="confirmDevolucionModal" tabindex="-1" aria-labelledby="confirmDevolucionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"> 
                <h5 class="modal-title" id="confirmDevolucionModalLabel">Confirmar devolución</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro que deseas realizar la devolución? Esta acción no se puede deshacer.</p>
                <!-- Campo de texto para el motivo de la devolución -->
                <div class="form-group">
                    <label for="motivoDevolucion" class="mb-2"><strong>Motivo de la devolución</strong></label>
                    <input type="text" id="motivoDevolucion" class="form-control" placeholder="Escribe el motivo de la devolución">
                    <!-- Aquí aparecerá el mensaje de error -->
                    <small id="motivoError" class="text-danger" style="display:none;">Debes ingresar el motivo de la devolución</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a id="confirmDeleteBtn" class="btn btn-danger" href="#">Confirmar</a>
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
        // Selecciona el modal y el botón de confirmación
        var $confirmDevolucionModal = $('#confirmDevolucionModal');
        var $confirmDeleteBtn = $('#confirmDeleteBtn');
        var $motivoInput = $('#motivoDevolucion'); 
        var $motivoError = $('#motivoError'); // Elemento para mostrar el error

        // Evento que se dispara cuando el modal se muestra
        $confirmDevolucionModal.on('show.bs.modal', function (event) {
            var $button = $(event.relatedTarget);
            var url = $button.data('href');
            
            // Cuando se haga clic en el botón "Confirmar", se valida el motivo
            $confirmDeleteBtn.off('click').on('click', function (e) {
                e.preventDefault(); 
                var motivo = $.trim($motivoInput.val());

                // Verifica si el campo de motivo está vacío
                if (motivo === '') {
                    $motivoError.show(); // Muestra el mensaje de error
                    return;
                } else {
                    $motivoError.hide(); // Oculta el mensaje de error si no está vacío
                }

                // Agrega el motivo como parámetro a la URL y redirige
                var nuevaUrl = url + '&motivo=' + encodeURIComponent(motivo);
                window.location.href = nuevaUrl; 
            });
        });

        // Oculta el mensaje de error cuando se comienza a escribir en el campo
        $motivoInput.on('input', function() {
            $motivoError.hide();
        });

                $('#limitSelect').on('change', function() {
                    var limit = $(this).val();
                    window.location.href = "?view=sells&page=1&limit=" + limit;
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
    </div>
</div>  