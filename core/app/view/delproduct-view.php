<?php
function validateId($id) {
    // Verificar que el ID sea un número entero positivo y que esté dentro del rango permitido por MySQL para INT (signed)
    return preg_match('/^\d+$/', $id) && $id <= 2147483647;
}

try {
    if (!isset($_GET["id"]) || !validateId($_GET["id"])) {  
        throw new Exception("ID inválido.");  
    }

    $product = ProductData::getById($_GET["id"]);

    if (!$product) {
        throw new Exception("Cliente no encontrado.");
    }

    if ($product != null) {
        $operations = OperationData::getAllByProductId($product->id);

        foreach ($operations as $op) {
            $op->del();
        }
 
        $product->del();


        // Redirigir con mensaje de éxito
        Core::redir("./index.php?view=products&success=producto eliminado correctamente");
    }

} catch (Exception $e) { 
        // Redirigir con mensaje de error
        Core::redir("./index.php?view=products&error=" . urlencode('Error al eliminar el producto'));
}

?>