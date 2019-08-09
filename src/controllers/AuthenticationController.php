<?php


namespace qk1e\mysite\controllers;

use qk1e\mysite\model\MysqlUsersDatabase;
use qk1e\mysite\Request;
use qk1e\mysite\security\SecuritySystem;
use qk1e\mysite\view\View;

class AuthenticationController
{
    public function signIn(Request $request)
    {
        $ss = new SecuritySystem();

        $username = $request->getArgument("username");
        $password = $request->getArgument("password");

        if($ss->authenticate($username, $password))
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

    public function register(Request $request)
    {
        $ss = new SecuritySystem();
        $role = strtolower($request->getArgument("role"));

        if(isset($role))
        {
            $ss->register($request->getArgument("username"), $request->getArgument("password"), $role);
        }

        $ss->register($request->getArgument("username"), $request->getArgument("password"));
        header("Location: /");
    }

    public function newUser(Request $request)
    {
        $role = strtolower($request->getArgument("role"));
        $username = $request->getArgument("username");
        $password = $request->getArgument("password");
        if($role == ROLE_ADMIN || $role == ROLE_DEVELOPER)
        {
            $first_name = $request->getArgument("first-name");
            $second_name = $request->getArgument("second-name");

            $ss = new SecuritySystem();
            $ss->register($username, $password, $role, $first_name, $second_name);
        }
        else
        {
            $ss = new SecuritySystem();
            $ss->register($username, $password, $role);
        }

        header("Location: /admin");
    }

    public function getLoginPage(Request $request)
    {
        $view = new View();
        $view->getPage("login", null);
    }

    public function getRegisterPage(Request $request)
    {
        $view = new View();
        $view->getPage("register", null);
    }

    public function logout(Request $request)
    {
        $ss = new SecuritySystem();
        $ss->logout();
        header("Location: /");
    }
}