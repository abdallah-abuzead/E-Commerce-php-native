<?php
    ini_set("display_errors", "on");
    error_reporting(E_ALL);
    include "admin/connect.php";
    $sessionUser = "";
    if(isset($_SESSION['user'])) $sessionUser = $_SESSION['user'];

    // Routes

    $tpl = 'includes/templates/';	// templates directory
    $css = 'layout/css/';			//css directory
    $js = 'layout/js/';				//js directory
    $func = 'includes/functions/';  //Functions Directory
    $lang = 'includes/languages/';  //Language directory

    // include important files

    include $lang."english.php";
    include $func."functions.php";
    include $tpl."_header.php";

