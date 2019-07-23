<?php

namespace qk1e\mysite\controllers;

use qk1e\mysite\controllers\Controller;
use qk1e\mysite\view\View;


class ProfilePageController
{
    public function getProfilePage()
    {
        $view = new View();
        $view->getPage("profile", null);
    }
}