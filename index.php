<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/src/router.php";
use qk1e\mysite\Router as Router;

session_start();

Router::route($_GET["path"]);