<?php


namespace qk1e\mysite\model;


use PDO;
use PDOException;
use qk1e\mysite\model\entities\Developer;
use qk1e\mysite\model\entities\DeveloperFilter;
use qk1e\mysite\storage\LocalStorage;

class MysqlDevelopersDatabase extends MysqlDatabase
{
    private static $instance;


    private function __construct()
    {
        parent::__construct();
    }

    public static function getInstance(): MysqlDevelopersDatabase
    {
        if(MysqlDevelopersDatabase::$instance)
        {
            return MysqlDevelopersDatabase::$instance;
        }
        else
        {
            MysqlDevelopersDatabase::$instance = new MysqlDevelopersDatabase();
            return MysqlDevelopersDatabase::$instance;
        }
    }


    private function filterToWhereQueryPartDevsOnly(DeveloperFilter $filter)
    {
        $where = "";

        if($filter)
        {
            $parts = array();

            $first_name = $filter->getFirstName();
            if($first_name)
            {
                if($first_name != "")
                {
                    $part = "`first_name` LIKE ".$this->DB->quote($first_name);
                }
                else
                {
                    $part = "`first_name` LIKE '%'";
                }
                array_push($parts, $part);
            }

            $second_name = $filter->getSecondName();
            if($second_name)
            {
                if($second_name != "")
                {
                    $part = "`second_name` LIKE ".$this->DB->quote($second_name);
                }
                else
                {
                    $part = "`second_name` LIKE '%'";
                }
                array_push($parts, $part);
            }

            $visibility = $filter->getVisibility();
            if($visibility)
            {
                $part = "`visibility` = ".$visibility;
                array_push($parts, $part);
            }


        }

        if(!empty($parts))
        {
            $where = "WHERE ";
            foreach ($parts as $part)
            {
                $where = $where.$part." AND ";
            }
            $last_and_pos = strlen($where) - 4;
            $where = substr_replace($where, "", $last_and_pos, 4);
        }

        return $where;
    }

    public function getPageOfDevelopers($page=1, $page_size=5, DeveloperFilter $filter=null)
    {
        $from = ($page-1)*$page_size;
        $where = $this->filterToWhereQueryPartDevsOnly($filter);

        $query = "
            SELECT *
            FROM developers INNER JOIN users
                ON (developers.user_id=users.id 
                    AND (users.role NOT LIKE ".$this->DB->quote(ROLE_READER).") )
            ".$where."
            ORDER BY users.id
            LIMIT ".$from.", ".$page_size."
        ";

        $statement = $this->DB->prepare($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Developer::class);
        $developers = $statement->fetchAll();

        return $developers;


    }

    public function updateProfilePhoto($profile_id, $file_id)
    {
        try
        {
            $query = "
                UPDATE profiles
                SET `photo`=?
                WHERE `id`=?
            ";

            $statement = $this->DB->prepare($query);
            $statement->bindParam(1, $file_id, PDO::PARAM_STR);
            $statement->bindParam(2, $profile_id, PDO::PARAM_INT);
            $statement->execute();
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getProfilePhoto($profile_id)
    {
        try
        {
            $query = "
                SELECT photo
                FROM profiles
                WHERE `id`=?
            ";

            $statement = $this->DB->prepare($query);
            $statement->bindParam(1, $profile_id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC)["photo"];
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getDeveloperById($id)
    {
        try
        {
            $query = "
                SELECT *
                FROM developers
                WHERE `id`=?
            ";

            $statement = $this->DB->prepare($query);
            $statement->bindParam(1, $id, PDO::PARAM_INT);
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_CLASS, Developer::class);
            $developer = $statement->fetch();

            return $developer;
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function updateDeveloperFullName($first_name, $second_name, $developer_id)
    {
        $query = "
            UPDATE developers
            SET `first_name` = ?,
                `second_name` = ?
            WHERE `id` = ?
        ";

        $statement = $this->DB->prepare($query);
        $statement->bindParam(1, $first_name, PDO::PARAM_STR);
        $statement->bindParam(2, $second_name, PDO::PARAM_STR);
        $statement->bindParam(3, $developer_id, PDO::PARAM_INT);
        $statement->execute();
    }

    public function updateProfile($id, $about)
    {
        $query = "
            UPDATE profiles
            SET `about` = ?
            WHERE `id` = ?
        ";

        $statement = $this->DB->prepare($query);
        $statement->bindParam(1, $about, PDO::PARAM_STR);
        $statement->bindParam(2, $id, PDO::PARAM_INT);
        $statement->execute();
    }

    //not transaction safe
    public function createDeveloperFromUserId($id): bool
    {
        try
        {
            $query = "
                INSERT INTO developers(`user_id`, `first_name`, `second_name`)
                VALUES (?,?,?)
            ";

            $default_name = "Name";
            $default_surname = "Surname";

            $statement = $this->DB->prepare($query);
            $statement->bindParam(1, $id, PDO::PARAM_INT);
            $statement->bindParam(2, $default_name, PDO::PARAM_STR);
            $statement->bindParam(1, $default_surname, PDO::PARAM_STR);
            $statement->execute();

            $query = "
                        SELECT SCOPE_IDENTITY() as `id`
                    ";
            $statement = $this->DB->prepare($query);
            $statement->execute();
            $dev_id = $statement->fetchColumn(0);

            $this->createProfileFromDevId($dev_id);

            $statement->execute();
            $profile_id = $statement->fetchColumn(0);

            if($profile_id)
            {
                $query = "
                UPDATE developers
                SET `profile_id` = ?
                WHERE `user_id` = ?
            ";

                $statement = $this->DB->prepare($query);
                $statement->bindParam(1, $profile_id, PDO::PARAM_INT);
                $statement->bindParam(2, $id, PDO::PARAM_INT);
                $statement->execute();
            }
            else
            {
                throw new PDOException();
            }
        }
        catch (PDOException $e)
        {
            return false;
        }
    }

    private function createProfileFromDevId($dev_id): bool
    {
        try
        {
            $query = "
            INSERT INTO profiles(`dev_id`, `about`, `photo`)
            VALUES (?,?,?)
            ";

            $default_about = "I have nothing to tell. Just love my job!";

            $statement  = $this->DB->prepare($query);
            $statement->bindParam(1, $dev_id, PDO::PARAM_INT);
            $statement->bindParam(2, $default_about, PDO::PARAM_STR);
            $statement->bindParam(3, LocalStorage::getDefaultPhoto(), PDO::PARAM_STR);
            $statement->execute();
        }
        catch (PDOException $e)
        {
            return false;
        }

    }

    public function changeVisibility($user_id): bool
    {
        try
        {
            $query = "
            UPDATE developers 
            SET `visibility` = NOT `visibility`
            WHERE `user_id` = ?
        ";

            $statement = $this->DB->prepare($query);
            $statement->bindParam(1, $user_id, PDO::PARAM_INT);
            $statement->execute();

            return true;
        }
        catch (PDOException $e)
        {
            return false;
        }
    }

}