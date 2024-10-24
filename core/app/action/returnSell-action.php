<?php

if(isset($_GET['idSell']) && isset($_GET['idOperation']) && isset($_GET['idSell']) && isset($_GET['motivo'])){
    $operation = OperationData::getById($_GET['idOperation']);
 
    //optener la sell para actualizar el total 
    $sell = SellData::getById($_GET['idSell']);
    $sell->id = $_GET['idSell'];
    $sell->operation_type_id = 4;
    $sell->total = $sell->total - $operation->new_price; 
    $sell->update_total();

    $operation->operation_type_id = 4;
    $operation->reason_for_return = $_GET['motivo'] . " (devolución de venta)";
    $operation->id_sell = $_GET['idSell'];
    $operation->updateOperation(); 

    $idSell = filter_input(INPUT_GET, 'idSell', FILTER_SANITIZE_NUMBER_INT);

    if ($idSell !== false) {
        header("Location: index.php?view=onesell&id=$idSell&success=Devolución exitosa");
        exit; 
    }
}


?>


<!--pero que no muestre el sell en venta si ya no hay operation, si no me la mostraria vacia 
    seria eliminar sell tambien--> 

