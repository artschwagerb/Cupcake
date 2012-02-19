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
$show = new show(0);
$show->getAllBanners();
}else{
$show = new show($_GET["id"]);
$show->getBanner();
$show->getSeasons();
$show->getDescription();

if($fgmembersite->UserAdmin()==9) {
$show->getUpdateLink();
}
}



?>