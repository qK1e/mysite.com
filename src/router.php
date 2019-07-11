<?php


namespace qk1e\mysite;

require_once $_SERVER["DOCUMENT_ROOT"]."/src/controllers/BlogPageController.php";
use qk1e\mysite\controllers\BlogPageController as BlogPageController;

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
                    require $_SERVER["DOCUMENT_ROOT"]."/views/profile.php";
                    break;

                case "admin":
                    require $_SERVER["DOCUMENT_ROOT"]."/views/admin.php";
                    break;
                case "devs":
                    require $_SERVER["DOCUMENT_ROOT"]."/views/devs.php";
                    break;
                case "":
                    require $_SERVER["DOCUMENT_ROOT"]."/views/blog.php";
                    break;

                default:header("HTTP/1.0 404 Not Found");

            }
    }
}