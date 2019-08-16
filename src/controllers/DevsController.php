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
        $filter = new DeveloperFilter();
        if($request->getArgument("first-name"))
        {
            $filter->setFirstName($request->getArgument("first-name"));
        }
        if($request->getArgument("second-name"))
        {
            $filter->setSecondName($request->getArgument("second-name"));
        }
        $this->getDevs($filter);

        $args = array();
        $args["devs"] = $this->devs;

        $ss = new SecuritySystem();
        $args["user_role"] = $ss->currentUserRole();

        $view = new View();
        $view->getPage("devs", $args);
    }

    private function getDevs($filter)
    {
        $DB = new MysqlDevelopersDatabase();
        $this->devs = $DB->getPageOfDevelopers(1, 5, $filter);
    }
}