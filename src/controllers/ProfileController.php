<?php

namespace qk1e\mysite\controllers;

use qk1e\mysite\controllers\Controller;
use qk1e\mysite\Request;
use qk1e\mysite\security\SecuritySystem;
use qk1e\mysite\view\View;


class ProfileController
{
    public function getProfilePage(Request $request)
    {
        $ss = new SecuritySystem();

        $user_role = $ss->currentUserRole();
        if($user_role == ROLE_UNAUTHORIZED)
        {
            header("/login");
        }
        if($user_role == ROLE_READER)
        {
            echo header("HTTP/1.0 404 Not Found");;
        }

        $view = new View();
        $view->getPage("profile", null);
    }
}