<?php
function validate_data($data, $vista) {
    $errors = [];
    $valid = true;

    if (!preg_match("/^[A-Za-zÁÉÍÓÚÑáéíóúñ\s0-9\-'\.]{1,50}$/", $data['search'])) {
        $valid = false;
        $errors['search'] = "El nombre solo puede contener letras, espacios, guiones. Debe tener entre 1 y 50 caracteres.";
    }

    if (!$valid) {
        redired($vista);    
        exit();
    } else {
        return $errors;
    }
} 

function redired($vista){
    header("Location: index.php?view=". $vista); 
    exit();
}

if (count($_POST) > 0) {

    $vista = $_POST['vista'];
    $errors = validate_data($_POST, $vista);

    if (count($errors) == 0){
        // If a search term is provided
        $search = $_POST['search'];
        $_SESSION['SearchItem' . $vista] = $search;

        redired($vista);

    }else{
        redired($vista);
    }


}else{
    redired($vista);
}

?>