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

    public function __construct(User $user=null)
    {
        if($user)
        {
            $this->id = $user->getId();
            $this->login = $user->getLogin();
            $this->password = $user->getPassword();
            $this->role = $user->getRole();
        }
    }

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
                $DB = MysqlUsersDatabase::getInstance();
                $id = $DB->idByLogin($this->login);
            }
            catch (PDOException $e)
            {
                echo $e->getMessage();
            }
        }
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    public function getUserId()
    {
        $this->getId();
    }

    private function getPassword()
    {
        return $this->password;
    }
}