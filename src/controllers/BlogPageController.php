<?php


namespace qk1e\mysite\controllers;

use qk1e\mysite\model\Dummy_Blog_DB_Controller as Dummy_Blog_DB_Controller;
use qk1e\mysite\controllers\Controller;
use qk1e\mysite\view\View;

class BlogPageController implements Controller
{
    private $recent_articles;

    /**
     * BlogPageController constructor.
     */

    public function __construct()
    {
    }

    public function handleRequest($url)
    {
        $this->getRecentArticles();

        $args = array();
        $args["recent_articles"] = $this->recent_articles;

        $view = new View();
        $view->getPage("blog", $args);
    }

    private function getRecentArticles()
    {
        $DB = new Dummy_Blog_DB_Controller();
        $this->recent_articles = $DB->getRecentArticles(4);
    }


}