<?php
if(isset($_GET["product_id"])){
    $cartdiscard = $_SESSION["cartdiscard"];
    if(count($cartdiscard) == 1){
        unset($_SESSION["cartdiscard"]);
    }else{
        $ncartdiscard = null;
        $nx = 0;
        foreach($cartdiscard as $c){
            if($c["product_id"] != $_GET["product_id"]){
                $ncartdiscard[$nx] = $c;
            }
            $nx++;
        }
        $_SESSION["cartdiscard"] = $ncartdiscard;
    }

}else{
    unset($_SESSION["cartdiscard"]);
}

print "<script>window.location='index.php?view=discard';</script>";
?>
