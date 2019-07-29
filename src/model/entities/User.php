<?php

namespace qk1e\mysite\model\entities;
use PDO;
use PDOException;
use qk1e\mysite\model\MysqlUsersDatabase;

class User
{
    private $id;
    private $login;
    private $password;
    private $profile_id;
    private $first_name;
    private $second_name;
    private $role;

    public function getId()
    {
        if(isset($this->id))
        {
            return $this->id;
        }
        else
        {
            try
            {
                $DB = new MysqlUsersDatabase();
                $id = $DB->idByLogin($this->login);
            }
            catch (PDOException $e)
            {
                echo $e->getMessage();
            }
        }
    }

    public static function idByLogin($login)
    {
        $DB = new MysqlUsersDatabase();
        return $DB->idByLogin($login);
    }
}