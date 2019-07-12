<?php


namespace qk1e\mysite;

require_once $_SERVER["DOCUMENT_ROOT"]."/src/controllers/BlogPageController.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/src/controllers/DevsPageController.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/src/controllers/ProfilePageController.php";

use qk1e\mysite\controllers\BlogPageController as BlogPageController;
use qk1e\mysite\controllers\DevsPageController;
use qk1e\mysite\controllers\ProfilePageController;

class Router
{
    public static function route($url)
    {

            switch ($url)
            {
                case "blog":
                    $bpcontroller = new BlogPageController();
                    $bpcontroller->getPage();
                    break;

                case "profile":
                    $controller = new ProfilePageController();
                    $controller->getPage();
                    break;

                case "admin":
                    echo "No admin page!";
                    break;
                case "devs":
                    $controller = new DevsPageController();
                    $controller->getPage();
                    break;
                case "":
                    $bpcontroller = new BlogPageController();
                    $bpcontroller->getPage();
                    break;
                case "adminer":
                    include $_SERVER["DOCUMENT_ROOT"]."/adminer.php";
                    break;
                case "info":
                    phpinfo();
                    break;
                default:header("HTTP/1.0 404 Not Found");

            }
    }
}