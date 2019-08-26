<?php


namespace qk1e\mysite\model;


use PDO;
use PDOException;
use qk1e\mysite\model\entities\Developer;
use qk1e\mysite\model\entities\DeveloperFilter;

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



    private function filterToWhereQueryPart(DeveloperFilter $filter)
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
        $where = $this->filterToWhereQueryPart($filter);

        $query = "
            SELECT *
            FROM developers 
            ".$where."
            ORDER BY `id`
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
            $statement->execute(array($file_id, $profile_id));
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
            $statement->execute(array($profile_id));
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

            $statement->execute(array($id));
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
        $statement->execute(array($first_name, $second_name, $developer_id));
    }

    public function updateProfile($id, $about)
    {
        $query = "
            UPDATE profiles
            SET `about` = ?
            WHERE `id` = ?
        ";

        $statement = $this->DB->prepare($query);
        $statement->execute(array($id, $about));
    }

}