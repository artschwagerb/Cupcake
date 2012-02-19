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
$user = new user($_SESSION['id_of_user']);
//$user->view();
}else{
$user = new user($_GET["id"]);
//$user->view();

}
?>
		<div class="row">
			<div class="twelve columns">
				<div class="row">
				<dl class="nice contained tabs">
					<dd><a href="#profile" class="active">Profile</a></dd>
					<dd><a href="#activity">Activity</a></dd>
					<?php if($_SESSION['id_of_user'] == $user->id) {?>
					<dd><a href="#password">Password</a></dd>
					<?php } ?>
				</dl>
				<ul class="nice tabs-content contained">
				<li class="active" id="profileTab">
					<?php echo $user->view() ?>
				</li>
				<li id="activityTab">
					<?php echo $user->get_activity(); ?>
				</li>
				<li id="passwordTab">
					<div style="width:300px;"><?php include("change-pwd.php"); ?></div>
				</li>
				</ul>
				</div>
			</div>
		</div>
		
	<?php 
	include TEMPLATE_PATH."/footer.php";
	?>