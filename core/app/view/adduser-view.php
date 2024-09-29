<?php
    function validate_data($data) { 
		$errors = [];
		$valid = true;

		// Validaciones para cada campo
		if (!preg_match("/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]{2,255}$/", $data['name'])) {
			$valid = false;
			$errors['name'] = "El nombre debe tener al menos 2 caracteres.";
		}
	
		if (!preg_match("/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]{2,50}$/", $data['lastname'])) {
			$valid = false;
			$errors['lastname'] = "El apellido debe tener al menos 2 caracteres.";
		}

		if (!preg_match("/^[a-zA-Z0-9\s,-]{2,50}$/", $data['username'])) {
			$valid = false;
			$errors['username'] = "El usuario debe tener al menos 2 caracteres, sin acento.";
		}

		if(UserData::searchuser($data['username']))
		{
			$valid = false;
			$errors['username'] = "Este usuario ya existe.";
		}
	
		if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$valid = false;
			$errors['email'] = "Ingrese un correo electrónico válido.";
		}
	
		if (!preg_match("/^[0-9]{8}$/", $data['phone'])) {
			$valid = false;
			$errors['phone'] = "El número de teléfono debe tener 8 dígitos.";
		}

		if (!preg_match("/^(?=.*\d)[A-Za-z\d]{5,}$/", $data['password'])) {
			$valid = false;
			$errors['password'] = "La contraseña debe tener al menos 8 caracteres y contener al menos un número.";
		}

        if (!$valid) {
			$_SESSION['errors'] = $errors;
			$_SESSION['form_data'] = $_POST;
			header("Location: index.php?view=newuser&result=error"); 
			exit();
		}
		else return $errors;
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