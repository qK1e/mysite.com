<?php


namespace qk1e\mysite\model;

use PDOException;
use PDO;

class MysqlUsersDatabase implements UsersDatabase
{
    private static $url = "mysql:host=localhost;dbname=mysite";
    private static $user = "admin";
    private static $password = "root";

    public function registerUser($login, $password)
    {
        try
        {
            $DB = new PDO(MysqlUsersDatabase::$url, MysqlUsersDatabase::$user, MysqlUsersDatabase::$password);
            $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $DB->query("INSERT INTO users(`login`, `password`, `hash`) VALUES ("."'"."$login"."'".", "."'"."$password"."'".", '0')");

        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function userExist($login, $password)
    {
        $DB = new PDO(MysqlUsersDatabase::$url, MysqlUsersDatabase::$user, MysqlUsersDatabase::$password);
        $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try
        {
            $pdostatement = $DB->query("SELECT * FROM users WHERE login = '".$login."' AND password = '".$password."' LIMIT 1");
            $response = $pdostatement->fetchAll();

            if($response[0])
            {
                return true;
            }
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }

    }
}