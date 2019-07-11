<?php


namespace qk1e\mysite\model;


interface Blog_DB_Controller
{
    public function getRecentArticles($number);
}