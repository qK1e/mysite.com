<?php
require_once "src/router.php";

use qk1e\mysite\Router as Router;

session_start();

Router::route($_GET["path"]);