<?php
$products = ProductData::getAll();
?>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1><i class="bi bi-file-earmark-bar-graph"></i> Reportes</h1>
                <form class="mt-5">
                    <input type="hidden" name="view" value="reports">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-2">
                            <select name="product_id" class="form-control">
                                <option value="">--  TODOS --</option>
                                <?php foreach($products as $p): ?>
                                <option value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-2">
                            <input type="date" name="sd" value="<?php if(isset($_GET["sd"])) { echo $_GET["sd"]; } ?>" class="form-control">
                        </div>
                        <div class="col-md-3 col-sm-6 mb-2">
                            <input type="date" name="ed" value="<?php if(isset($_GET["ed"])) { echo $_GET["ed"]; } ?>" class="form-control">
                        </div>
                        <div class="col-md-3 col-sm-6 mb-2">
                            <input type="submit" class="btn btn-success btn-block" value="Procesar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">MOVIMIENTOS</div>
                    <div class="card-body">
                        <?php if (isset($_GET["sd"]) && isset($_GET["ed"])): ?>
                            <?php if ($_GET["sd"] != "" && $_GET["ed"] != ""): ?>
                                <?php
                                $operations = array();

                                if ($_GET["product_id"] == "") {
                                    $operations = OperationData::getAllByDateOfficial($_GET["sd"], $_GET["ed"]);
                                } else {
                                    $operations = OperationData::getAllByDateOfficialBP($_GET["product_id"], $_GET["sd"], $_GET["ed"]);
                                }
                                ?>

                                <?php if (count($operations) > 0): ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Operación</th>
                                                    <th>Fecha</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($operations as $operation): ?>
                                                    <tr>
                                                        <td><?php echo $operation->id; ?></td>
                                                        <td><?php echo $operation->getProduct()->name; ?></td>
                                                        <td><?php echo $operation->q; ?></td>
                                                        <td><?php echo $operation->getOperationType()->name; ?></td>
                                                        <td><?php echo $operation->created_at; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <div class="jumbotron">
                                        <h2>No hay operaciones</h2>
                                        <p>El rango de fechas seleccionado no proporcionó ningún resultado de operaciones.</p>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="">
                                    <h2>Fecha Incorrectas</h2>
                                    <p>Puede ser que no seleccionó un rango de fechas, o el rango seleccionado es incorrecto.</p>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br>
</section>
