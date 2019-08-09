<?php


namespace qk1e\mysite\model;


use PDO;

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
        $from = ($page=1)*$page_size;

        $this->DB->query("
            
        ");
    }


}