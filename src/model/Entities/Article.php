<?php

namespace qk1e\mysite\model;

class Article
{
    private $header;
    private $htmlcontent; //not gonna use for now
    private $textcontent; //gonna use
    private $date;
    private $author;

    /**
     * Article constructor.
     * @param $header
     * @param $textcontent
     * @param $date
     * @param $author
     */
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
    public function getTextcontent()
    {
        return $this->textcontent;
    }

    /**
     * @param mixed $textcontent
     */
    public function setTextcontent($textcontent)
    {
        $this->textcontent = $textcontent;
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
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }


}