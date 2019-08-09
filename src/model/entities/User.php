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
    private $role;

    /**
     * @param  mixed  $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param  mixed  $login
     */
    public function setLogin($login): void
    {
        $this->login = $login;
    }

    /**
     * @param  mixed  $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }


    /**
     * @param  mixed  $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

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