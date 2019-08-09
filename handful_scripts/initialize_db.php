<?php

try
{
    $DB = new PDO("mysql:host=localhost;dbname=mysite", "root", "root");
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
            header VARCHAR(200),
            content TEXT(65000),
            author_id INT,
            date VARCHAR(10),
            visibility BOOL,
            FOREIGN KEY (author_id) REFERENCES users(id)
        )
    ");

    $DB->query("
        CREATE TABLE IF NOT EXISTS developers(
            id INT PRIMARY KEY AUTO_INCREMENT,
            user_id INT NOT NULL,
            profile_id INT,
            first_name VARCHAR(30),
            second_name VARCHAR(30),
            about TEXT(65000),
            photo BINARY(255),
            FOREIGN KEY (user_id) REFERENCES users(id)
        )
    ");

    $DB->query("
        CREATE TABLE IF NOT EXISTS profiles(
            id INT PRIMARY KEY AUTO_INCREMENT,
            dev_id INT,
            about TEXT(50000)
        )
    ");

}
catch (PDOException $e)
{
    echo $e->getMessage();
}