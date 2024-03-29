<?php


namespace qk1e\mysite\controllers;

use qk1e\mysite\model\entities\Article;
use qk1e\mysite\model\MysqlDatabase;
use qk1e\mysite\routing\ConfigurableRouter;
use qk1e\mysite\security\SecuritySystem;
use qk1e\mysite\view\View;
use qk1e\mysite\Request;

class BlogController
{

    private $recent_articles = [];

    private $page_size = 5;


    public function __construct()
    {
    }

    public function getBlogPage(Request $request)
    {
        $page = $request->getArgument("page");

        if (!isset($page) || $page == 0) {
            $page = 1;
        }

        $this->getArticles($page);

        $args = [];
        $args["recent_articles"] = $this->recent_articles;
        $args["blog_page"] = $page;

        $user_role = SecuritySystem::currentUserRole();
        $args["user_role"] = $user_role;

        $view = new View();
        $view->getPage("blog", $args);
    }

    public function newBlog(Request $request)
    {
        $args = array();
        $user_role = SecuritySystem::currentUserRole();
        $args["user_role"] = $user_role;

        $view = new View();
        $view->getPage("new_blog", $args);
    }

    public function submitBlog(Request $request)
    {
        $article = new Article();

        $user = SecuritySystem::currentUser();
        $user_id = $user->getUserId();

        $article->setAuthorId($user_id);
        $article->setHeader($request->getArgument("header"));
        $article->setContent($request->getArgument("content"));
        $article->setDate(date("j-n-Y"));
        $article->setVisibility(true);

        $DB = MysqlDatabase::getInstance();

        $DB->addArticle($article);

        $router = ConfigurableRouter::getInstance();
        $router->redirect("/blog");
    }

    public function getArticle(Request $request)
    {
        $role = SecuritySystem::currentUserRole();

        $id = $request->getArgument("id");
        $args = [];

        $DB = MysqlDatabase::getInstance();
        $article = $DB->getArticleById($id);
        $args["article"] = $article;
        $args["user_role"] = $role;

        $view = new View();
        $view->getPage("article", $args);
    }

    public function postComment(Request $request)
    {
        $blog_id = $request->getArgument("blog");
        $answer_to = $request->getArgument("answer_to");
        $text = $request->getArgument("text");
        $user = SecuritySystem::currentUser();
        $user_role = SecuritySystem::currentUserRole();

        if($user_role == ROLE_UNAUTHORIZED)
        {
            $this->ajaxError("Not authorized!");
        }
        else
        {
            $DB = MysqlDatabase::getInstance();
            if($DB->postComment($blog_id, $user->getUserId(), $text, $answer_to))
            {
               echo json_encode(array('success' => true));
            }
            else
            {
                $this->ajaxError("Couldn't post a comment");
            }

        }


    }

    public function getCommentSection(Request $request)
    {
        $blog_id = $request->getArgument("id");

        $DB = MysqlDatabase::getInstance();
        $comments = $DB->getComments($blog_id);

        $args = array();
        $args["comments"] = $comments;

        $user = SecuritySystem::currentUser();
        if($user)
        {
            $args["user"] = $user;
        }


        $view = new View();
        $view->getAsset("comment-section", $args);
    }

    public function deleteComment(Request $request)
    {
        $role = SecuritySystem::currentUserRole();
        if($role != ROLE_ADMIN)
        {
            $this->ajaxError("No permissions");
        }
        else
        {
            $id = $request->getArgument("id");

            $DB = MysqlDatabase::getInstance();
            if($DB->deleteComment($id))
            {
                echo json_encode(array('success' => true, 'id' => $id));
            }
            else
            {
                $this->ajaxError("Couln't delete comment");
            }

        }
    }

    public function deleteBlog(Request $request)
    {
        $role = SecuritySystem::currentUserRole();
        if($role != ROLE_ADMIN)
        {
            $this->ajaxError("No permissions!");
        }
        else
        {
            $id = $request->getArgument("id");

            $DB = MysqlDatabase::getInstance();
            if($DB->deleteArticle($id))
            {
                echo json_encode(array('success' => true, 'id' => $id));
            }

        }
    }

    private function ajaxError($message)
    {
        echo json_encode(array('error' => $message) );
    }

    private function getArticles($page)
    {
        $DB = MysqlDatabase::getInstance();
        $this->recent_articles = $DB->getPageOfArticles($page, $this->page_size);
    }
}