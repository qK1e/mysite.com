<?php


namespace qk1e\mysite\controllers;


class ProfilePageController
{
    public function getPage(){
        include $_SERVER["DOCUMENT_ROOT"]."/views/profile.php";
    }
}