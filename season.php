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

//Process update-series form-###############################################################################################
if (!empty($_POST['update-series'])) {
        ?>
        <script type='text/javascript'> $(document).ready(function() { $('#update_Series_Modal').reveal(); }); </script>
        <div id="update_Series_Modal" class="reveal-modal">
            <?php include(SITE_PATH.'get_tv_info_new.php?series_id='.$_POST['series_id'].'&auth_id='.$_POST['auth_id']); ?>
            <a class="close-reveal-modal">&#215;</a>
            
        </div>
        <?php
}
//End of update-series form-###############################################################################################


if(empty($_GET["id"])){
echo "Season id not provided.";
}else{
$season = new season($_GET["id"]);

}
?>
		<div class="row">
			<div class="eight columns">
				<div class="row">
					<div class="twelve columns">
						<a title="<?php echo $season->show->name; ?>" href="show.php?id=<?php echo $season->show->tvdb_series_id; ?>"><img src="<?php echo $season->show->getBanner(); ?>" /></a>
					</div>
				</div>
                            <div class="row">
                                <div class="two columns">
                                    <h4>Season</h4>    
                                </div>
                                <div class="ten columns">
                                    <?php echo $season->show->getSeasons($season->tvdb_season_id); ?>
                                </div>
                            </div>
				
				<br />
				
<?php
$season->getEpisodes($fgmembersite->CheckPremium());
?>
			</div>

			<div class="four columns">			
				<h4><?php echo $season->show->name; ?></h4>
				<p><?php echo nl2br($season->show->description); ?></p>

				<h4>Information</h4>
				<div class="row">
					<div class="four columns">
						<b>First Aired</b>
					</div>
					<div class="eight columns">
						<?php echo date('F j, Y', strtotime($season->date_aired)); ?>
					</div>
				</div>
				<div class="row">
					<div class="four columns">
						<b>Air Day</b>
					</div>
					<div class="eight columns">
						<?php echo $season->show->airs_dayofweek; ?>
					</div>
				</div>
				<div class="row">
					<div class="four columns">
						<b>Air Time</b> 
					</div>
					<div class="eight columns">
						<?php echo $season->show->airs_time; ?>
					</div>
				</div>
				<div class="row">
					<div class="four columns">
						<b>Runtime</b>	
					</div>
					<div class="eight columns">
						<?php echo $season->show->runtime." minutes"; ?>
					</div>
				</div>
				<div class="row">
					<div class="four columns">
						<b>Network</b>	
					</div>
					<div class="eight columns">
						<?php echo $season->show->network; ?>
					</div>
				</div>
                                <div class="row">
					<div class="four columns">
						<b>Rating</b>	
					</div>
					<div class="eight columns">
						<?php echo $season->show->content_rating; ?>
					</div>
				</div>
				<div class="row">
					<div class="four columns">
						<b>Genre</b>
					</div>
					<div class="eight columns">
						<?php echo $season->show->genre; ?>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="twelve columns">
						<div class="show-on-desktops"><a target="_blank" href="http://nullrefer.com/?http://www.imdb.com/title/<?php echo $season->show->imdb_id; ?>"><img src="images/imdb.png" width="50px" height="50px" /></a><a target="_blank" href="http://nullrefer.com/?http://thetvdb.com/?tab=series&id=<?php echo $season->show->tvdb_series_id; ?>"><img src="images/tvdb.png" width="50px" height="50px" /></a></div>
					</div>
				</div>
				<?php
				if($fgmembersite->CheckAdmin()){
				?>
				<br />
				<br />
                                <form name="seriesscript" method="post" class="nice">
                                    <input type="hidden" name="auth_id" value="<?php echo $fgmembersite->UserID(); ?>">
                                    <input type="hidden" name="series_id" value="<?php echo $season->show->tvdb_series_id; ?>">
                                    <input type="submit" value="Update Series" class="xsmall black nice button radius " name="update-series" />
                                            
                                </form>
				<?php
				}
				?>
			</div>
		</div>
	
	<?php 
	include TEMPLATE_PATH."/footer.php";
	?>
