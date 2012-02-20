<!DOCTYPE html>
<?php

require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
if(!$fgmembersite->CheckAdmin())
{
	echo "You are not an admin... why am I even talking to you?";
	exit;
}

include "config.php";
include TEMPLATE_PATH."/header.php";

$stats = new statistics();

?>
		<div class="row">
			<div class="eight columns">
				<div class="row">
				<dl class="nice contained tabs">
					<dd><a href="#statistics" class="active">Statistics</a></dd>
					<dd><a href="#database">Database</a></dd>
					<dd><a href="#moderation">Moderation</a></dd>
				</dl>
				<ul class="nice tabs-content contained">
				<li class="active" id="statisticsTab">
						<?php echo $stats->get_shows_watched_summary(24); ?>
						<?php echo $stats->get_newsfeed(24); ?>
						<?php echo $stats->get_users_active(24); ?>
				</li>
				<li id="databaseTab">
					<form name="seriesscript" action="get_tv_info.php" method="get">
							<h5>Add/Update a Series</h5>
							<p>Wish you could type less and get more?</p>
							<input type="hidden" name="authid" value="<?php echo $fgmembersite->UserID(); ?>">
						
							<label>Series ID</label>
							<input type="text" name="id" class="input-text">
							<input type="submit" value="Submit" />						
					</form>
					<?php echo $stats->get_shows(); ?>
				</li>
				<li id="moderationTab">
					<?php echo $stats->get_requests(); ?>
                                        <?php echo $stats->get_episode_problems(); ?>
				</li>
				</ul>
				</div>
			</div>
			<div class="four columns">			
				Stuffs
			</div>
		</div>
		
	<?php 
	include TEMPLATE_PATH."/footer.php";
	?>