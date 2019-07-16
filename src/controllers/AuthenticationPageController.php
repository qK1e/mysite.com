<?php


namespace qk1e\mysite\controllers;

require_once $_SERVER["DOCUMENT_ROOT"]."/src/controllers/Controller.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/src/model/MysqlUsersDatabase.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/src/security/SecuritySystem.php";

use qk1e\mysite\model\MysqlUsersDatabase;
use qk1e\mysite\security\SecuritySystem;

class AuthenticationPageController implements Controller
{
    /**
     * @param $url
     */

    public function handleRequest($url)
    {
        if($url == "register")
        {
            include $_SERVER["DOCUMENT_ROOT"]."/views/register.php";
        }
        else if ($url == "login")
        {
            include $_SERVER["DOCUMENT_ROOT"]."/views/login.php";

        }
        else if($url == "auth-register")
        {
            $ss = SecuritySystem::getInstance();
            $ss->register($_REQUEST["username"], $_REQUEST["password"]);
            header("Location: /");

        }
        else if($url == "auth-signin")
        {
            $ss = SecuritySystem::getInstance();

            if($ss->authenticate($_POST["username"], $_POST["password"]))
            {
                header("Location: /");
            }
        }
        else if($url == "logout")
        {
            $ss = SecuritySystem::getInstance();
            $ss->logout();
            header("Location: /");
        }
    }
}