<h1 class="text-center">Resumen de Compra</h1>
<br>
<?php if(isset($_GET["id"]) && $_GET["id"]!=""):?>
<?php
$sell = SellData::getById($_GET["id"]);
$operations = OperationData::getAllProductsBySellId($_GET["id"]);
$total = 0;
?>
<?php
if(isset($_COOKIE["selled"])){
	foreach ($operations as $operation) {
		$qx = OperationData::getQYesF($operation->product_id);
		$p = $operation->getProduct();
		if($qx==0){
			echo "<p class='alert alert-danger'>El producto <b style='text-transform:uppercase;'> $p->name</b> no tiene existencias en inventario.</p>";			
		}else if($qx<=$p->inventary_min/2){
			echo "<p class='alert alert-danger'>El producto <b style='text-transform:uppercase;'> $p->name</b> tiene muy pocas existencias en inventario.</p>";
		}else if($qx<=$p->inventary_min){
			echo "<p class='alert alert-warning'>El producto <b style='text-transform:uppercase;'> $p->name</b> tiene pocas existencias en inventario.</p>";
		}
	}
	setcookie("selled","",time()-18600);
}
?>

<div class="card">
	<div class="card-header">
		<h4 class="text-center">RESUMEN DE COMPRA</h4>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered">
				<?php if($sell->person_id!=""):
				$client = $sell->getPerson();
				?>
				<tr>
					<td style="width:150px;">Proveedor</td>
					<td><?php echo $client->name." ".$client->lastname;?></td>
				</tr>
				<?php endif; ?>

				<?php if($sell->user_id!=""):
				$user = $sell->getUser();
				?>
				<tr>
					<td>Atendido por</td>
					<td><?php echo $user->name." ".$user->lastname;?></td>
				</tr>
				<?php endif; ?>
			</table>

			<br>

			<table class="table table-bordered table-hover">
				<thead class="table-primary">
					<tr>
						<th>Codigo</th>
						<th>Cantidad</th>
						<th>Nombre del Producto</th>
						<th>Precio Unitario</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($operations as $operation): ?>
					<?php $product = $operation->getProduct(); ?>
					<tr>
						<td><?php echo $product->id ;?></td>
						<td><?php echo $operation->q ;?></td>
						<td><?php echo $product->name ;?></td>
						<td>C$ <?php echo number_format($product->price_in,2,".",",") ;?></td>
						<td><b>C$ <?php echo number_format($operation->q*$product->price_in,2,".",","); $total+=$operation->q*$product->price_in;?></b></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<br><br>
		<div class="row">
			<div class="col-md-4">
				<h1>Total: C$ <?php echo number_format($total,2,'.',','); ?></h1>
			</div>
		</div>

	</div>
</div>

<?php else:?>
	<div class="alert alert-danger">501 Internal Error</div>
<?php endif; ?>
