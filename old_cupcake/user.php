<?php

require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

include "config.php";
include TEMPLATE_PATH."/header.php";

if(empty($_GET["id"])){
$user = new user($_SESSION['id_of_user']);
$user->view();
echo "<br />";
include "change-pwd.php";
}else{
$user = new user($_GET["id"]);
$user->view();

}




?>