<?php


namespace qk1e\mysite\model;

use PDOException;
use PDO;
use qk1e\mysite\model\entities\Developer;
use qk1e\mysite\model\entities\Profile;
use qk1e\mysite\model\entities\User;

class MysqlUsersDatabase extends MysqlDatabase
{
    private static $instance;


    private function __construct()
    {
        parent::__construct();
    }

    public static function getInstance(): MysqlUsersDatabase
    {
        if(MysqlUsersDatabase::$instance)
        {
            return MysqlUsersDatabase::$instance;
        }
        else
        {
            MysqlUsersDatabase::$instance = new MysqlUsersDatabase();
            return MysqlUsersDatabase::$instance;
        }
    }


    public function idByLogin($login): int
    {
        $query = "
            SELECT id
            FROM users
            WHERE login = ?
        ";

        $statement = $this->DB->prepare($query);
        $statement->execute($login);
        $id = $statement->fetch(PDO::FETCH_ASSOC)["id"];

        return $id;
    }

    public function loginById($id): string
    {
        $query = "
            SELECT login
            FROM users
            WHERE id = ?
        ";

        $statement = $this->DB->prepare($query);
        $statement->execute($id);
        $login = $statement->fetch(PDO::FETCH_ASSOC)["id"];

        return $login;
    }

    public function getUserByLogin(String $login): User
    {
        try
        {
            $query = "
                SELECT *
                FROM users
                WHERE login = ?
            ";

            $statement = $this->DB->prepare($query);
            $statement->execute(array($login));
            $statement->setFetchMode(PDO::FETCH_CLASS, User::class);

            $user = $statement->fetch();

            return $user;
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
            return null;
        }
    }


    //creates model structure
    public function initialize_users(): void
    {
        try
        {
            $query = "
                CREATE TABLE IF NOT EXISTS users(
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    login VARCHAR(30) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    role VARCHAR(15) DEFAULT 'reader'  
                )
            ";

            $this->DB->query($query);
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getDeveloperByUserId($id): Developer
    {
        try
        {
            $query = "
                SELECT *
                FROM developers
                WHERE `user_id` = ?
            ";

            $statement = $this->DB->prepare($query);
            $statement->execute(array($id));
            $statement->setFetchMode(PDO::FETCH_CLASS);
            $developer = $statement->fetch();

            return $developer;
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
            return null;
        }
    }

    private function insertUser($login, $password, $role): void
    {
        $query = "
                INSERT INTO users(`login`, `password`, `role`)
                VALUES (?, ?, ?)
            ";

        $statement = $this->DB->prepare($query);
        $statement->execute(array($login, $password, $role));
    }

    //insert into users table. if user is a developer -> insert into developers table and create profile then set profile id to devepers table
    public function registerUser($login, $password, $role, $first_name=null, $second_name=null): bool
    {
        try
        {
            $this->insertUser($login, $password, $role);

            //If user is a developer or admin -> insert into developers and create profile
            if($role === ROLE_DEVELOPER || $role === ROLE_ADMIN)
            {
                $user_id = $this->idByLogin($login);

                $query = "
                    INSERT INTO developers(`user_id`, `first_name`, `second_name`)
                    VALUES (?,?,?)
                ";
                $statement = $this->DB->prepare($query);
                $statement->execute(array($user_id, $first_name, $second_name));

                $dev_id = $this->getDeveloperByUserId($user_id)->getId(); //probably it's better to make a function that requests a dev_id

                $query = "
                    INSERT INTO profiles(`about`, `dev_id`)
                    VALUES (?,?)
                ";
                $statement = $this->DB->prepare($query);
                $default_about = "I have nothing to tell. Just love my job!";
                $statement->execute(array($default_about, $dev_id));

                $query = "
                    SELECT id
                    FROM profiles
                    WHERE `dev_id` = ?
                ";
                $statement = $this->DB->prepare($query);
                $statement->execute($dev_id);
                $profile_id = $statement->fetch(PDO::FETCH_ASSOC)["id"];

                $query = "
                    UPDATE developers
                    SET `profile_id` = ?
                    WHERE `user_id` = ?
                ";
                $statement = $this->DB->prepare($query);
                $statement->execute(array($profile_id, $user_id));
            }

            return true;
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
            return false;
        }
    }


    public function getPasswordByLogin($login): string
    {
        try
        {
            $query = "
                SELECT password
                FROM users
                WHERE login = ?
            ";

            $statement = $this->DB->prepare($query);
            $statement->execute(array($login));
            return $statement->fetch(PDO::FETCH_ASSOC)["password"];
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
            return null;
        }
    }

    public function getRole($login): string
    {
        try
        {
            $query = "
            SELECT role
            FROM users
            WHERE login = ?
            ";

            $statement = $this->DB->prepare($query);
            $statement->execute(array($login));
            $role = $statement->fetch(PDO::FETCH_ASSOC)["role"];

            if($role)
            {
                return $role;
            }
            else
            {
                return "unauthorized";
            }
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
            return null;
        }
    }

    public function getProfileByProfileId($profile_id): Profile
    {
        $query = "
            SELECT * 
            FROM profiles
            WHERE `id` = ?
        ";

        $statement = $this->DB->prepare($query);
        $statement->execute(array($profile_id));
        $statement->setFetchMode(PDO::FETCH_CLASS, Profile::class);
        $profile = $statement->fetch();

        return $profile;
    }

    public function getUsers(): array
    {
        try
        {
            $query = "
            SELECT * FROM users;
            ";

            $statement = $this->DB->prepare($query);
            $statement->setFetchMode(PDO::FETCH_CLASS, User::class);
            $statement->execute();

            $users = array();
            while($user = $statement->fetch())
            {
                if($user->getRole() == ROLE_DEVELOPER || $user->getRole() == ROLE_ADMIN)
                {
                    $developer = new Developer($user);
                    array_push($users, $developer);
                }
                else
                {
                    array_push($users, $user);
                }
            }

            return $users;

        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
            return null;
        }

    }

    private function getPhotoByDeveloperId($developer_id): string
    {
        try
        {
            $query = "
                SELECT photo
                FROM profiles
                WHERE `dev_id` = ?
            ";

            $statement = $this->DB->prepare($query);
            $statement->execute(array($developer_id));

            $photo = $statement->fetch(PDO::FETCH_ASSOC)["photo"];

            return $photo;
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
            return null;
        }
    }

}