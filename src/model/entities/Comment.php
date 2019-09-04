<?php


namespace qk1e\mysite\model\entities;


use qk1e\mysite\model\MysqlBlogDatabase;
use qk1e\mysite\model\MysqlUsersDatabase;

class Comment
{
    private $id;
    private $to_id;
    private $to_comment;
    private $author_id;
    private $content;
    private $blog_id;

    private $DB;

    /**
     * Comment constructor.
     */
    public function __construct()
    {
        $this->DB = MysqlBlogDatabase::getInstance();
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  mixed  $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getToId()
    {
        return $this->to_id;
    }

    /**
     * @param  mixed  $to_id
     */
    public function setToId($to_id): void
    {
        $this->to_id = $to_id;
    }

    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }

    /**
     * @param  mixed  $author_id
     */
    public function setAuthorId($author_id): void
    {
        $this->author_id = $author_id;
    }

    public function getAuthorlogin(): string
    {
        $DB = MysqlUsersDatabase::getInstance();
        $login = $DB->getUserById($this->author_id)->getLogin();

        if($login)
        {
            return $login;
        }
        else
        {
            return "anonymous";
        }

    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param  mixed  $text
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getBlogId()
    {
        return $this->blog_id;
    }

    /**
     * @param  mixed  $blog_id
     */
    public function setBlogId($blog_id): void
    {
        $this->blog_id = $blog_id;
    }

    /**
     * @return mixed
     */
    public function getToComment()
    {
        if($this->to_comment)
        {
            return $this->to_comment;
        }
        else
        {
            $this->to_comment = $this->DB->getCommentById($this->to_id);
            return $this->to_comment;
        }

    }

    /**
     * @param  mixed  $to_comment
     */
    public function setToComment($to_comment): void
    {
        $this->to_comment = $to_comment;
    }

}