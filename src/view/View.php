<?php


namespace qk1e\mysite\view;


use qk1e\mysite\security\SecuritySystem;

class View
{
    public function getPage($url, $args)
    {
        switch ($url)
        {
            case "blog":
                extract($args);
                $login_block = $this->prepareLoginBlock();
                include $_SERVER["DOCUMENT_ROOT"]."/views/blog.php";

                break;

            case "profile":
                extract($args);
                $login_block = $this->prepareLoginBlock();
                include $_SERVER["DOCUMENT_ROOT"]."/views/profile.php";

                break;

            case "devs":
                extract($args);
                $login_block = $this->prepareLoginBlock();
                include $_SERVER["DOCUMENT_ROOT"]."/views/devs.php";

                break;

            case "register":
                include $_SERVER["DOCUMENT_ROOT"]."/views/register.php";

                break;

            case "login":
                include $_SERVER["DOCUMENT_ROOT"]."/views/login.php";

                break;

            default:
                header("HTTP/1.0 404 Not Found");
        }
    }

    private function prepareLoginBlock()
    {
        if(SecuritySystem::isAuthenticated())
        {
            return $_SERVER["DOCUMENT_ROOT"]."/views/assets/login-block-authorized.php";
        }
        else{
            return $_SERVER["DOCUMENT_ROOT"]."/views/assets/login-block.php";
        }
    }
}