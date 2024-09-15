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

    $products = ProductData::getAllByCategoryId($category->id);
    foreach ($products as $product) {
        $product->del_category();
    }

    $category->del();

    // Redirigir con mensaje de éxito
    Core::redir("./index.php?view=categories&success=Categoría eliminada correctamente");

} catch (Exception $e) {
    // Redirigir con mensaje de error
    Core::redir("./index.php?view=categories&error=" . urlencode('Error al eliminar la categoria'));
}

?>
