<?php
spl_autoload(function ($classes){
    $file = dirname(__DIR__) . "" . $classes . ".php";
    echo "Registered $file";

});