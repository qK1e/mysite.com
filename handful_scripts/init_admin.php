<?php

try
{
    $DB = new PDO("mysql:host=localhost;dbname=mysite", "admin", "root");
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $password = password_hash("1", PASSWORD_DEFAULT);

    $DB->query("
    INSERT INTO users(`login`, `password`, `role`)
    VALUES ('admin', ".$DB->quote($password).", 'admin');
    ");

    //get id
    $statement = $DB->prepare("
    SELECT `id` FROM users WHERE `login` LIKE 'admin'
    ");
    $statement->execute();

    $id = $statement->fetchColumn(0);

    $DB->query("
    INSERT INTO developers(`user_id`, `visibility`)
    VALUES (".$id.", FALSE)
    ");

    $dev_id = $DB->lastInsertId();

    $DB->query("
    INSERT INTO profiles(`dev_id`)
    VALUES (".$dev_id.")
    ");

    $profile_id = $DB->lastInsertId();

    $DB->query("UPDATE developers SET `profile_id`=".$profile_id." WHERE `id`=".$dev_id);

}
catch (PDOException $e)
{
    $e->getMessage();
}
