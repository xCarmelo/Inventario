<?php

try {
    $product = ProductData::getById($_GET["id"]);

    if ($product != null) {
        $operations = OperationData::getAllByProductId($product->id);

        foreach ($operations as $op) {
            $op->del();
        }

        $product->del();
        Core::redir("./index.php?view=products&success=Producto eliminado exitosamente"); 
    } else {
        Core::redir("./index.php?view=products&error=El producto no existe"); 
    }

} catch (InvalidArgumentException $e) {
    Core::redir("./index.php?view=products&error=" . urlencode($e->getMessage())); 
} catch (Exception $e) {
    Core::redir("./index.php?view=products&error=" . urlencode($e->getMessage())); 
}

?>