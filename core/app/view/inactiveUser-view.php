<?php
		$user = UserData::getById($_GET["id"]); 

		$user->is_active=0;
		$result = $user->desactive_user(); 

		if ($result) {
			Core::redir("./index.php?view=users&success=Usuario eliminado correctamente"); 
		
		} else { 
			Core::redir("./index.php?view=users&error=" . urlencode('Error al eliminar el usuario'));
		} 
?>  