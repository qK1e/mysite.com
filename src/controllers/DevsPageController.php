<?php


namespace qk1e\mysite\controllers;

require_once $_SERVER["DOCUMENT_ROOT"]."/src/model/Dummy_Devs_DB_Controller.php";

use qk1e\mysite\model\Dummy_Devs_DB_Controller;

class DevsPageController
{
    private $devs;

    public function getPage()
    {
        $this->getDevs();
        include $_SERVER["DOCUMENT_ROOT"]."/views/devs.php";
    }

    private function getDevs(){
        $DB = new Dummy_Devs_DB_Controller();
        $this->devs = $DB->getSomeDevs(5);
    }
}