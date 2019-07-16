<?php


namespace qk1e\mysite\controllers;

require_once $_SERVER["DOCUMENT_ROOT"]."/src/model/Dummy_Devs_DB_Controller.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/src/controllers/Controller.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/src/view/View.php";

use qk1e\mysite\model\Dummy_Devs_DB_Controller;
use qk1e\mysite\controllers\Controller;
use qk1e\mysite\view\View;

class DevsPageController implements Controller
{
    private $devs;


    private function getDevs(){
        $DB = new Dummy_Devs_DB_Controller();
        $this->devs = $DB->getSomeDevs(5);
    }

    public function handleRequest($url)
    {
        $this->getDevs();

        $args = array();
        $args["devs"] = $this->devs;

        $view = new View();
        $view->getPage("devs", $args);
    }
}