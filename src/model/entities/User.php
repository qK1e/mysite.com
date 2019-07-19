<?php


namespace qk1e\mysite\model\entities;


class User
{
    private $id;
    private $login;
    private $password;
    private $hash;

    function generateHash($password)
    {
        if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
            $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
            return crypt($password, $salt);
        }
    }

    public static function checkName($name)
    {
        return true;
    }

    public static function checkLogin($login)
    {
        return true;
    }

    public static function checkPassword($pass)
    {
        return true;
    }

    //проверка по базе данных
    public static function checkUserLogin($login)
    {
        return true;
    }

    public static function register($login, $password)
    {
        //to do: реализовать регистрацию
    }
}