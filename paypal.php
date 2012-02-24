<!DOCTYPE html>
<?php
require_once("./include/membersite_config.php");

if (!$fgmembersite->CheckLogin()) {
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
include "config.php";
include TEMPLATE_PATH . "/header.php";
?>
<div class="row">
    <div class="eight columns">
        <h4>Title</h4>


    </div>

    <div class="four columns">			
        <h4>Sidebar</h4>
    </div>
</div>

<?php
include TEMPLATE_PATH . "/footer.php";
?>