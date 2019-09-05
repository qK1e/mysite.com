<?php
namespace qk1e\mysite\security;

use qk1e\mysite\model\entities\User;
use qk1e\mysite\model\MysqlUsersDatabase as MysqlUsersDatabase;

class SecuritySystem
{
    public static function authenticate($login, $password)
    {
        if (SecuritySystem::verifyUser($login, $password)) {
            $_SESSION["user"] = $login;
            $_SESSION["authenticated"] = true;
            return true;
        }
        else
        {
            return false;
        }
    }

    private static function verifyUser($login, $password)
    {
        $DB = MysqlUsersDatabase::getInstance();
        $hash = $DB->getPasswordByLogin($login);
        return password_verify($password, $hash);

    }

    public static function logout()
    {
        $_SESSION["authenticated"] = false;
        unset($_SESSION["user"]);
    }

    public static function register($login, $password, $role=ROLE_READER, $first_name=null, $second_name=null)
    {
        $DB = MysqlUsersDatabase::getInstance();

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $DB->registerUser($login, $hashed_password, $role, $first_name, $second_name);
        if(!SecuritySystem::isAuthenticated())
        {
            SecuritySystem::authenticate($login, $password);
        }
    }

    public static function isAuthenticated()
    {
        if(isset($_SESSION["authenticated"]))
        {
            return $_SESSION["authenticated"];
        }
        else{
            return false;
        }
    }

    public static function currentUserRole()
    {
        $DB = MysqlUsersDatabase::getInstance();
        if(isset($_SESSION["user"]))
        {
            return $DB->getRole($_SESSION["user"]);
        }
        else{
            return ROLE_UNAUTHORIZED;
        }

    }

    public static function currentUserLogin()
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

    public static function currentUser(): ?User
    {
        $login = SecuritySystem::currentUserLogin();
        if($login)
        {
            $DB = MysqlUsersDatabase::getInstance();

            $user = $DB->getUserByLogin($login);

            return $user;
        }
        else
        {
            return null;
        }
    }

}