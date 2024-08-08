<?php
$clients = PersonData::getClients();
?>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Reportes de Ventas</h1> 
                <form>
                    <input type="hidden" name="view" value="sellreports">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-2">
                            <select name="client_id" class="form-control">
                                <option value="">--  TODOS --</option>
                                <?php foreach($clients as $p): ?>
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
                    <div class="card-header">REPORTE DE VENTAS</div>
                    <div class="card-body">
                        <?php if(isset($_GET["sd"]) && isset($_GET["ed"])): ?>
                            <?php if($_GET["sd"]!=""&&$_GET["ed"]!=""): ?>
                                <?php 
                                $operations = array(); 

                                if($_GET["client_id"]==""){
                                    $operations = SellData::getAllByDateOp($_GET["sd"], $_GET["ed"], 2);
                                } else {
                                    $operations = SellData::getAllByDateBCOp($_GET["client_id"], $_GET["sd"], $_GET["ed"], 2);
                                } 
                                ?>

                                <?php if(count($operations)>0): ?>
                                    <?php $supertotal = 0; ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Total</th>
                                                    <th>Fecha</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($operations as $operation): ?>
                                                    <tr>
                                                        <td><?php echo $operation->id; ?></td>
                                                        <td>C$ <?php echo number_format($operation->total - $operation->discount, 2, '.', ','); ?></td>
                                                        <td><?php echo $operation->created_at; ?></td>
                                                    </tr>
                                                    <?php $supertotal += ($operation->total - $operation->discount); ?>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <h1>Total de ventas: C$ <?php echo number_format($supertotal, 2, '.', ','); ?></h1>
                                <?php else: ?>
                                    <div class="jumbotron">
                                        <h2>No hay operaciones</h2>
                                        <p>El rango de fechas seleccionado no proporcionó ningún resultado de operaciones.</p>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="jumbotron">
                                    <h2>Fecha Incorrectas</h2>
                                    <p>Puede ser que no seleccionó un rango de fechas, o el rango seleccionado es incorrecto.</p>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br><br>
    </div>
</section>
