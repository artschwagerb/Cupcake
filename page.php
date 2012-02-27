<!DOCTYPE html>
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
$page = new page(0);
}else{
$page = new page($_GET["id"]);

}

if(strlen($page->sidebar) > 0) {
//Doesnt Have a Sidebar
?>
    <div class="row">
        <div class="eight columns">
            <div class="row">
                <div class="nine columns">
                <?php
                    if (strlen($page->title) > 0) {
                        echo "<h4>".$page->title."</h4>";
                    }
                ?>
                </div>
                <div class="three columns">
                <?php
                    echo $page->get_modified_date();
                ?>
                </div>
            </div>
            <?php
                echo nl2br($page->body);
            ?>
        </div>
        <div class="four columns">			
            <?php echo $page->sidebar; ?>
        </div>
    </div>
<?php
} else {
//Has a Sidebar
?>
    <div class="row">
        <div class="twelve columns">
            <?php
                if (strlen($page->title) > 0) {
                    echo "<h4>".$page->title."</h4>";
                }
                echo nl2br($page->body);
            ?>      
        </div>
    </div>
<?php
}
		
include TEMPLATE_PATH."/footer.php";
?>