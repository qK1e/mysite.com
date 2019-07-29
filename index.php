<?php
use qk1e\mysite\routing\ConfigurableRouter;

define("ROOTDIR", $_SERVER["DOCUMENT_ROOT"]);

define("ROLE_UNAUTHORIZED", 1);
define("ROLE_READER", "reader");
define("ROLE_DEVELOPER", "developer");
define("ROLE_ADMIN", "admin");
define("ROLE_RICARDO", 2);


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
$path = $_SERVER["REDIRECT_URL"];
$args = $_REQUEST;
$method = $_SERVER["REQUEST_METHOD"];
$router->route($path, $method, $args);

