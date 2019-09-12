<?php


namespace qk1e\mysite\controllers;

use qk1e\mysite\Request;
use qk1e\mysite\routing\ConfigurableRouter;
use qk1e\mysite\security\SecuritySystem;
use qk1e\mysite\view\View;

class AuthenticationController
{
    public function signIn(Request $request)
    {
        $username = $request->getArgument("username");
        $password = $request->getArgument("password");

        if(SecuritySystem::authenticate($username, $password))
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
        $role = strtolower($request->getArgument("role"));

        if(isset($role) && $role!="")
        {
            SecuritySystem::register($request->getArgument("username"), $request->getArgument("password"), $role);
        }

        SecuritySystem::register($request->getArgument("username"), $request->getArgument("password"));
        $router = ConfigurableRouter::getInstance();
        $router->route("/", "GET", array());
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

            SecuritySystem::register($username, $password, $role, $first_name, $second_name);
        }
        else
        {
            SecuritySystem::register($username, $password, $role);
        }

        $router = ConfigurableRouter::getInstance();
        $router->route("/admin", "GET", array());
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
        SecuritySystem::logout();
        $router = ConfigurableRouter::getInstance();
        $router->route("/", "GET", array());
    }
}