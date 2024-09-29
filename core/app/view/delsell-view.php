<?php

function validateId($id) {
    // Verificar que el ID sea un número entero positivo y que esté dentro del rango permitido por MySQL para INT (signed)
    return preg_match('/^\d+$/', $id) && $id <= 2147483647;
} 


try {
	if (!isset($_GET["id"]) || !validateId($_GET["id"])) {
		throw new Exception("ID inválido.");  
	}
	
	$sell = SellData::getById($_GET["id"]);
	$operations = OperationData::getAllProductsBySellId($_GET["id"]);
	
	foreach ($operations as $op) { 
		$op->del();
	}
	
	$sell->del();
	Core::redir("./index.php?view=sells&success=Venta eliminada correctamente"); 

} catch (Exception $e) {
	// Redirigir con mensaje de error
    Core::redir("./index.php?view=sells&error=" . urlencode('Error al eliminar la venta'));
}
?>