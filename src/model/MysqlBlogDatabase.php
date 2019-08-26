<?php


namespace qk1e\mysite\model;

use PDO;
use PDOException;
use qk1e\mysite\model\entities\Article;

class MysqlBlogDatabase extends MysqlDatabase
{
    private static $instance;


    private function __construct()
    {
        parent::__construct();
    }

    public static function getInstance(): MysqlBlogDatabase
    {
        if(MysqlBlogDatabase::$instance)
        {
            return MysqlBlogDatabase::$instance;
        }
        else
        {
            MysqlBlogDatabase::$instance = new MysqlBlogDatabase();
            return MysqlBlogDatabase::$instance;
        }
    }



    public function getPageOfArticles($page, $page_size)
    {
        $articles = [];

        $from = ($page - 1) * $page_size;

        $query = "
            SELECT *
            FROM blogs
            ORDER BY `date`
            LIMIT ?,?
        ";

        $statement = $this->DB->prepare($query);
        $statement->bindParam(1, $from, PDO::PARAM_INT);
        $statement->bindParam(2, $page_size, PDO::PARAM_INT);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Article::class);
        $articles = $statement->fetchAll();

        return $articles;
    }

    public function addArticle(Article $article)
    {
        $header = $article->getHeader();
        $content = $article->getContent();
        $author_id = $article->getAuthorId();
        $date = $article->getDate();

        try
        {
            $query = "
                INSERT INTO blogs(header, content, author_id, `date`, visibility)
                VALUES (?, ?, ?, ?, TRUE)
            ";

            $statement = $this->DB->prepare($query);
            $statement->bindParam(1, $header, PDO::PARAM_STR);
            $statement->bindParam(2, $content, PDO::PARAM_STR);
            $statement->bindParam(3, $author_id, PDO::PARAM_INT);
            $statement->bindParam(4, $date, PDO::PARAM_STR);
            $statement->execute();

        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getIdByHeader($header)
    {
        try
        {
            $query = "
                SELECT id
                FROM blogs
                WHERE header = ?
            ";

            $statement = $this->DB->prepare($query);
            $statement->execute(array($header));

            return $statement->fetch(PDO::FETCH_ASSOC)["id"];
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getArticleById($id)
    {
        $query = "
            SELECT *
            FROM blogs
            WHERE `id` = ?
        ";

        $statement = $this->DB->prepare($query);
        $statement->bindParam(1, $id, PDO::PARAM_INT);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Article::class);

        $article = $statement->fetch();

        return $article;
    }


}