<?php


namespace qk1e\mysite\controllers;


class InfoController
{

    public function info($request)
    {
        echo phpinfo();
    }

}