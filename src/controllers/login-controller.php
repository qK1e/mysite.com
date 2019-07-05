<?php

function index(){
    include "../../views/login.php";
}

function post() {
    session_start();
    $_SESSION["login"] = $_REQUEST['username'];
    include "../../views/main-page.php";
}

