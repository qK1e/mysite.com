<?php

namespace qk1e\mysite\controllers;

use qk1e\mysite\controllers\Controller;
use qk1e\mysite\view\View;


class ProfilePageController implements Controller
{

    public function handleRequest($url)
    {
        $view = new View();
        $view->getPage("profile", []);
    }
}