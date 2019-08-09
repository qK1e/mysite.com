<?php


namespace qk1e\mysite\controllers;

use qk1e\mysite\model\Dummy_Devs_DB_Controller;
use qk1e\mysite\model\MysqlDevelopersDatabase;
use qk1e\mysite\Request;
use qk1e\mysite\security\SecuritySystem;
use qk1e\mysite\view\View;

class DevsController
{
    private $devs;

    public function getDevsPage(Request $request)
    {
        $this->getDevs();

        $args = array();
        $args["devs"] = $this->devs;

        $ss = new SecuritySystem();
        $args["user_role"] = $ss->currentUserRole();

        $view = new View();
        $view->getPage("devs", $args);
    }

    private function getDevs()
    {
        $DB = new MysqlDevelopersDatabase();
        $this->devs = $DB->getDevs(5);
    }
}