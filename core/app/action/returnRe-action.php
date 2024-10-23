<?php

try {
    if(isset($_GET['idSell']) && isset($_GET['idOperation']) && isset($_GET['idSell']) && isset($_GET['motivo'])){
        $operation = OperationData::getById($_GET['idOperation']);
    
        if((OperationData::getOutputQYesF($operation->product_id) - $op->q) <= 0) 
			throw new Exception("No hay suficiente stock para devolver la compra.");
        
        $operation->operation_type_id = 4;
        $operation->reason_for_return = $_GET['motivo'];
        $operation->id_sell = $_GET['idSell'];
        $operation->updateOperation(); 
    
        $idSell = $_GET['idSell'];
    
        if ($idSell !== false) {
            header("Location: index.php?view=onere&id=$idSell&success=Devolución exitosa");
            exit; 
        }
    }
} catch (\Throwable $th) {
    $idSell = $_GET['idSell'];
    header("Location: index.php?view=onere&id=$idSell&error=No se pudo completar la devolución, por favor revisa el stock de los articulos");

}


?>



