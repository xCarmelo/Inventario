<?php

function validateId($id) {
    // Verificar que el ID sea un número entero positivo y que esté dentro del rango permitido por MySQL para INT (signed)
    return preg_match('/^\d+$/', $id) && $id <= 2147483647;
}

try {
    if (!isset($_GET["id"]) || !validateId($_GET["id"])) { 
        throw new Exception("ID inválido.");
    }

    $category = CategoryData::getById($_GET["id"]);
    
    if (!$category) {
        throw new Exception("Categoría no encontrada.");
    }

    if(isset($_GET['active']) && $_GET['active'] == 1)
    {
        $category->del(1);
        Core::redir("./index.php?view=categories&success=Categoria habilitada correctamente");
    }
    else
    {
        $category->del();
        Core::redir("./index.php?view=categories&success=Categoria deshabilitada correctamente");
    }


} catch (Exception $e) {
    if(isset($_GET['active']) && $_GET['active'] == 1)
        Core::redir("./index.php?view=categories&error=" . urlencode('Error al habilitar el categories'));
    else
    Core::redir("./index.php?view=categories&error=" . urlencode('Error al eliminar el categories'));
    
}

?>
