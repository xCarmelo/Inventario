<?php

if (!isset($_SESSION["cart"])) {
    // Initialize the cart with the first product
    $product = array("product_id" => $_POST["product_id"], "q" => $_POST["q"], "newprice" => $_POST["newprice"]);
    $_SESSION["cart"] = array($product);

    $cart = $_SESSION["cart"];
    
    $num_succ = 0;
    $process = false;
    $errors = array(); 

    foreach ($cart as $c) {
        $q = OperationData::getQYesF($c["product_id"]);
        if ($c["q"] <= $q) {
            $num_succ++;
        } else {
            $error = array("product_id" => $c["product_id"], "message" => "No hay suficiente cantidad de producto en inventario.");
            $errors[] = $error;
        }
    }

    if ($num_succ == count($cart)) {
        $process = true;
    }

    if (!$process) {
        unset($_SESSION["cart"]);
        $_SESSION["errors"] = $errors;
        echo "<script>window.location='index.php?view=sell';</script>";
        exit();
    } else {
        echo "<script>window.location='index.php?view=sell';</script>";
        exit();
    }

} else {
    // Handling subsequent product additions to the cart
    $found = false;
    $cart = $_SESSION["cart"];
    $index = 0;
    $q = OperationData::getQYesF($_POST["product_id"]);
    $newprice = $_POST["newprice"]; 
    $can = $_POST["q"] <= $q;

    if (!$can) {
        $error = array("product_id" => $_POST["product_id"], "message" => "No hay suficiente cantidad de producto en inventario.");
        $errors[] = $error;
        $_SESSION["errors"] = $errors;
        echo "<script>window.location='index.php?view=sell';</script>";
        exit();
    }

    foreach ($cart as $c) {
        if ($c["product_id"] == $_POST["product_id"]) {
            $found = true;
            break;
        }
        $index++;
    }

    if ($found) {
        $cart[$index]["q"] += $_POST["q"];
        $cart[$index]["newprice"] = $newprice;
    } else {
        $cart[] = array("product_id" => $_POST["product_id"], "q" => $_POST["q"], "newprice" => $newprice);
    }

    $_SESSION["cart"] = $cart;
    echo "<script>window.location='index.php?view=sell';</script>";
    exit();
}
?>
