<?php

use qk1e\mysite\Router;

spl_autoload_register(function (String $class){
    $sourcePath = __DIR__ . DIRECTORY_SEPARATOR . 'src';
    $replaceRootPath = str_replace('qk1e\\mysite', $sourcePath, $class);
    $replaceDirectorySeparator = str_replace('\\', DIRECTORY_SEPARATOR, $replaceRootPath);
    $filePath = $replaceDirectorySeparator . '.php';
    if (file_exists($filePath)) {
        require($filePath);
    }
});

session_start();



Router::route($_GET["path"]);
