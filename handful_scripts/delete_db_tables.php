<?php

try{
    $DB = new PDO("mysql:host=localhost;dbname=mysite", "root", "root");

    $DB->query("DROP TABLE blogs");
    $DB->query("DROP TABLE profiles");
    $DB->query("DROP TABLE developers");
    $DB->query("DROP TABLE users");
}
catch (PDOException $e)
{
    $e->getMessage();
}


