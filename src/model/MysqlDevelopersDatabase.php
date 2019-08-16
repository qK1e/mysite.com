<?php


namespace qk1e\mysite\model;


use PDO;
use PDOException;
use qk1e\mysite\model\entities\Developer;
use qk1e\mysite\model\entities\DeveloperFilter;

class MysqlDevelopersDatabase
{
    private static $url = "mysql:host=localhost;dbname=mysite";
    private static $user = "root";
    private static $password = "root";

    private $DB;


    /**
     * MysqlBlogDatabase constructor.
     */
    public function __construct()
    {
        $this->DB = new PDO(MysqlDevelopersDatabase::$url, MysqlDevelopersDatabase::$user, MysqlDevelopersDatabase::$password);
        $this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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


        $developers = array();
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
        $result_set = $statement->fetchAll();

        foreach ($result_set as $dev)
        {
            //should be as a function? duplicate in MySqlUsersDatabase
            $developer = new Developer();
            $developer->setId($dev["id"]);
            $developer->setUserId($dev["user_id"]);
            $developer->setFirstName($dev["first_name"]);
            $developer->setSecondName($dev["second_name"]);
            $developer->setProfileId($dev["profile_id"]);

            array_push($developers, $developer);
        }

        return $developers;


    }

    public function updateProfilePhoto($profile_id, $file_id)
    {
        try
        {
            $this->DB->query("
                UPDATE profiles
                SET `photo`=".$this->DB->quote($file_id)."
                WHERE `id`=$profile_id
                "
            );
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
            $response = $this->DB->query("
                SELECT photo
                FROM profiles
                WHERE `id`=$profile_id
            ");

            $result_set = $response->fetchAll();
            return $result_set[0]["photo"];
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }
}