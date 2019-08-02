<?php


namespace qk1e\mysite\controllers;


use qk1e\mysite\Request;
use qk1e\mysite\view\View;

class AdminController
{

    public function getAdminPage(Request $request)
    {
        $view = new View();
        $args = array();
        $view->getPage("admin", $args);
    }

    public function newUser(Request $request)
    {
        $view = new View();
        $args = array();
        $view->getPage("new_user",  $args);
    }
}