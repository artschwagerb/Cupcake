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
$show = new show(0);

if (!empty($_POST['request-series'])) {
	$commenttochange = new comment();
	$commenttochange->add($_POST['seriesname'],3,0);
	//$dbstuff->execute("INSERT INTO c_comment (user_id, message, status, type, parent_id) VALUES ('".addSlashes($fgmembersite->UserID())."', '".addSlashes($_POST['message'])."', '1', '0', '".addSlashes($episode->tvdb_episode_id)."')");
	//do something here;
	header("Location: show.php");
}
?>

	<div class="row">
		<div class="eight columns">
		<?php $show->getAllBanners(); ?>
		</div>
		<div class="four columns">
			<form name="report_problem" method="post" class="nice">
			<fieldset>
							<h5>Request a TV Series</h5>
							<p>What series is just too amazing to miss?</p>

							<label>Series Name</label>
							<input type="text" name="seriesname" class="input-text">
							<input type="submit" name="request-series" value="Submit" />
							
						</fieldset>
			</form>
		</div>
	</div>

<?php
}else{
$show = new show($_GET["id"]);
header ('Location:  season.php?id='.$show->getFirstSeason()->tvdb_season_id );
exit();
?>
<div class="row">
			<div class="eight columns">
				<div class="row">
					<div class="twelve columns">
						<a title="<?php echo $show->name; ?>" href="show.php?id=<?php echo $show->tvdb_series_id; ?>"><img src="<?php echo $show->getBanner(); ?>" /></a>
					</div>
				</div>
				<br />
				<?php $show->getFirstSeason()->getEpisodes(); ?>
			</div>
			<div class="four columns">			
				<form>
					<fieldset>
						<h5>Report a Problem</h5>
						<p>Whats wrong with <?php echo $show->name; ?>?</p>

						<label>Problem</label>
									<select>
									  <option SELECTED>Episodes are missing</option>
									  <option>Information is incorrect</option>
									  <option>Episodes don't work</option>
									</select>
								<label>Comment</label>
								<input type="text" class="input-text">
								<input type="submit" value="Submit" />
								
					</fieldset>
				</form>
			</div>

<?php

}
?>
		

	<?php 
	include TEMPLATE_PATH."/footer.php";
	?>
