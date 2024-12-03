<?php
function validarCategoria($categoria) {
    $pattern = "/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\s]{3,30}$/";
    if (!preg_match($pattern, $categoria)) {
        return "La categoría debe contener entre 3 y 30 caracteres alfanuméricos.";
    }
    return true;
}

if (count($_POST) > 0) {
    $categoria = $_POST["categoria"];
    $user = CategoryData::getById($_POST["user_id"]);
    
    // Validación
    $error = validarCategoria($categoria);
    if ($error !== true) {
        // Guardar mensaje de error en la sesión
        $_SESSION['error_msg'] = $error;
        print "<script>window.location='index.php?view=editcategory&id=" . $_POST["user_id"] . "&result=error';</script>";
        exit;
    }

    // Verificar si la categoría ya existe
    if (CategoryData::searchCategory($categoria)) {
        $_SESSION['error_msg'] = "La categoría ya existe.";
        $_SESSION['errors'] = "La categoría ya existe.";
        print "<script>window.location='index.php?view=editcategory&id=" . $_POST["user_id"] . "&result=error';</script>";
        exit;
    }
    
    $user->name = $categoria;
    
    // Proceder a actualizar la base de datos y manejar el resultado
    $resultado = $user->update();
    
    if ($resultado['success']) {
        $_SESSION['success'] = 'Cliente actualizado correctamente.';
        // Redirigir si la operación fue exitosa
        header("Location: index.php?view=editcategory&id=" . $_POST["user_id"] . "&result=success");
    } else {
        // Guardar mensaje de error en la sesión si falla
        $_SESSION['error_msg'] = $resultado['error'];
        print "<script>window.location='index.php?view=editcategory&id=" . $_POST["user_id"] . "&result=error';</script>";
    }
    exit;
}
?>
