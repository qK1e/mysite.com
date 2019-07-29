<?php


namespace qk1e\mysite\model;

use PDOException;
use PDO;

class MysqlUsersDatabase
{
    private static $url = "mysql:host=localhost;dbname=mysite";
    private static $user = "admin";
    private static $password = "root";

    private $DB;

    /**
     * MysqlUsersDatabase constructor.
     */
    public function __construct()
    {

        $this->DB = new PDO(MysqlUsersDatabase::$url, MysqlUsersDatabase::$user, MysqlUsersDatabase::$password);
        $this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function idByLogin($login)
    {
        $response = $this->DB->query("
        SELECT id
        FROM users
        WHERE login = '".$login."'
        ");

        $result_set = $response->fetchAll()[0];
        if(isset($result_set))
        {
            return $result_set["id"];
        }
        else
        {
            return null;
        }
    }

    public function loginById($id)
    {
        $response = $this->DB->query("
        SELECT login
        FROM users
        WHERE id = '".$id."'
        ");

        $result_set = $response->fetchAll()[0];
        if(isset($result_set))
        {
            return $result_set["login"];
        }
        else
        {
            return null;
        }
    }

    private function configure()
    {

    }

    //creates model structure
    public function initialize_users()
    {
        try
        {
            $this->DB->query("
            CREATE TABLE IF NOT EXISTS users(
                id INT PRIMARY KEY AUTO_INCREMENT,
                login VARCHAR(30) NOT NULL,
                password VARCHAR(255) NOT NULL,
                first_name VARCHAR(20),
                second_name VARCHAR(20),
                role VARCHAR(15) DEFAULT 'reader'
            )
            ");

        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    private function destroy()
    {

    }

    public function registerUser($login, $password)
    {
        try
        {
            $this->DB->query("INSERT INTO users(`login`, `password`, `hash`) VALUES ("."'"."$login"."'".", "."'"."$password"."'".", '0')"); //нах я так сделал?
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function userExist($login)
    {
        try
        {
            $pdostatement = $this->DB->query("SELECT * FROM users WHERE login = '".$login."' LIMIT 1");
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

    /**
     * @param $login
     * @param $password
     *
     * @return bool
     */
    public function verifyUser($login, $password)
    {
        try{
            $response = $this->DB->query("
            SELECT password
            FROM users
            WHERE login= '".$login."'"
            );

            $result_set = $response->fetchAll();
            if(!empty($result_set))
            {
                $hash = $result_set[0]["password"];
                return password_verify($password, $hash);
            }
            else{
                return false;
            }

        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getRole($login)
    {
        try
        {
            $response = $this->DB->query("
            SELECT role
            FROM users
            WHERE login= '".$login."'
            ");

            $result = $response->fetchAll()[0];

            if(!empty($result))
            {
               return $result["role"];
            }
            else return "unauthorized";
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }


}