<?php


namespace qk1e\mysite\controllers;

use qk1e\mysite\controllers\Controller;
use qk1e\mysite\model\entities\Article;
use qk1e\mysite\model\entities\User;
use qk1e\mysite\model\MysqlBlogDatabase;
use qk1e\mysite\security\SecuritySystem;
use qk1e\mysite\view\View;

class BlogPageController
{
    private $recent_articles = array();
    private $page_size = 2;

    /**
     * BlogPageController constructor.
     */

    public function __construct()
    {
    }

    public function getBlogPage($request)
    {
        if(isset($request["page"]) && $request["page"] > 0)
        {
            $page = $request["page"];

        }
        else
        {
            $page = 1;
        }
        $this->getArticles($page);

        $args = array();
        $args["recent_articles"] = $this->recent_articles;
        $args["blog_page"] = $page;

        $view = new View();
        $view->getPage("blog", $args);
    }

    private function getArticles($page)
    {
        $DB = new MysqlBlogDatabase();
        $articles = $DB->getPageOfArticles($page, $this->page_size);

        foreach ($articles as $unprepared_article)
        {
            $article = array();
            $article["header"] = $unprepared_article->getHeader();
            $article["content"] = $unprepared_article->getContent();
            $article["author"] = $unprepared_article->getAuthorLogin();
            $article["date"] = $unprepared_article->getDate();
            array_push($this->recent_articles, $article);
        }
    }

    public function newBlog($request)
    {
        $view = new View();
        $view->getPage("new_blog", null);
    }

    public function submitBlog($request)
    {
        $ss = new SecuritySystem();
        $article = new Article();

        $user_login = $ss->currentUser();
        $user_id = User::idByLogin($user_login);

        $article->setAuthorId($user_id);
        $article->setHeader($request["header"]);
        $article->setContent($request["content"]);
        $article->setDate(date("j-n-Y"));
        $article->setVisibility(true);

        $DB = new MysqlBlogDatabase();

        $DB->addArticle($article);

        header("Location: /blog");
    }
}