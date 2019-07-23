<?php


namespace qk1e\mysite\controllers;

use qk1e\mysite\model\Dummy_Devs_DB_Controller;
use qk1e\mysite\controllers\Controller;
use qk1e\mysite\view\View;

class DevsPageController
{
    private $devs;


    private function getDevs(){
        $DB = new Dummy_Devs_DB_Controller();
        $this->devs = $DB->getSomeDevs(5);
    }

    public function getDevsPage($request)
    {
        $this->getDevs();

        $args = array();
        $args["devs"] = $this->devs;

        $view = new View();
        $view->getPage("devs", $args);
    }
}