<?php
include "config.php";
include TEMPLATE_PATH."/header.php";

$cupcake = new cupcake(0);
$cupcake->getAll();

?>