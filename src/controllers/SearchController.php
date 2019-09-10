<?php


namespace qk1e\mysite\controllers;


use qk1e\mysite\model\MysqlBlogDatabase;
use qk1e\mysite\Request;
use qk1e\mysite\search\SearchQuery;
use qk1e\mysite\security\SecuritySystem;
use qk1e\mysite\view\View;


class SearchController
{
    public function search(Request $request)
    {
        $args = array();
        $role = SecuritySystem::currentUserRole();
        $args["user_role"] = $role;

        //create a SearchQuery
        $search_query = new SearchQuery();
        $search_text = $request->getArgument("search-text");
        $search_query->setSearchText($search_text);
        //search for elements, get SearchItem's collection
        $DB = MysqlBlogDatabase::getInstance();
        $search_result_collection = $DB->search($search_query);
        $args["search_items"] = $search_result_collection;

        //show page
        $view = new View();
        $view->getPage("search", $args);
    }
}