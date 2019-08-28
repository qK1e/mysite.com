<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

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



$router = ConfigurableRouter::getInstance();
$uri = $_SERVER["REQUEST_URI"];
$path = explode("?", $uri, 1)[0];
$args = $_REQUEST;
$method = $_SERVER["REQUEST_METHOD"];
$router->route($path, $method, $args);

