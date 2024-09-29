<?php
    function validate_data($data) {  
		$errors = [];
		$valid = true;

		if (!preg_match("/^[a-zA-Z0-9\s,-]{2,50}$/", $data['username'])) {
			$valid = false;
			$errors['username'] = "El usuario debe tener al menos 2 caracteres, sin acento.";
		}

		if (!preg_match("/^(?=.*\d)[A-Za-z\d]{5,}$/", $data['password'])) {
			$valid = false;
			$errors['password'] = "La contraseña debe tener al menos 8 caracteres y contener al menos un número.";
		}

        if (!$valid) {
			$_SESSION['errors'] = $errors;
			$_SESSION['form_data'] = $_POST;
			header("Location: index.php?view=login&result=error"); 
			exit();
		}
		else return $errors;
    } 

if(count($_POST)>0){
    if (!isset($_SESSION["user_id"])){

        $errors = validate_data($_POST);

        if (count($errors) == 0){
            $user = $_POST['username'];
            $pass = $_POST['password']; 
        
            $base = new Database();
            $con = $base->connect();
        
            // Consulta preparada
            $stmt = $con->prepare("SELECT id, is_admin, username FROM user WHERE username = ? AND password = ? AND is_active = 1");
            $stmt->bind_param("ss", $user, $pass);
            $stmt->execute();
            $stmt->bind_result($userid,$isAdmin, $username); 
        
            $found = false;
            if ($stmt->fetch()) {
                $found = true;
            }
        
            $stmt->close();
        
            if ($found) {
                $_SESSION['user_id'] = $userid;
                $_SESSION['is_admin'] = $isAdmin;
                $_SESSION['username'] = $username;
                echo "<script>window.location='index.php?view=home';</script>";
            
            }
            else{
                $_SESSION['errors'] = "sdf";
			    $_SESSION['form_data'] = $_POST;
                echo "<script>window.location='index.php?view=login&result=error';</script>";
            }
        
    } 
    else{
        echo "<script>window.location='index.php?view=home';</script>";
    }
}
}
?>
