<?php


namespace qk1e\mysite\controllers;

use qk1e\mysite\model\entities\Article;
use qk1e\mysite\model\entities\User;
use qk1e\mysite\model\MysqlBlogDatabase;
use qk1e\mysite\security\SecuritySystem;
use qk1e\mysite\view\View;
use qk1e\mysite\Request;

class BlogPageController
{
    private $recent_articles = array();
    private $page_size = 5;


    public function __construct()
    {
    }

    public function getBlogPage(Request $request)
    {
        $page = $request->getArgument("page");

        if (!isset($page) || $page == 0)
        {
            $page = 1;
        }

        $this->getArticles($page);

        $args = array();
        $args["recent_articles"] = $this->recent_articles;
        $args["blog_page"] = $page;

        $ss = new SecuritySystem();
        $user_role = $ss->currentUserRole();
        $args["user_role"] = $user_role;

        $view = new View();
        $view->getPage("blog", $args);
    }

    public function newBlog(Request $request)
    {
        $view = new View();
        $view->getPage("new_blog", null);
    }

    public function submitBlog(Request $request)
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

    private function getArticles($page)
    {
        $DB = new MysqlBlogDatabase();
        $this->recent_articles = $DB->getPageOfArticles($page, $this->page_size);
    }
}