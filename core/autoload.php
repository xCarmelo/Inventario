<?php

// Activar el reporte de errores
error_reporting(E_ALL);

// Configurar la salida de errores para que se muestren en la consola del navegador
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'php://stderr');

include "controller/Core.php";
include "controller/View.php";
include "controller/Module.php";
include "controller/Database.php"; 
include "controller/Executor.php";

include "controller/forms/lbForm.php";
include "controller/forms/lbInputText.php";
include "controller/forms/lbInputPassword.php";
include "controller/forms/lbValidator.php";

include "controller/Model.php";
include "controller/Bootload.php";
include "controller/Action.php";

include "controller/Request.php";



include "controller/Get.php";
include "controller/Post.php";
include "controller/Cookie.php";
include "controller/Session.php";
include "controller/Lb.php";


include "controller/class.upload.php";


?>