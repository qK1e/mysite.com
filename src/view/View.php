<?php


namespace qk1e\mysite\view;


use qk1e\mysite\security\SecuritySystem;

class View
{
    public function getPage($page, $args)
    {

        $nav_block = $this->prepareNavigationBlock();
        $login_block = $this->prepareLoginBlock();

        //этого здесь не должно быть -> роль должен передавать Controller
        $ss = new SecuritySystem();
        $user_role = $ss->currentUserRole();

        extract($args);

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
    private function prepareNavigationBlock()
    {
        return ROOTDIR."/views/assets/navigation-menu.php";
    }
}