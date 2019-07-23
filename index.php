<?php
use qk1e\mysite\routing\ConfigurableRouter;

define("ROOTDIR", $_SERVER["DOCUMENT_ROOT"]);


spl_autoload_register(function (String $class){
    $sourcePath = ROOTDIR . DIRECTORY_SEPARATOR . 'src';
    $replaceRootPath = str_replace('qk1e\\mysite', $sourcePath, $class);
    $replaceDirectorySeparator = str_replace('\\', DIRECTORY_SEPARATOR, $replaceRootPath);
    $filepath = $replaceDirectorySeparator . '.php';
    if (file_exists($filepath)) {
        require_once($filepath);
    }
});

session_start();

$router = new ConfigurableRouter("config/router-config");
$router->route();

