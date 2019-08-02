<?php
namespace qk1e\mysite\security;

use qk1e\mysite\model\MysqlUsersDatabase as MysqlUsersDatabase;

class SecuritySystem
{

    public function __construct()
    {
    }

    public function authenticate($login, $password)
    {
        $DB = new MysqlUsersDatabase();

        if ($DB->verifyUser($login, $password)) {
            $_SESSION["user"] = $login;
            $_SESSION["authenticated"] = true;
            return true;
        }
    }

    public function logout()
    {
        $_SESSION["authenticated"] = false;
        unset($_SESSION["user"]);
    }

    public function register($login, $password, $role=ROLE_READER)
    {
        $DB = new MysqlUsersDatabase();

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $DB->registerUser($login, $hashed_password, $role);
        $this->authenticate($login, $password);
    }

    public function isAuthenticated()
    {
        if(isset($_SESSION["authenticated"]))
        {
            return $_SESSION["authenticated"];
        }
        else{
            return false;
        }
    }

    public function currentUserRole()
    {
        $DB = new MysqlUsersDatabase();
        if(isset($_SESSION["user"]))
        {
            return $DB->getRole($_SESSION["user"]);
        }
        else{
            return ROLE_UNAUTHORIZED;
        }

    }

    public function currentUser()
    {
        if(isset($_SESSION["user"]))
        {
            return $_SESSION["user"];
        }
        else
        {
            return null;
        }
    }

}