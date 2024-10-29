<?php

function validate_data($data) {
    $errors = [];
    $valid = true;

    // Validación de la imagen
    if (isset($_FILES['image']) && $_FILES['image']['size'] != 0) { 
        $allowed_types = ['image/jpeg', 'image/png'];
        if ($_FILES['image']['size'] > 1048576) { 
            $valid = false;
            $errors['image'] = 'La imagen es demasiado grande. El tamaño máximo permitido es de 1 MB.';
        } elseif (!in_array($_FILES['image']['type'], $allowed_types)) {
            $valid = false;
            $errors['image'] = 'Tipo de archivo no válido. Solo se permiten formatos JPG y PNG.';
        }
    }

    // Validación de nombre
    if (!preg_match("/^[A-Za-zÁÉÍÓÚÑáéíóúñ\s0-9\-'\.]{3,50}$/", $data['name'])) {
        $valid = false;
        $errors['name'] = "El nombre del producto debe tener entre 3 y 50 caracteres y solo puede contener letras, números, espacios, guiones y puntos.";
    }

    // Validación de precio de entrada
    if (!preg_match("/^[0-9]{1,10}(\.[0-9]{1,3})?$/", $data['price_in'])) {
        $valid = false;
        $errors['price_in'] = "El precio de entrada debe ser un número positivo con hasta 10 dígitos y sin decimales.";
    }

    // Validación de precio de salida
    if (!preg_match("/^[0-9]{1,10}(\.[0-9]{1,3})?$/", $data['price_out'])) {
        $valid = false;
        $errors['price_out'] = "El precio de salida debe ser un número positivo con hasta 10 dígitos y sin decimales.";
    }

    // Validación de categoría
    if (!preg_match("/^[1-9][0-9]*$/", $data['category_id'])) {
        $valid = false;
        $errors['category_id'] = "Debes seleccionar una categoría válida. El ID de la categoría debe ser un número entero positivo.";
    }

    // Validación de presentación
    if (!preg_match("/^[A-Za-zÁÉÍÓÚÑáéíóúñ\s\-'\.0-9]{2,100}$/", $data['presentation'])) {
        $valid = false;
        $errors['presentation'] = "La presentación debe tener entre 2 y 100 caracteres, y solo puede contener letras, números, espacios, guiones y puntos.";
    }

    // Validación de descripción
    if (!preg_match("/^[A-Za-zÁÉÍÓÚÑáéíóúñ\s0-9\-'\.,!?¡¿]{3,1000}$/", $data['description'])) {
        $valid = false;
        $errors['description'] = "La descripción debe tener entre 3 y 1000 caracteres y puede contener letras, números, espacios y puntuación.";
    }

    // Validación de inventario mínimo
    if (!preg_match("/^[1-9][0-9]{0,3}$/", $data['inventary_min'])) {
        $valid = false;
        $errors['inventary_min'] = "El inventario mínimo debe ser un número entero positivo entre 1 y 9999.";
    }

    // Manejo de errores
    if (!$valid) { 
        $_SESSION['errors'] = $errors; 
        $_SESSION['form_data'] = $_POST; 
        header("Location: index.php?view=editproduct&id=" . $data['product_id'] . "&result=error");
        exit();
    } else {
        return $errors;
    }
}
 

if(count($_POST) > 0) {
    $product = ProductData::getById($_POST["product_id"]); 
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
        
        $is_active = isset($_POST["is_active"]) ? 1 : 0;
        $product->is_active = $is_active;

        $product->update();

        // Subir la imagen si hay una
        if(isset($_FILES["image"])) {
            $image = new Upload($_FILES["image"]);
            if($image->uploaded) {
                $image->Process("storage/products/");
                if($image->processed) {
                    if(!empty($product->image)){
                        if (file_exists("storage/products/". $product->image))
                            unlink("storage/products/". $product->image); // Eliminar la imagen anterior
                    }

                    $product->image = $image->file_dst_name;

                    $product->update_image(); 
                }
            }
        }

        // Redirigir con el parámetro `result=success`
        header("Location: index.php?view=editproduct&id=" . $_POST["product_id"] . "&result=success");
        exit();
    } else {
        header("Location: index.php?view=editproduct&id=" . $_POST["product_id"] . "&result=error");
        exit();
    }
}
?>