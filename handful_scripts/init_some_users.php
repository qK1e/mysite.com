<?php

try
{
    $DB = new PDO("mysql:host=localhost;dbname=mysite", "admin", "root");
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $password = password_hash("1", PASSWORD_DEFAULT);
    $DB->query("
            INSERT INTO users
            SET `login`='gates',
                `password`='".$password."',
                `role`='developer'
    ");
}
catch (PDOException $e)
{
    echo $e->getMessage();
}
