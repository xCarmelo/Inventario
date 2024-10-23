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
						<th>Descripción</th>
						<th>Precio Unitario</th> 
						<th>Total</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($operations as $operation): ?>
					<?php $product = $operation->getProduct(); ?>
					<tr>
						<td><?php echo $product->id ;?></td>
						<td><?php echo $operation->q ;?></td>
						<td><?php echo $product->name ;?></td>
						<td><?php echo $product->description ;?></td> 
						<td>C$ <?php echo number_format($product->price_in,2,".",",") ;?></td>
						<td><b>C$ <?php echo number_format($operation->q*$product->price_in,2,".",","); $total+=$operation->q*$product->price_in;?></b></td>
						<td>
						<button class="btn btn-xs btn-danger d-flex align-items-center text-white" data-bs-toggle="modal" data-bs-target="#confirmDevolucionModal" data-href="index.php?action=returnRe&idOperation=<?php echo $operation->id; ?>&idSell=<?php echo $_GET['id']; ?>">
                            <span>Devolución</span>
                            <i class="bi bi-arrow-return-left ms-2"></i>
                        </button>
						</td> 
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
$(document).ready(function () {
        // Selecciona el modal y el botón de confirmación
        var $confirmDevolucionModal = $('#confirmDevolucionModal');
        var $confirmDeleteBtn = $('#confirmDeleteBtn');
        var $motivoInput = $('#motivoDevolucion'); 
        var $motivoError = $('#motivoError'); 

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