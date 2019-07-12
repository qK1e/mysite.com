<?php


namespace qk1e\mysite\controllers;

require_once $_SERVER["DOCUMENT_ROOT"]."/src/model/Dummy_Blog_DB_Controller.php";

use qk1e\mysite\model\Dummy_Blog_DB_Controller as Dummy_Blog_DB_Controller;

class BlogPageController
{
    private $recent_articles;

    /**
     * BlogPageController constructor.
     */

    public function __construct()
    {
    }


    public function getPage(){
        $this->getRecentArticles();
        include $_SERVER["DOCUMENT_ROOT"]."/views/blog.php";
    }

    private function getRecentArticles()
    {
        $DB = new Dummy_Blog_DB_Controller();
        $this->recent_articles = $DB->getRecentArticles(4);
    }
}