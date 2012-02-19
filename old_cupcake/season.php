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
echo "Season id not provided.";
}else{
$season = new season($_GET["id"]);
$season->getBanner();
echo "<br />";
$season->getEpisodes();
}



?>