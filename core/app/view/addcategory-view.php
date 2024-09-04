<?php
function validarCategoria($categoria) {
    $pattern = "/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\s]{3,30}$/";
    if (!preg_match($pattern, $categoria)) {
        return "La categoría debe contener entre 3 y 30 caracteres alfanuméricos";
    }
    return true;
}

if(count($_POST) > 0){
    $categoria = $_POST["categoria"];

    // Verificar si la categoría ya existe
    if (CategoryData::searchCategory($categoria)) {
        $_SESSION['error_msg'] = "La categoría ya existe.";
        print "<script>window.location='index.php?view=newcategory&result=error';</script>";
        exit;
    }

    $user = new CategoryData();
    $user->name = $categoria;

    // Validación
    $error = validarCategoria($user->name);
    if ($error !== true) {
        // Guardar mensaje de error en la sesión
        $_SESSION['error_msg'] = $error;
        print "<script>window.location='index.php?view=newcategory&result=error';</script>";
        exit;
    } else {
        // Proceder a agregar a la base de datos y manejar el resultado
        $resultado = $user->add();

        if ($resultado['success']) {
            // Redirigir si la operación fue exitosa
            print "<script>window.location='index.php?view=newcategory&result=success';</script>";
        } else {
            // Guardar mensaje de error en la sesión si falla
            $_SESSION['error_msg'] = $resultado['error_msg'];
            print "<script>window.location='index.php?view=newcategory&result=error';</script>";
        }
        exit;
    }
}

?>