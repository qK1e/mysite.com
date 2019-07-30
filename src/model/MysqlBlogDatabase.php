<?php


namespace qk1e\mysite\model;


use PDO;
use PDOException;
use qk1e\mysite\model\entities\Article;

class MysqlBlogDatabase
{
    private static $url = "mysql:host=localhost;dbname=mysite";
    private static $user = "admin";
    private static $password = "root";

    private $DB;

    /**
     * MysqlBlogDatabase constructor.
     */
    public function __construct()
    {

        $this->DB = new PDO(MysqlBlogDatabase::$url, MysqlBlogDatabase::$user, MysqlBlogDatabase::$password);
        $this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getPageOfArticles($page, $page_size)
    {
        $articles = [];

        $from = ($page-1) * $page_size;
        $response = $this->DB->query("
        SELECT * FROM blogs 
        ORDER BY `date` DESC 
        LIMIT ".$from.", ".$page_size
        );

        $result_set = $response->fetchAll();

        for($i = 0; $i < $page_size; $i++)
        {
            if(isset($result_set[$i]))
            {
                $article = new Article();
                $article->setHeader($result_set[$i]["header"]);
                $article->setDate($result_set[$i]["date"]);
                $article->setAuthorId($result_set[$i]["author_id"]);
                $article->setContent($result_set[$i]["content"]);
                $article->setVisibility($result_set[$i]["visibility"]);
                $article->setId($result_set[$i]["id"]);
                array_push($articles, $article);
            }
            else
            {
                break;
            }
        }

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
            $response = $this->DB->query("
                INSERT INTO blogs(header, content, author_id, `date`, visibility)
                VALUES (
                        '".$header."',
                        '".$content."',
                        '".$author_id."',
                        '".$date."',
                           TRUE
                )
            ");
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getIdByHeader($header)
    {
        $response = $this->DB->query("
            SELECT id
            FROM blogs
            WHERE header = '".$header."'
        ");

        $result_set = $response->fetchAll();

        return $result_set[0]["id"];
    }


    private function validateArticle()
    {

    }

    private function prepareText()
    {

    }
}