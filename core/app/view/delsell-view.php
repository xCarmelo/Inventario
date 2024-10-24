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
		$op->reason_for_return = $_GET['motivo'] . "(devolución de venta)";
		$op->del();
	}
	
	Core::redir("./index.php?view=sells&success=Devolución exitosa"); 
	}
	catch (Exception $e) {
		Core::redir("./index.php?view=sells&error=No se pudo completar la devolución"); 
	}
?>