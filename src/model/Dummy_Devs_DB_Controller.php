<?php


namespace qk1e\mysite\model;

require_once $_SERVER["DOCUMENT_ROOT"]."/src/model/Devs_DB_Controller.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/src/model/Entities/Developer.php";

class Dummy_Devs_DB_Controller implements Devs_DB_Controller
{

    public function getSomeDevs($number)
    {
        $devs = array();
        for($i = 0; $i < $number; $i++)
        {
            $devs[$i] = new Developer();
            $devs[$i]->setFName("БОЧ".$i);
            $devs[$i]->setSName("Фролов-Воронин");
            $devs[$i]->setAbout("Привет, я "."Биологический Объект Человек рода Ворониных-Фроловых №".$i."!");
        }

        return $devs;
    }


}