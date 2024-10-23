<?php

function validateId($id) {
    // Verificar que el ID sea un número entero positivo y que esté dentro del rango permitido por MySQL para INT (signed)
    return preg_match('/^\d+$/', $id) && $id <= 2147483647; 
}

try {
    if (!isset($_GET["id"]) || !validateId($_GET["id"])) {
        throw new Exception("ID inválido.");  
    }

    $client = PersonData::getById($_GET["id"]);

    if (!$client) { 
        throw new Exception("Cliente no encontrado.");  
    }

    if(isset($_GET['active']) && $_GET['active'] == 1)
    {
        $client->del(1);
        Core::redir("./index.php?view=clients&success=Cliente habilitado correctamente"); 
    }
    else
    {
        $client->del();
        Core::redir("./index.php?view=clients&success=Cliente eliminado correctamente"); 
    }

    // Redirigir con mensaje de éxito

} catch (Exception $e) {
    
    if(isset($_GET['active']) && $_GET['active'] == 1)
        Core::redir("./index.php?view=clients&error=" . urlencode('Error al habilitar el cliente'));
    else
        Core::redir("./index.php?view=clients&error=" . urlencode('Error al eliminar el cliente'));

}

?>
