<?php


namespace qk1e\mysite\view;


use qk1e\mysite\security\SecuritySystem;

class View
{
    public function getPage($page, $args)
    {
        extract($args);

        $nav_args = $this->prepareNavigationBlockArguments($user_role);
        $nav_block = ROOTDIR."/views/assets/navigation-menu.php";
        extract($nav_args);

        $login_block = $this->prepareLoginBlock();

        $page_file = ROOTDIR."/views/".$page.".php";

        if(file_exists($page_file))
        {
            include($page_file);
        }
        else
        {
            header("HTTP/1.0 404 Not Found");
        }
    }

    private function prepareLoginBlock()
    {
        $ss = new SecuritySystem();

        if($ss->isAuthenticated())
        {
            return ROOTDIR."/views/assets/login-block-authorized.php";
        }
        else{
            return ROOTDIR."/views/assets/login-block.php";
        }
    }

    //should prepare navigation block according to current user role
    private function prepareNavigationBlockArguments($user_role)
    {
        $nav_blog = true;
        $nav_devs = true;
        $nav_profile = false;
        $nav_admin = false;

        switch ($user_role)
        {
            case ROLE_DEVELOPER:
            {
                $nav_profile = true;
                break;
            }
            case ROLE_ADMIN:
            {
                $nav_profile = true;
                $nav_admin = true;
                break;
            }
        }

        $args = array();

        $args["nav_blog"] = $nav_blog;
        $args["nav_devs"] = $nav_devs;
        $args["nav_profile"] = $nav_profile;
        $args["nav_admin"] = $nav_admin;

        return $args;
    }
}