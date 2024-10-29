<?php
function validate_data($data) { 
    $errors = [];
    $valid = true;

    if (PersonData::getClientsFiend($data['name'], $data['lastname'], 0, 2)) {
        $valid = false;
        $errors['name'] = "Este proveedor ya existe.";
        $errors['lastname'] = "Este proveedor ya existe.";
    }

    // Validaciones para cada campo
    if (!preg_match("/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]{2,255}$/", $data['name'])) {
        $valid = false;
        $errors['name'] = "El nombre debe tener entre 2 y 255 caracteres y solo puede contener letras y espacios.";
    }

    if (!preg_match("/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]{2,50}$/", $data['lastname'])) {
        $valid = false;
        $errors['lastname'] = "El apellido debe tener entre 2 y 50 caracteres y solo puede contener letras y espacios.";
    }

    if (!preg_match("/^[A-Za-záéíóúÁÉÍÓÚñÑ0-9\s,-]{5,100}$/", $data['address1'])) {
        $valid = false;
        $errors['address1'] = "La dirección debe tener entre 5 y 100 caracteres. Solo se permiten letras, números, espacios, comas y guiones.";
    }

    if (!filter_var($data['email1'], FILTER_VALIDATE_EMAIL)) {
        $valid = false;
        $errors['email1'] = "Ingrese un correo electrónico válido en formato usuario@dominio.com.";
    }

    if (!preg_match("/^[0-9]{8}$/", $data['phone1'])) { 
        $valid = false;
        $errors['phone1'] = "El número de teléfono debe tener exactamente 8 dígitos y solo puede contener números.";
    }

    if (!$valid) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header("Location: index.php?view=newprovider&result=error");
        exit();
    } else {
        return $errors;
    }
}


if (count($_POST) > 0) {
	$user = new PersonData();
	$errors = validate_data($_POST);  

	if (count($errors) == 0) {
		$user->name = $_POST["name"]; 
		$user->lastname = $_POST["lastname"];
		$user->address1 = $_POST["address1"];  
		$user->email1 = $_POST["email1"];
		$user->phone1 = $_POST["phone1"];
		$user->add_provider();

		// Establecer una bandera de éxito
		$_SESSION['success'] = 'Proveedor agregado exitosamente.';
		header("Location: index.php?view=newprovider&result=success");
		exit();
	}
}

?>