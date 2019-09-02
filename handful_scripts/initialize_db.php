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
            first_name VARCHAR(30) DEFAULT 'John',
            second_name VARCHAR(30) DEFAULT 'Doe',
            visibility BOOL DEFAULT true,
            FOREIGN KEY (user_id) REFERENCES users(id)
        )
    ");

    $DB->query("
        CREATE TABLE IF NOT EXISTS profiles(
            id INT PRIMARY KEY AUTO_INCREMENT,
            dev_id INT,
            about TEXT(50000),
            photo LONGTEXT
        )
    ");

    $DB->query("
        CREATE TABLE IF NOT EXISTS comments(
            id INT PRIMARY KEY AUTO_INCREMENT,
            blog_id INT NOT NULL,
            author_id INT NOT NULL,
            to_id INT,
            content TEXT(5000)
        )
    ");

}
catch (PDOException $e)
{
    echo $e->getMessage();
}