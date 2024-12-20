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
            $_SESSION['error_msg'] = "La categoría ya existe, puede que este activa o inactiva.";
            $_SESSION['errors'] = [$_SESSION['error_msg']]; // Asegúrate de que esto esté en la sesión
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
            $_SESSION['errors'] = [$_SESSION['error_msg']]; // Asegúrate de que se guarde un array en 'errors'
            print "<script>window.location='index.php?view=newcategory&result=error';</script>";
            exit;
        } else {
            // Proceder a agregar a la base de datos y manejar el resultado
            $resultado = $user->add();
    
            if ($resultado['success']) {
                // Guardar mensaje de éxito en la sesión
                $_SESSION['success'] = "Categoría agregada con éxito.";
                print "<script>window.location='index.php?view=newcategory&result=success';</script>";
            } else {
                // Guardar mensaje de error en la sesión si falla
                $_SESSION['error_msg'] = $resultado['error_msg'];
                $_SESSION['errors'] = [$_SESSION['error_msg']]; // Asegúrate de que esto esté en la sesión
                print "<script>window.location='index.php?view=newcategory&result=error';</script>";
            }
            exit;
        }
    }
?>    