<?php
namespace qk1e\mysite\security;

require_once $_SERVER["DOCUMENT_ROOT"]."/src/model/MysqlUsersDatabase.php";


use qk1e\mysite\model\MysqlUsersDatabase as MysqlUsersDatabase;

class SecuritySystem
{

    private static $instance;
    private static $authenticated = false;

    public static function getInstance(): SecuritySystem
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }


    public function authenticate($login, $password)
    {
        $DB = new MysqlUsersDatabase();

        if ($DB->userExist($login, $password)) {
            //SecuritySystem::$authenticated = true;
            setcookie("authenticated", true);
            setcookie("user", $login);
            return true;
        }
    }

    public function logout()
    {
        SecuritySystem::$authenticated = false;
        setcookie("authenticated", false);
    }

    public function register($login, $password)
    {
        $DB = new MysqlUsersDatabase();
        $DB->registerUser($login, $password);
        $this->authenticate($login, $password);
    }

    public static function isAuthenticated()
    {
        return $_COOKIE["authenticated"];
    }

}