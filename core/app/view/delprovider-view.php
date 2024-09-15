<?php

function validateId($id) {
    // Verificar que el ID sea un número entero positivo y que esté dentro del rango permitido por MySQL para INT (signed)
    return preg_match('/^\d+$/', $id) && $id <= 2147483647;
}

try {
    if (!isset($_GET["id"]) || !validateId($_GET["id"])) {
        throw new Exception("ID inválido.");  
    }

    $provider = PersonData::getById($_GET["id"]);

    if (!$provider) {
        throw new Exception("Proveedor no encontrado.");
    }

    $provider->del();

    // Redirigir con mensaje de éxito
    Core::redir("./index.php?view=providers&success=Proveedor eliminado correctamente"); 

} catch (Exception $e) {
    // Redirigir con mensaje de error
    Core::redir("./index.php?view=providers&error=" . urlencode('Error al eliminar el proveedor'));
}

?>
?>