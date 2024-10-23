<?php
		$user = UserData::getById($_GET["id"]); 

		$user->is_active=1;
		$result = $user->active_user();   

		if ($result) {
			Core::redir("./index.php?view=users&success=Usuario habilitado correctamente"); 
		
		} else { 
			Core::redir("./index.php?view=users&error=" . urlencode('Error al habilitar el usuario'));
		} 
?>  