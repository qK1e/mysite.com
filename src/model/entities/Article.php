<?php

namespace qk1e\mysite\model\entities;

use qk1e\mysite\model\MysqlBlogDatabase;
use qk1e\mysite\model\MysqlUsersDatabase;

class Article
{
    private $id;
    private $header; //string
    private $content; //string
    private $date; //j-n-Y date
    private $author_id;
    private $visibility; //type: bool

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     *
     * returns author id in the database
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }

    public function getAuthorLogin()
    {
        $DB = MysqlUsersDatabase::getInstance();
        return $DB->loginById($this->author_id);
    }

    /**
     * @param mixed $author
     */
    public function setAuthorId($author)
    {
        $this->author_id = $author;
    }

    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        if (isset($this->id))
        {
            return $this->id;
        }
        else
        {
            $DB = MysqlBlogDatabase::getInstance();
            return $DB->getIdByHeader($this->header);
        }
    }

}