<?php

namespace qk1e\mysite\controllers;

require_once $_SERVER["DOCUMENT_ROOT"]."/src/controllers/Controller.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/src/view/View.php";

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