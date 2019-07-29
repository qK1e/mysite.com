<?php

try
{
    $DB = new PDO("mysql:host=localhost;dbname=mysite", "admin", "root");
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $DB->query("
            CREATE TABLE IF NOT EXISTS users(
                id INT PRIMARY KEY AUTO_INCREMENT,
                login VARCHAR(30) NOT NULL,
                password VARCHAR(255) NOT NULL,
                first_name VARCHAR(20),
                second_name VARCHAR(20),
                role VARCHAR(15) DEFAULT 'reader'
            )
            ");

    $DB->query("
        CREATE TABLE IF NOT EXISTS blogs(
            id INT PRIMARY KEY AUTO_INCREMENT,
            header VARCHAR(100),
            content TEXT(65000),
            author_id INT,
            date VARCHAR(10),
            visibility BOOL,
            FOREIGN KEY (author_id) REFERENCES users(id)
        )
    ");

}
catch (PDOException $e)
{
    echo $e->getMessage();
}