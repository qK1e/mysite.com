<?php


namespace qk1e\mysite\model;


use PDO;

 class MysqlDatabase
{
    private static $url = "mysql:host=localhost;dbname=mysite";
    private static $user = "root";
    private static $password = "root";

    use MysqlBlogDatabase, MysqlDevelopersDatabase, MysqlUsersDatabase;

    private $DB;
    private static $instance;

    protected function __construct()
    {
        $this->DB = new PDO(MysqlDatabase::$url, MysqlDatabase::$user, MysqlDatabase::$password);
        $this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

     public static function getInstance(): MysqlDatabase
     {
         if(MysqlDatabase::$instance)
         {
             return MysqlDatabase::$instance;
         }
         else
         {
             MysqlDatabase::$instance = new MysqlDatabase();
             return MysqlDatabase::$instance;
         }
     }
}