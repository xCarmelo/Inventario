<?php
function validate_data($data) {
    $errors = [];
    $valid = true;

    // Validación para verificar si el cliente ya existe
    if (PersonData::getClientsFiend($data['name'], $data['lastname'], $data['user_id'])) {
        $valid = false;
        $errors['name'] = "Este cliente ya existe. Verifique el nombre y apellido.";
        $errors['lastname'] = "Este cliente ya existe. Verifique el nombre y apellido.";
    }

    // Validación de correo electrónico
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $valid = false;
        $errors['email'] = "Ingrese un correo electrónico válido en el formato usuario@dominio.com.";
    }

    // Validación de nombre
    if (!preg_match("/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]{2,255}$/", $data['name'])) {
        $valid = false;
        $errors['name'] = "El nombre debe tener entre 2 y 255 caracteres, y solo puede contener letras y espacios.";
    }

    // Validación de apellido
    if (!preg_match("/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]{2,50}$/", $data['lastname'])) {
        $valid = false;
        $errors['lastname'] = "El apellido debe tener entre 2 y 50 caracteres, y solo puede contener letras y espacios.";
    }

    // Validación de dirección
    if (!preg_match("/^[A-Za-záéíóúÁÉÍÓÚñÑ0-9\s,-]{5,50}$/", $data['address1'])) {
        $valid = false;
        $errors['address1'] = "La dirección debe tener entre 5 y 50 caracteres y solo puede contener letras, números, espacios, comas y guiones.";
    }

    // Validación de teléfono
    if (!preg_match("/^[0-9]{8}$/", $data['phone1'])) {
        $valid = false;
        $errors['phone1'] = "El número de teléfono debe tener exactamente 8 dígitos y solo puede contener números.";
    }

    // Manejo de errores
    if (!$valid) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header("Location: index.php?view=editclient&id=" . $data["user_id"] . "&result=error");
        exit();
    } else {
        return $errors;
    }
}



if (count($_POST) > 0) {
    $errors = validate_data($_POST);

    if (count($errors) == 0) {
        // Obtener el cliente existente
        $user = PersonData::getById($_POST["user_id"]);
        $user->name = $_POST["name"];
        $user->lastname = $_POST["lastname"];
        $user->address1 = $_POST["address1"];
        $user->email1 = $_POST["email"];
        $user->phone1 = $_POST["phone1"]; 

        $result = $user->update();
        
			if ($result) {
				// Redirigir con éxito 
				$_SESSION['success'] = 'Cliente actualizado correctamente.';
				$_SESSION['form_data'] = $_POST; // Store updated data in session
				print "<script>window.location='index.php?view=editclient&id=" . $_POST["user_id"] . "';</script>";
			
			} else {
				// Manejo del error
				$_SESSION['errors'] = ['Hubo un error al actualizar el cliente.'];
				$_SESSION['form_data'] = $_POST;
				print "<script>window.location='index.php?view=editclient&id=" . $_POST["user_id"] . "';</script>";
			}
		} else {
		// Si hay errores de validación
		$_SESSION['errors'] = $errors;
		}

		// Redirigir siempre a la misma página para mostrar el modal
		header("Location: index.php?view=editclient&id=" . $_POST["user_id"]);
		exit();
	}

	?>