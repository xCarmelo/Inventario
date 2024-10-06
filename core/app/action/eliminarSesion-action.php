<?php
    $vista = $_POST['vista'];
    unset($_SESSION['SearchItem'. $vista]);
    header("Location: index.php?view=". $vista);
    exit;
?>