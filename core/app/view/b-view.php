<div class="row">
	<div class="col-md-12">

<!-- Single button -->

		<h1><i class='fa fa-archive'></i> Corte de Caja #<?php echo $_GET["id"]; ?></h1>
		<div class="">
<a href="./index.php?view=boxhistory" class="btn btn-secondary"><i class="fa fa-clock-o"></i> Historial</a>

<div class="clearfix"></div>
<br>
<div class="card">
	<div class="card-header">
		CORTE DE CAJA
	</div>
		<div class="card-body">
<?php
$products = SellData::getByBoxId($_GET["id"]);
if(count($products)>0){
$total_total = 0;
?>
<br>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <th></th>
            <th>Total</th>
            <th>Fecha</th>
        </thead>
        <?php foreach($products as $sell):?>
        <tr>
            <td style="width:30px;">
                <a href="./index.php?view=onesell&id=<?php echo $sell->id;?>" class="btn btn-default btn-xs"><i class="bi bi-arrow-right"></i></a>
                <?php
                $operations = OperationData::getAllProductsBySellId($sell->id);
               ?>
            </td>
            <td>
                <?php
                $total = 0;
                foreach($operations as $operation){
                    $total += $operation->q * $operation->new_price;
                }
                $total_total += $total;
                echo "<b>C$ ".number_format($total, 2, ".", ",")."</b>";
               ?>
            </td>
            <td><?php echo $sell->created_at;?></td>
        </tr>
        <?php endforeach;?>
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

	</div>
</div>