<?php
include "config.php";
include TEMPLATE_PATH."/header.php";

$cupcake = new cupcake();
$cupcake->get($_GET["id"]);
$cupcake->view();

?>