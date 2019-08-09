<?php


namespace qk1e\mysite\controllers;


use qk1e\mysite\Request;
use qk1e\mysite\security\SecuritySystem;
use qk1e\mysite\view\View;

class AdminController
{

    public function getAdminPage(Request $request)
    {
        $args = array();

        $ss = new SecuritySystem();
        $role = $ss->currentUserRole();
        $args["user_role"] = $role;

        $view = new View();

        $view->getPage("admin", $args);
    }

    public function newUser(Request $request)
    {
        $args = array();
        $ss = new SecuritySystem();
        $role = $ss->currentUserRole();
        $args["user_role"] = $role;

        $view = new View();

        $view->getPage("new_user",  $args);
    }
}