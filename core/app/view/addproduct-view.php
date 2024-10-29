<?php
function validate_data($data) {
    $errors = [];
    $valid = true;

    // Validación de la imagen
    if (isset($_FILES['image']) && $_FILES['image']['size'] != 0) { 
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        if ($_FILES['image']['size'] > 10485760) {
            $valid = false;
            $errors['image'] = 'La imagen es demasiado grande (máximo 10MB). Solo se permiten JPG y PNG.';
        } elseif (!in_array($_FILES['image']['type'], $allowed_types)) {
            $valid = false;
            $errors['image'] = 'Tipo de archivo no válido. Solo se permiten archivos JPG y PNG.';
        }
    }

    if (!preg_match("/^[A-Za-zÁÉÍÓÚÑáéíóúñ\s0-9\-'\.]{1,50}$/", $data['name'])) {
        $valid = false;
        $errors['name'] = "El nombre del producto solo puede contener letras, números, espacios, guiones y puntos. Debe tener entre 1 y 50 caracteres.";
    }
    
    if (!preg_match("/^[0-9]{1,10}(\.[0-9]{1,3})?$/", $data['price_in'])) {
        $valid = false;
        $errors['price_in'] = "El precio de entrada debe ser un número positivo de hasta 10 dígitos y sin decimales.";
    }
    if (!preg_match("/^[0-9]{1,10}(\.[0-9]{1,3})?$/", $data['price_out'])) {
        $valid = false;
        $errors['price_out'] = "El precio de salida debe ser un número positivo de hasta 10 dígitos y sin decimales.";
    }
    
    if (!preg_match("/^[1-9][0-9]*$/", $data['category_id'])) {
        $valid = false;
        $errors['category_id'] = "Debes seleccionar una categoría válida. Solo se permiten números enteros positivos.";
    }

    if (!preg_match("/^[A-Za-zÁÉÍÓÚÑáéíóúñ\s\-'\.0-9]{2,50}$/", $data['presentation'])) {
        $valid = false;
        $errors['presentation'] = "La presentación debe tener entre 2 y 50 caracteres, y solo puede contener letras, números, espacios, guiones y puntos.";
    }
    
    if (!preg_match("/^[A-Za-zÁÉÍÓÚÑáéíóúñ\s0-9\-'\.,!?¡¿]{3,1000}$/", $data['description'])) {
        $valid = false;
        $errors['description'] = "La descripción puede contener letras, números, signos de puntuación básicos y debe tener entre 3 y 1000 caracteres.";
    }

    if (!preg_match("/^[1-9][0-9]{0,3}$/", $data['inventary_min'])) {
        $valid = false;
        $errors['inventary_min'] = "El inventario mínimo debe ser un número entero positivo entre 1 y 9999.";
    }

    if (!$valid) {
        $_SESSION['errors'] = $errors; 
        $_SESSION['form_data'] = $_POST; 
        header("Location: index.php?view=newproduct&id=" . $data['product_id']);
        exit();
    } else {
        return $errors;
    }
}


if (count($_POST) > 0) { 
    $product = new ProductData();
    $errors = validate_data($_POST);  

    if (count($errors) == 0) {
            $product->name = $_POST["name"];
            $product->price_in = $_POST["price_in"];
            $product->price_out = $_POST["price_out"];
            $product->description = $_POST["description"];
            $product->presentation = $_POST["presentation"];
            $product->category_id = $_POST["category_id"];
            $product->inventary_min = $_POST["inventary_min"];
            $product->user_id = $_SESSION["user_id"]; 

        //validacion para imagen 
        if (isset($_FILES["image"]) && $_FILES['image']['size'] != 0) {
            $image = new Upload($_FILES["image"]);
            if ($image->uploaded) {
                $image->Process("storage/products/");
                if ($image->processed) {
                    $product->image = $image->file_dst_name;
                    $prod = $product->add_with_image();
                }
            } else {
                $prod = $product->add();
            }
        } else {
            $prod = $product->add(); 
        }

        // En lugar de redirigir, establecer una baandera de éxito 
        $_SESSION['success'] = 'Producto agregado exitosamente.';
        $_SESSION['redirect_to'] = 'index.php?view=products';

        // Redirigir con parámetro de éxito
        header("Location: index.php?view=newproduct&result=success"); 
    }else
        {
            header("Location: index.php?view=newproduct&result=error");
            exit();
        }
}

?>