<?php


namespace qk1e\mysite\controllers;


class InfoController
{

    public function info(Request $request)
    {
        echo phpinfo();
    }

}