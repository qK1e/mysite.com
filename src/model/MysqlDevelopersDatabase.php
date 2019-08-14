<?php


namespace qk1e\mysite\model;


use PDO;
use PDOException;
use qk1e\mysite\model\entities\Developer;

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

    public function getPageOfDevelopers($page=1, $page_size=5)
    {
        $developers = array();
        $from = ($page-1)*$page_size;

        $response = $this->DB->query("
            SELECT *
            FROM developers
            ORDER BY `id`
            LIMIT ".$from.", ".$page_size."
        ");

        $result_set = $response->fetchAll();

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