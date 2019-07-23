<?php


namespace qk1e\mysite\controllers;

use qk1e\mysite\model\MysqlUsersDatabase;
use qk1e\mysite\security\SecuritySystem;
use qk1e\mysite\view\View;

class AuthenticationPageController
{
    public function signIn($request)
    {
        $ss = SecuritySystem::getInstance();

        if($ss->authenticate($request["username"], $request["password"]))
        {
            header("Location: /");
        }
        else
        {
            echo "NOPE";
        }
    }

    public function register($request)
    {
        $ss = SecuritySystem::getInstance();
        $ss->register($request["username"], $request["password"]);
        header("Location: /");
    }

    public function getLoginPage($request)
    {
        $view = new View();
        $view->getPage("login", null);
    }

    public function getRegisterPage($request)
    {
        $view = new View();
        $view->getPage("register", null);
    }
}