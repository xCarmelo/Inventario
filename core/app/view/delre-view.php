<?php
function validateId($id) {
    // Verificar que el ID sea un número entero positivo y que esté dentro del rango permitido por MySQL para INT (signed)
    return preg_match('/^\d+$/', $id) && $id <= 2147483647; 
}

try {
    if (!isset($_GET["id"]) || !validateId($_GET["id"])) { 
        throw new Exception("ID inválido.");  
    }

	$operations = OperationData::getAllProductsBySellId($_GET["id"]);

	foreach ($operations as $op) {  
		if((OperationData::getQYesF($op->product_id) - $op->q) < 0) 
			throw new Exception("No hay suficiente stock para devolver la compra.");
		
		$op->reason_for_return = $_GET['motivo'] . " (devolución de compra)";
		$op->del();
	}

	//Redirigir con mensaje de éxito
	Core::redir("./index.php?view=res&success=Compra eliminada correctamente"); 

} 
catch (Exception $e) {
    // Redirigir con mensaje de error
    Core::redir("./index.php?view=res&error=" . urlencode('No se pudo completar la devolución, por favor revisa el stock de los articulos'));
}
?>