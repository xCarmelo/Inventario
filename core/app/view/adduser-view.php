<?php
function validate_data($data) { 
    $errors = [];
    $valid = true;

    // Validaciones para cada campo
    if (!preg_match("/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]{2,255}$/", $data['name'])) {
        $valid = false;
        $errors['name'] = "El nombre debe tener entre 2 y 255 caracteres y solo puede contener letras y espacios.";
    }

    if (!preg_match("/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]{2,50}$/", $data['lastname'])) {
        $valid = false;
        $errors['lastname'] = "El apellido debe tener entre 2 y 50 caracteres y solo puede contener letras y espacios.";
    }

    if (!preg_match("/^[a-zA-Z0-9\s,-]{2,50}$/", $data['username'])) {
        $valid = false;
        $errors['username'] = "El nombre de usuario debe tener entre 2 y 50 caracteres, solo puede contener letras sin acentos, números, espacios, comas y guiones.";
    }

    if (UserData::searchuser($data['username'])) {
        $valid = false;
        $errors['username'] = "Este nombre de usuario ya existe. Elige uno diferente.";
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $valid = false;
        $errors['email'] = "Ingrese un correo electrónico válido en el formato usuario@dominio.com.";
    }

    if (!preg_match("/^[0-9]{8}$/", $data['phone'])) {
        $valid = false;
        $errors['phone'] = "El número de teléfono debe tener exactamente 8 dígitos y solo puede contener números.";
    }

    if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*(),.?\":{}|<>])[A-Za-z\d!@#$%^&*(),.?\":{}|<>]{8,}$/", $data['password'])) {
        $valid = false;
        $errors['password'] = "La contraseña debe tener al menos 8 caracteres, incluyendo una letra mayúscula, una letra minúscula, un número y un carácter especial.";
    }
    

    if (!$valid) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header("Location: index.php?view=newuser&result=error"); 
        exit();
    } else {
        return $errors;
    }
}


if(count($_POST)>0){
	$user = new UserData(); 
	$errors = validate_data($_POST);

	if (count($errors) == 0){ 

		$is_admin=0;
		if(isset($_POST["is_admin"])){$is_admin=1;}

		$user->name = $_POST["name"];
		$user->lastname = $_POST["lastname"];
		$user->username = $_POST["username"];
		$user->email = $_POST["email"];
		$user->phone = $_POST["phone"];
		$user->password = $_POST["password"];
		$user->is_admin=$is_admin;

		$user->add();
 
		// En lugar de redirigir, establecer una baandera de éxito
		$_SESSION['success'] = 'Usuario agregado exitosamente.';
		$_SESSION['redirect_to'] = 'index.php?view=users';
	} else {
			// Establecer la variable de errores
			$_SESSION['errors'] = $errors; 
			$_SESSION['form_data'] = $_POST;  // Mantener los datos ingresados
			// No redirect, let the page render with the error modal
		}

		// Redirigir siempre a la misma página para mostrar el modal
		header("Location: index.php?view=newuser&result=error");
		exit();
}


?>