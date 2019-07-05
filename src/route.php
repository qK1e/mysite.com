<?php
$uri_parts = explode("/", $_GET["q"]);
$filename = "controllers/". $uri_parts[0]."-controller.php";


//if(file_exists($filename)){
    require $filename;
    $function_name = $uri_parts[1];
    call_user_func($function_name);

//}

