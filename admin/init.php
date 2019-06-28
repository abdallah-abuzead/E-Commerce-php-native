<?php

    include "connect.php";

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

    //inclide navbar in only the specific pages

    if(!isset($noNavbar)) include $tpl."navbar.php";
