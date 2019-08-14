<?php


namespace qk1e\mysite\model;

use PDOException;
use PDO;
use qk1e\mysite\model\entities\Developer;
use qk1e\mysite\model\entities\Profile;
use qk1e\mysite\model\entities\User;

class MysqlUsersDatabase
{
    private static $url = "mysql:host=localhost;dbname=mysite";
    private static $user = "root";
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

    //returns type User with all field like in DB
    public function getUserByLogin($user)
    {
        try
        {
            $response = $this->DB->query("
                SELECT *
                FROM users
                WHERE `login`=".$this->DB->quote($user)
            );

            $result_set = $response->fetchAll();

            $user = $result_set[0];

            $return_user = new User();
            $return_user->setId($user["id"]);
            $return_user->setLogin($user["login"]);
            $return_user->setPassword($user["password"]);
            $return_user->setRole($user["role"]);

            return $return_user;
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
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
                role VARCHAR(15) DEFAULT 'reader'
            )
            ");

        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getDeveloperByUserId($id)
    {
        try
        {
            $response = $this->DB->query("
                SELECT * FROM developers
                WHERE `user_id`=".$id
            );

            $result_set = $response->fetchAll();
            $result = $result_set[0];

            //there is an exact duplicate in MySqlDevelopersDatabase
            $developer = new Developer();
            $developer->setId($result["id"]);
            $developer->setUserId($result["user_id"]);
            $developer->setFirstName($result["first_name"]);
            $developer->setSecondName($result["second_name"]);
            $developer->setProfileId($result["profile_id"]);

            return $developer;
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
            return null;
        }
    }

    public function registerUser($login, $password, $role, $first_name=null, $second_name=null)
    {
        try
        {
            $response = $this->DB->query("
                INSERT INTO users(`login`, `password`, `role`)
                VALUES ('".$login."', '".$password."','".$role."')
                ");

            //ebatt govnocode
            if($role === ROLE_DEVELOPER || $role === ROLE_ADMIN)
            {

                $user_id = $this->DB->query("
                SELECT id FROM users
                WHERE `login`=".$this->DB->quote($login)
                )->fetchAll()[0]["id"];

                $this->DB->query("
                INSERT INTO developers(`user_id`, `first_name`, `second_name`)
                VALUES (
                        ".$this->DB->quote($user_id).",
                        ".$this->DB->quote($first_name).",
                        ".$this->DB->quote($second_name)."
                )
                ");
                $dev_id = $this->getDeveloperByUserId($user_id)->getId();

                $this->DB->query("
                    INSERT INTO profiles(`about`, `dev_id`)
                    VALUES ('I have nothing to tell. Just love my job!',
                            ".$dev_id.")
                ");

                $profile_id = null;
                $response = $this->DB->query("
                    SELECT id
                    FROM profiles
                    WHERE `dev_id`=".$dev_id."
                ");
                $result_set = $response->fetchAll();
                $profile_id = $result_set[0]["id"];

                $this->DB->query("
                    UPDATE developers
                    SET `profile_id`=".$profile_id."
                    WHERE `user_id`=".$user_id."
                ");
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
        //LOOOK HERE! PASSWORD VERIFY SHOULDN'T BE HERE
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

    public function getProfileByProfileId($profile_id)
    {
        $response = $this->DB->query("
            SELECT *
            FROM profiles
            WHERE `id`=".$profile_id."
        ");

        $result_set = $response->fetchAll();

        $result = $result_set[0];

        $id = $result["id"];
        $about = $result["about"];
        $dev_id = $result["dev_id"];
        $photo = $result["photo"];
        $profile = new Profile($id, $about, $dev_id, $photo);

        return $profile;
    }

    public function updateProfile($id, $about)
    {
        $this->DB->query("
            UPDATE profiles
            SET `about`=".$this->DB->quote($about)."
            WHERE `id`=".$id."
        ");
    }

    //SHOULD BE IN DEVELOPERS DATABASE
    public function updateDeveloperFullName($first_name, $second_name, $developer_id)
    {
        $this->DB->query("
            UPDATE developers
            SET `first_name`=".$this->DB->quote($first_name).",
                `second_name`=".$this->DB->quote($second_name)."
            WHERE `id`=".$developer_id."
        ");
    }

    public function updatePhoto($profile_id, $photo)
    {
        $this->DB->query("
            UPDATE profiles
            SET `photo`='".$photo."'
            WHERE `id`=".$profile_id."
        ");
    }

    private function getPhotoByDeveloperId($developer_id)
    {
        try
        {
            $response = $this->DB->query("
                SELECT photo
                FROM profiles
                WHERE `dev_id`=".$developer_id."
            ");

            $result_set = $response->fetchAll();
            $result = $result_set[0]["photo"];

            return $result;
        }
        catch (PDOException $e)
        {

        }
    }

}