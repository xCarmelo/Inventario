<div class="row">
	<div class="col-md-12">
<!-- Single button -->
		<h1><i class='fa fa-archive'></i> Historial de Caja</h1>
<br>
		<div class="clearfix"></div>
<div class="card">
	<div class="card-header">
		HISTORIAL DE CAJA
	</div>
		<div class="card-body">



<?php
$boxes = BoxData::getAll();
$products = SellData::getSellsUnBoxed();
if(count($boxes)>0){
$total_total = 0;
?> 
<br>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-primary">
            <th></th>
            <th>Corte de caja</th>
            <th>Total</th>
            <th>Fecha</th>
        </thead>
        <?php 
            foreach($boxes as $box): 
                $sells = SellData::getByBoxId($box->id);
                $total = 0;
                $hasOperations = false;

                // Verificar si hay operaciones para cada venta en el box
                foreach($sells as $sell){
                    $operations = OperationData::getAllProductsBySellId($sell->id);
                    
                    // Si hay al menos una operación, procesamos el total y marcamos que hay operaciones
                    if (!empty($operations)) {
                        $hasOperations = true;
                        foreach($operations as $operation){
                            $total += $operation->q * $operation->new_price;
                        }
                    }
                }

                // Si no se encontró ninguna operación, omitimos este registro
                if (!$hasOperations) {
                    continue;
                }
            ?>
                <tr>
                    <td style="width:30px;">
                        <a href="./index.php?view=b&id=<?php echo $box->id; ?>" class="btn btn-default btn-xs"><i class="bi bi-arrow-right"></i></a>
                    </td>
                    <td>Corte de caja #<?php echo $box->id; ?></td> 
                    <td><b>C$ <?php echo number_format($total, 2, ".", ","); ?></b></td>
                    <td><?php echo $box->created_at; ?></td>
                </tr>
            <?php 
                $total_total += $total;
            endforeach; 
            ?>


    </table>
</div>
<h1>Total: <?php echo "C$ ".number_format($total_total,2,".",","); ?></h1>
	<?php
}else {

?>
	<div class="jumbotron">
		<h2>No hay ventas</h2>
		<p>No se ha realizado ninguna venta.</p>
	</div>

<?php } ?>
</div>
</div>
<br><br><br><br><br><br><br><br><br><br>
	</div>
</div>