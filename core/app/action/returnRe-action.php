<?php
try {

    if(isset($_GET['idSell']) && isset($_GET['idOperation']) && isset($_GET['idSell']) && isset($_GET['motivo'])){
        $operation = OperationData::getById($_GET['idOperation']);
    
        if((OperationData::getQYesF($operation->product_id) - $_GET['entradas']) < 0) 
			throw new Exception("No hay suficiente stock para devolver la compra.");
        
        $operation->operation_type_id = 4;
        $operation->reason_for_return = $_GET['motivo'] . " (devolución de compra)"; 
        $operation->id_sell = $_GET['idSell'];
        $operation->updateOperation(); 
    

        //tengo como un disparador en caso que en id_sell no haya mas operation, para que este cambien de operation_type_id
        $idSell = $_GET['idSell'];
    
        if ($idSell !== false) {
            header("Location: index.php?view=onere&id=$idSell&success=Devolución exitosa");
            exit; 
        }

    }

} catch (Exception) {
    $idSell = $_GET['idSell'];
    header("Location: index.php?view=onere&id=$idSell&error=No se pudo completar la devolución, por favor revisa el stock de los articulos");

}
?>



