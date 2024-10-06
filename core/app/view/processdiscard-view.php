<?php

if(isset($_SESSION["cartdiscard"])){
	$cart = $_SESSION["cartdiscard"];
	if(count($cart) > 0){
		$num_succ = 0;
		$process = false;
		$errors = array();
		foreach($cart as $c){

			$q = OperationData::getQYesF($c["product_id"]);
			if($c["q"]<=$q){
				if(isset($_POST["is_oficial"])){
				$qyf =OperationData::getQYesF($c["product_id"]); /// son los productos que puedo facturar
				if($c["q"]<=$qyf){
					$num_succ++;
				}else{
				$error = array("product_id"=>$c["product_id"],"message"=>"No hay suficiente cantidad de producto para facturar en inventario.");					
				$errors[count($errors)] = $error;
				}
				}else{
					// si llegue hasta aqui y no voy a facturar, entonces continuo ...
					$num_succ++;
				}
			}else{
				$error = array("product_id"=>$c["product_id"],"message"=>"No hay suficiente cantidad de producto en inventario.");
				$errors[count($errors)] = $error;
			}

		}

		if($num_succ == count($cart)){
			$process = true;
		}

		if($process == false){
			$_SESSION["errors"] = $errors;
			?>	
			<script>
				window.location = "index.php?view=discard";
			</script>
			<?php 
		}

		if($process == true){
			// Crear el objeto DiscardData e insertar los datos
			$discard = new DiscardData();
			$discard->user_id = $_SESSION["user_id"];
			$discard->operation_type_id = 3;

			// Llamar al método add directamente
			$d = $discard->add();

			foreach($cart as $c){

				$op = new OperationData(); 
				$op->product_id = $c["product_id"];
				$op->operation_type_id = 3; // Desecho
				$op->sell_id = $d[1];
				$op->q = $c["q"];
				$op->reason = $c["reason"];
				$add = $op->addDiscard();
			}

			// Limpiar el carrito de descarte
			unset($_SESSION["cartdiscard"]);
			?>
			
			<!-- Modal de confirmación de descarte -->
<div class="modal fade" id="discardModal" tabindex="-1" role="dialog" aria-labelledby="discardModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="discardModalLabel">Descarte realizado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalClose">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>El proceso de descarte se realizó con éxito.</p>
            </div>
            <div class="modal-footer">
                <a href="index.php?view=discard" class="btn btn-primary modal-close" id="modalAccept">Aceptar</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Mostrar el modal de Bootstrap al cargar la página
    $(document).ready(function() {
        $('#discardModal').modal('show');
    });

    // Redirigir a la vista discard después de hacer clic en el botón "Aceptar"
    document.getElementById("modalAccept").addEventListener("click", function() {
        window.location = "index.php?view=discard";
    });
</script>

			<?php
		}
	}
}

?>
