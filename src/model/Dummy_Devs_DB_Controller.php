<?php


namespace qk1e\mysite\model;

use qk1e\mysite\model\entities\Developer;

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