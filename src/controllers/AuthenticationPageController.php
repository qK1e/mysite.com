<?php


namespace qk1e\mysite\controllers;

use qk1e\mysite\model\MysqlUsersDatabase;
use qk1e\mysite\security\SecuritySystem;
use qk1e\mysite\view\View;

class AuthenticationPageController
{
    public function signIn($request)
    {
        $ss = new SecuritySystem();

        if($ss->authenticate($request["username"], $request["password"]))
        {
            header("Location: /");
        }
        else
        {
            echo "Don't try to fool me, pal! -_-
            <br>
            <a href='/'>Main page</a><br>
            <a href='/login'>Try again</a>
            ";
        }
    }

    public function register($request)
    {
        $ss = new SecuritySystem();
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

    public function logout($request)
    {
        $ss = new SecuritySystem();
        $ss->logout();
        header("Location: /");
    }
}