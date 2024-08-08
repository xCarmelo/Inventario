<?php
// autoload.php

spl_autoload_register(function ($modelname) {
    if (Model::exists($modelname)) {
        include Model::getFullPath($modelname);
    }
});
?>
