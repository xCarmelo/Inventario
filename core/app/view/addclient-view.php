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
	
		if (!preg_match("/^[a-zA-Z0-9\s,-]{5,50}$/", $data['address1'])) {
			$valid = false;
			$errors['address1'] = "La dirección debe tener al menos 5 caracteres.";
		}
	
		if (!filter_var($data['email1'], FILTER_VALIDATE_EMAIL)) {
			$valid = false;
			$errors['email1'] = "Ingrese un correo electrónico válido.";
		}
	
		if (!preg_match("/^[0-9]{8}$/", $data['phone1'])) {
			$valid = false;
			$errors['phone1'] = "El número de teléfono debe tener 8 dígitos.";
		}

        if (!$valid) {
			$_SESSION['errors'] = $errors;
			$_SESSION['form_data'] = $_POST;
			header("Location: index.php?view=newclient&result=error"); 
			exit();
		}
		else return $errors;
    } 

	if (count($_POST) > 0) {
		$user = new PersonData(); 
		$errors = validate_data($_POST);
	
		if (count($errors) == 0) {
			// Si no hay errores, agregar el cliente  
			$user->name = $_POST["name"];
			$user->lastname = $_POST["lastname"];
			$user->address1 = $_POST["address1"]; 
			$user->email1 = $_POST["email1"];  
			$user->phone1 = $_POST["phone1"]; 
	
			$user->add_client();
	
			// En lugar de redirigir, establecer una baandera de éxito
			$_SESSION['success'] = 'Cliente agregado exitosamente.';
			$_SESSION['redirect_to'] = 'index.php?view=clients';
		} else {
			// Establecer la variable de errores
			$_SESSION['errors'] = $errors;
			$_SESSION['form_data'] = $_POST;  // Mantener los datos ingresados
			// No redirect, let the page render with the error modal
		}

			// Redirigir siempre a la misma página para mostrar el modal
			header("Location: index.php?view=newclient&result=error");
			exit();
	}
	

?>