<?php


namespace qk1e\mysite\controllers;

use qk1e\mysite\model\entities\Article;
use qk1e\mysite\model\entities\User;
use qk1e\mysite\model\MysqlBlogDatabase;
use qk1e\mysite\security\SecuritySystem;
use qk1e\mysite\view\View;
use qk1e\mysite\Request;

class BlogController
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

        $user_role = SecuritySystem::currentUserRole();
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
        $article = new Article();

        $user = SecuritySystem::currentUser();
        $user_id = $user->getId();

        $article->setAuthorId($user_id);
        $article->setHeader($request->getArgument("header"));
        $article->setContent($request->getArgument("content"));
        $article->setDate(date("j-n-Y"));
        $article->setVisibility(true);

        $DB = MysqlBlogDatabase::getInstance();

        $DB->addArticle($article);

        header("Location: /blog");
    }

    public function getArticle(Request $request)
    {
        $role = SecuritySystem::currentUserRole();

        $id = $request->getArgument("id");
        $args = array();

        $DB = MysqlBlogDatabase::getInstance();
        $article = $DB->getArticleById($id);
        $args["article"] = $article;
        $args["user_role"] = $role;

        $view = new View();
        $view->getPage("article", $args);
    }

    private function getArticles($page)
    {
        $DB = MysqlBlogDatabase::getInstance();
        $this->recent_articles = $DB->getPageOfArticles($page, $this->page_size);
    }
}