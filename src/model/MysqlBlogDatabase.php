<?php


namespace qk1e\mysite\model;

use PDO;
use PDOException;
use qk1e\mysite\model\entities\Article;
use qk1e\mysite\model\entities\Comment;
use qk1e\mysite\model\entities\Developer;
use qk1e\mysite\search\SearchItemCollection;
use qk1e\mysite\search\SearchQuery;

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

    public function getPageOfArticles($page, $page_size): array
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

    public function addArticle(Article $article): void
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

    public function getIdByHeader($header): int
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

    public function postComment($blog_id, $user_id, $text, $answer_to=null):bool
    {
        try
        {
            //validate input
            if(!$blog_id || !$user_id || !$text)
            {
                return false;
            }
            //put comment in db
            if(!$answer_to)
            {
                $answer_to = 0;
            }
            $query = "
                INSERT INTO comments(`blog_id`, `author_id`, `to_id`, `content`)
                VALUES (?,?,?,?)
            ";

            $statement = $this->DB->prepare($query);
            $statement->bindParam(1, $blog_id, PDO::PARAM_INT);
            $statement->bindParam(2, $user_id, PDO::PARAM_INT);
            $statement->bindParam(3, $answer_to, PDO::PARAM_INT);
            $statement->bindParam(4, $text, PDO::PARAM_STR);
            $statement->execute();

            return true;
        }
        catch (PDOException $e)
        {
            return false;
        }
    }

    public function getComments($blog_id): ?array
    {
        try
        {
            $query = "
            SELECT * 
            FROM comments
            WHERE `blog_id`=?
        ";

            $statement = $this->DB->prepare($query);
            $statement->bindParam(1, $blog_id, PDO::PARAM_INT);
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_CLASS, Comment::class);

            $comments = $statement->fetchAll();

            return $comments;
        }
        catch (PDOException $e)
        {
            return null;
        }

    }

    public function getCommentById($id): ?Comment
    {
        try
        {
            $query = "
                SELECT * 
                FROM comments
                WHERE `id`=?
            ";

            $statement = $this->DB->prepare($query);
            $statement->bindParam(1, $id, PDO::PARAM_INT);
            $statement->setFetchMode(PDO::FETCH_CLASS, Comment::class);
            $statement->execute();

            $comment = $statement->fetch();

            if($comment)
            {
                return $comment;
            }
            else
            {
                return null;
            }
        }
        catch (PDOException $e)
        {
            return null;
        }
    }

    public function deleteComment($id): bool
    {
        try
        {
            $query = "
                DELETE FROM comments
                WHERE `id`=?
            ";

            $statement = $this->DB->prepare($query);
            $statement->bindParam(1, $id, PDO::PARAM_INT);
            $statement->execute();

            return true;
        }
        catch (PDOException $e)
        {
            return false;
        }
    }

    public function deleteArticle($id): bool
    {
        try
        {
            $query = "
            DELETE FROM blogs
            WHERE id=?
            ";

            $statement = $this->DB->prepare($query);
            $statement->bindParam(1, $id, PDO::PARAM_INT);
            $statement->execute();

            return true;


        }
        catch (PDOException $e)
        {
            return false;
        }

    }

    public function search(SearchQuery $search_query): SearchItemCollection
    {
        $text = $search_query->getSearchText();
        $collection = new SearchItemCollection();

        //search for developers
        $query = "
            SELECT developers.*, users.login
            FROM developers JOIN users ON developers.user_id=users.id
            WHERE concat(`first_name`, ' ', `second_name`) LIKE concat('%', :text, '%')
                OR users.login LIKE concat('%', :text, '%')
                ";

        $statement = $this->DB->prepare($query);
        $statement->bindParam(':text', $text, PDO::PARAM_STR);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Developer::class);

        $result = $statement->fetchAll();

        //add developers to collection
        $collection->add($result);

        //search for blogs
        $query = "
            SELECT blogs.*, users.login
            FROM blogs JOIN users ON blogs.author_id=users.id
            WHERE `header` LIKE concat('%', :text, '%')
                OR `content` LIKE concat('%', :text, '%')
                OR users.login LIKE concat('%', :text, '%')";

        $statement = $this->DB->prepare($query);
        $statement->bindParam(':text', $text, PDO::PARAM_STR);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Article::class);

        $result = $statement->fetchAll();

        //add blogs to collection
        $collection->add($result);

        return $collection;
    }
}