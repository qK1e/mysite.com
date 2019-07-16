<?php


namespace qk1e\mysite;

require_once $_SERVER["DOCUMENT_ROOT"]."/src/controllers/BlogPageController.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/src/controllers/DevsPageController.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/src/controllers/ProfilePageController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/controllers/AuthenticationPageController.php";

use qk1e\mysite\controllers\BlogPageController as BlogPageController;
use qk1e\mysite\controllers\DevsPageController;
use qk1e\mysite\controllers\ProfilePageController;
use qk1e\mysite\controllers\AuthenticationPageController;


class Router
{
    public static function route($url)
    {

            switch ($url)
            {
                case "blog":
                    $controller = new BlogPageController();
                    $controller->handleRequest("blog");
                    break;

                case "profile":
                    $controller = new ProfilePageController();
                    $controller->handleRequest("profile");
                    break;

                case "admin":
                    echo "No admin page!";
                    break;

                case "devs":
                    $controller = new DevsPageController();
                    $controller->handleRequest("devs");
                    break;

                case "":
                    $controller = new BlogPageController();
                    $controller->handleRequest("blog");
                    break;

                case "adminer":
                    include $_SERVER["DOCUMENT_ROOT"]."/adminer.php";
                    break;

                case "info":
                    phpinfo();
                    break;

                case "register":
                    //передать всё в контроллер - пусть сам разбирается, страницу показать или аутентифицировать
                    $controller = new AuthenticationPageController();
                    //везде должно быть через этот метод
                    $controller->handleRequest("register");
                    break;

                case "login":
                    //передать всё в контроллер - пусть сам разбирается, страницу показать или аутентифицировать
                    $controller = new AuthenticationPageController();
                    //везде должно быть через этот метод
                    $controller->handleRequest("login");
                    break;

                case "logout":
                    $controller = new AuthenticationPageController();
                    $controller->handleRequest("logout");

                    break;

                case "auth":
                    $controller = new AuthenticationPageController();
                    if(array_key_exists("register", $_REQUEST))
                    {
                        $controller->handleRequest("auth-register");
                    }
                    elseif (array_key_exists("signin", $_REQUEST))
                    {
                        $controller->handleRequest("auth-signin");
                    }


                    break;

                default:header("HTTP/1.0 404 Not Found");

            }
    }
}