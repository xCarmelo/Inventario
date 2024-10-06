<?php

if (!isset($_SESSION["cartdiscard"])) {
    // Inicializar el carrito de descarte con el primer producto
    $product = array(
        "product_id" => $_POST["product_id"],
        "q" => $_POST["q"],
        "reason" => $_POST["reason"] // Guardar el motivo del descarte
    );
    $_SESSION["cartdiscard"] = array($product);

    $cartdiscard = $_SESSION["cartdiscard"];
    
    $num_succ = 0;
    $process = false;
    $errors = array(); 

    foreach ($cartdiscard as $c) {
        $q = OperationData::getQYesF($c["product_id"]);
        if ($c["q"] <= $q) {
            $num_succ++; 
        } else {
            $error = array("product_id" => $c["product_id"], "message" => "No hay suficiente cantidad de producto en inventario.");
            $errors[] = $error;
        }
    }

    if ($num_succ == count($cartdiscard)) {
        $process = true;
    }

    if (!$process) {
        unset($_SESSION["cartdiscard"]);
        $_SESSION["errors"] = $errors;
        echo "<script>window.location='index.php?view=discard';</script>";
        exit();
    } else {
        // Debug: Verificar el contenido del carrito de descarte
        echo '<pre>';
        print_r($_SESSION["cartdiscard"]);
        echo '</pre>';
        echo "<script>window.location='index.php?view=discard';</script>";
        exit();
    }

} else {
    // Manejo de adiciones subsecuentes de productos al carrito de descarte
    $found = false;
    $cartdiscard = $_SESSION["cartdiscard"];
    $index = 0;
    $q = OperationData::getQYesF($_POST["product_id"]);
    $can = $_POST["q"] <= $q;

    if (!$can) {
        $error = array("product_id" => $_POST["product_id"], "message" => "No hay suficiente cantidad de producto en inventario.");
        $errors[] = $error;
        $_SESSION["errors"] = $errors;
        echo "<script>window.location='index.php?view=discard';</script>";
        exit();
    }

    foreach ($cartdiscard as $c) {
        if ($c["product_id"] == $_POST["product_id"]) {
            $found = true;
            break;
        }
        $index++;
    }

    if ($found) {
        $cartdiscard[$index]["q"] += $_POST["q"];
        $cartdiscard[$index]["reason"] = $_POST["reason"];
    } else {
        $cartdiscard[] = array(
            "product_id" => $_POST["product_id"],
            "q" => $_POST["q"],
            "reason" => $_POST["reason"] // Guardar el motivo del descarte
        );
    }

    $_SESSION["cartdiscard"] = $cartdiscard;

    echo "<script>window.location='index.php?view=discard';</script>";
    exit();
}

?>
