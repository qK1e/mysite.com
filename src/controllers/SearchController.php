<?php


namespace qk1e\mysite\controllers;


use qk1e\mysite\Request;
use qk1e\mysite\security\SecuritySystem;
use qk1e\mysite\view\View;

class SearchController
{
    public function search(Request $request)
    {
        $args = array();
        $role = SecuritySystem::currentUserRole();
        $args["user_role"] = $role;

        //create a SearchQuery

        //search for elements, get SearchItem's collection

        //show page
        $view = new View();
        $view->getPage("search", $args);
    }
}