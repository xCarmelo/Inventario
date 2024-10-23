<?php 
if(isset($_SESSION['filtroActiveUser'])){
    if($_SESSION['filtroActiveUser'] == 0){
        $_SESSION['filtroActiveUser'] = 1;
        header("Location: index.php?view=" . $_POST['view']);
		exit();
    }
    else{ 
        $_SESSION['filtroActiveUser'] = 0; 
        header("Location: index.php?view=" . $_POST['view']);
		exit();
    }
}
else{
    $_SESSION['filtroActiveUser'] = 0;
    header("Location: index.php?view=". $_POST['view']);
		exit();
}
?>