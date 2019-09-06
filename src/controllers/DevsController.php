<?php


namespace qk1e\mysite\controllers;

use qk1e\mysite\model\entities\DeveloperFilter;
use qk1e\mysite\model\MysqlDevelopersDatabase;
use qk1e\mysite\Request;
use qk1e\mysite\security\SecuritySystem;
use qk1e\mysite\view\View;

class DevsController
{
    private $devs;

    public function getDevsPage(Request $request)
    {
        $args = array();

        $filter = new DeveloperFilter();
        if($request->getArgument("first-name"))
        {
            $filter->setFirstName($request->getArgument("first-name"));
        }
        if($request->getArgument("second-name"))
        {
            $filter->setSecondName($request->getArgument("second-name"));
        }
        $filter->setVisibility(true);


        $page = $request->getArgument("page");
        if(!isset($page) || $page == 0)
        {
            $page = 1;
        }
        $args["devs_page"] = $page;
        $this->getDevs($filter, $page);
        $args["devs"] = $this->devs;

        $args["user_role"] = SecuritySystem::currentUserRole();



        $view = new View();
        $view->getPage("devs", $args);
    }

    private function getDevs($filter, $page)
    {
        $DB = MysqlDevelopersDatabase::getInstance();
        $this->devs = $DB->getPageOfDevelopers($page, 5, $filter);
    }
}