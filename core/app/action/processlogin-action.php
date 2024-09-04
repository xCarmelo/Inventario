<?php

if (!isset($_SESSION["user_id"])) {
    $user = $_POST['username'];
    $pass = sha1(md5($_POST['password']));

    $base = new Database();
    $con = $base->connect();

    // Consulta preparada
    $stmt = $con->prepare("SELECT id, is_admin FROM user WHERE (email = ? OR username = ?) AND password = ? AND is_active = 1");
    $stmt->bind_param("sss", $user, $user, $pass);
    $stmt->execute();
    $stmt->bind_result($userid,$isAdmin);

    $found = false;
    if ($stmt->fetch()) {
        $found = true;
    }

    $stmt->close();

    if ($found) {
        $_SESSION['user_id'] = $userid;
		$_SESSION['is_admin'] = $isAdmin;
        echo "Cargando ... $user $isAdmin";
        echo "<script>window.location='index.php?view=home';</script>";
    } else {
        echo "<script>window.location='index.php?view=login';</script>";
    }
} else {
    echo "<script>window.location='index.php?view=home';</script>";
}
?>
