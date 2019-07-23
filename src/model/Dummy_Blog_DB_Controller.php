<?php


namespace qk1e\mysite\model;
use qk1e\mysite\model\entities\Article;

class Dummy_Blog_DB_Controller implements Blog_DB_Controller
{
    public function getRecentArticles($number)
    {
        $articles = [];
        for($i=0;$i<$number;$i++)
        {
            $articles[$i] = new Article();
            $articles[$i]->setHeader("Header $i");
            $articles[$i]->setAuthor("Суперкрутой Разраб");
            $articles[$i]->setDate("2019-07-10");
            $articles[$i]->setTextcontent("Content of $i article");
        }

        return $articles;
    }
}