<?php


namespace qk1e\mysite\model;


use PDO;

abstract class MysqlDatabase
{
    private static $url = "mysql:host=localhost;dbname=mysite";
    private static $user = "root";
    private static $password = "root";

    protected $DB;

    protected function __construct()
    {
        $this->DB = new PDO(MysqlDatabase::$url, MysqlDatabase::$user, MysqlDatabase::$password);
        $this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static abstract function getInstance();
}