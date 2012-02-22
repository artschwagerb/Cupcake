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
echo "episode id not provided.";
}else{
$episode = new episode($_GET["id"]);
//Log a view----------
$episode->log_View();
?>

<script type="text/javascript">
<?php
$nextepisodetoplay = new episode($episode->getNextEpisode())
?>
var nextVideo = "<?php echo $nextepisodetoplay->filename;?>";
var episodePlayer = document.getElementsByTagName('video');
episodePlayer.onend = function(){
    //episodePlayer.src = nextVideo;
    //episodePlayer.play();
    
    //var mediaSource = document.getElementsByTagName('source')[0];
    //var mediaSource = document.getElementById('episodePlayer')
    //mediaSource.src = nextVideo;

    //var player = document.getElementByTagName('video')[0];
    //player.load();
    //player.play();
}


</script>

<script type="text/javascript">
<?php
$nextepisodetoplay = new episode($episode->getNextEpisode())
?>
//var nextVideo = "<?php echo $nextepisodetoplay->filename;?>";

//var videoPlayer = document.getElementById('videoPlayer');
//videoPlayer.onend = function(){
//    videoPlayer.src = nextVideo;
//}
</script>
<?php
if (!empty($_POST['add-comment'])) {
	$commenttochange = new comment();
	$commenttochange->add($_POST['message'],0,$episode->tvdb_episode_id);
	//$dbstuff->execute("INSERT INTO c_comment (user_id, message, status, type, parent_id) VALUES ('".addSlashes($fgmembersite->UserID())."', '".addSlashes($_POST['message'])."', '1', '0', '".addSlashes($episode->tvdb_episode_id)."')");
	//do something here;
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=player.php?id='.$episode->tvdb_episode_id.'">';
}
if (!empty($_POST['remove-comment'])) {
	$commenttochange = new comment($_POST['comment-id']);
	$commenttochange->hide();
	
	//$dbstuff->execute("UPDATE c_comment SET status = 0 WHERE id = ".$_POST['comment-id']." and parent_id = ".$episode->tvdb_episode_id);
   //do something here;
}
if (!empty($_POST['undelete-comment'])) {
	$commenttochange = new comment($_POST['comment-id']);
	$commenttochange->show();
	
	//$dbstuff->execute("UPDATE c_comment SET status = 1 WHERE id = ".$_POST['comment-id']." and parent_id = ".$episode->tvdb_episode_id);
   //do something here;
}
if (!empty($_POST['report-comment'])) {
	$commenttochange = new comment($_POST['comment-id']);
	$commenttochange->report();
	
	//$dbstuff->execute("UPDATE c_comment SET status = 2 WHERE id = ".$_POST['comment-id']." and parent_id = ".$episode->tvdb_episode_id);
   //do something here;
}
if (!empty($_POST['acknowledge-comment'])) {
	$commenttochange = new comment($_POST['comment-id']);
	$commenttochange->acknowledge();
	
	//$dbstuff->execute("UPDATE c_comment SET status = 1 WHERE id = ".$_POST['comment-id']." and parent_id = ".$episode->tvdb_episode_id);
   //do something here;
}
if (!empty($_POST['report-problem'])) {
	$commenttochange = new comment();
	$commenttochange->add($_POST['problem']."     ---     ".$_POST['comment'],1,$episode->tvdb_episode_id);
	//$dbstuff->execute("INSERT INTO c_comment (user_id, message, status, type, parent_id) VALUES ('".addSlashes($fgmembersite->UserID())."', '".addSlashes($_POST['message'])."', '1', '0', '".addSlashes($episode->tvdb_episode_id)."')");
	//do something here;
}
//--------------------
//echo "<br />";
?>

		<div class="row">
			<div class="eight columns">
				<div class="row">
					<div class="eight columns">
							<h4><a href="show.php?id=<?php echo $episode->show->tvdb_series_id; ?>"><?php echo $episode->show->name; ?></a></h4>
							<h5><?php echo $episode->name; ?></h5>

					</div>
					<div class="four columns">
						<div class="row">
							<h6 style="text-align: right; padding-bottom: 10px;">Aired: <?php echo $episode->getAirDate(); ?></h6>
						</div>
						<div class="row">
							<p style="text-align: right; ">
							<?php
							$nextepisode = new episode($episode->getNextEpisode()); 
							if(!$nextepisode->tvdb_episode_id==0) {	
							?>
							<a class='xsmall white nice button radius' href="player.php?id=<?php echo $nextepisode->tvdb_episode_id; ?>">Next Episode?</a>
							<?php
							}
							?>
							<a class="xsmall white nice button radius" href="javascript:;" onmousedown="toggleDiv('description-spoiler');">v</a>
							</p>
						</div>
					</div>
				</div>
				<div id="description-spoiler" style="display: none; ">
					<div class="row">
						<div class="panel">
							<p><?php echo nl2br($episode->description); ?></p>
							<p><?php echo "Season ".$episode->season->number." - Episode ".$episode->number; ?></p>
						</div>
					</div>
				</div>
				<div class="row">
					<center>
						<div class="video-js-box vim-css">
							<video id="episodeplayer" preload="auto" class="video-js" width="624" height="352" controls preload>
							  <source src="<?php echo $episode->filename;?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' />
								<!-- Image Fallback. Typically the same as the poster image. -->
							</video>
					    
                                                </div>
                                        </center>
				</div>
				<br />
				<div class="row">
				<h5>Comments</h5>
				<hr style="margin-top: 6px; margin-bottom: 6px; "/>
				<?php $episode->getComments(); ?>
				<div class="row">
					<fieldset>
					<form name="add_comment" method="post" class="nice">
						<textarea name="message" class="twelve columns"></textarea>
						<input type="submit" name="add-comment" value="Add Comment" class="xsmall white nice button radius"/>
					</form>
					<fieldset>
				</div>
				</div>

			</div>

			<div class="four columns show-on-desktops"">			
				<form name="report_problem" method="post" class="nice">
				<fieldset>
								<h5>Report a Problem</h5>
								<p>Problem with this episode of <?php echo $episode->show->name; ?>?</p>

								<label>Problem</label>
									<select name="problem">
									  <option SELECTED>Video doesn't play</option>
									  <option>Video is wrong</option>
									  <option>Information is incorrect</option>
									</select>
								<label>Comment</label>
								<input type="text" class="input-text" name="comment">
								<input type="submit" value="Submit" name="report-problem" />
							</fieldset>
				</form>
			</div>
		</div>
<?php } ?>
		
	<?php 
	include TEMPLATE_PATH."/footer.php";
	?>
