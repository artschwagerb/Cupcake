<!DOCTYPE html>
<?php

require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
if(!$fgmembersite->CheckPremium())
{
	echo "You are not a premium user... why am I even talking to you?";
	exit;
}

include "config.php";
include TEMPLATE_PATH."/header.php";





if(empty($_GET["id"])){
$movie = new movie(0);
?>

	<div class="row">
		<div class="eight columns">
		<?php $movie->getAllPosters(); ?>
		</div>
		<div class="four columns">			
			<form>
				<fieldset>
					<h5>Request a Movie</h5>
					<p>What movie is just too amazing to miss?</p>

					<label>Movie Name</label>
					<input type="text" class="input-text"><input type="submit" value="Submit" />
							
				</fieldset>
			</form>
		</div>
	</div>

<?php
}else{
$movie = new movie($_GET["id"]);
//$movie->view();
?>
<div class="row">
			<div class="eight columns">
				<div class="row">
					<h4><a href="movie.php?id=<?php echo $movie->id; ?>"><?php echo $movie->name;?></a></h4>
				</div>
				<div class="row">
					<div class="twelve columns">
						  <div class="video-js-box vim-css">
							<video class="video-js" width="480" height="270" controls preload>
							  <source src="<?php echo $movie->filename;?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' />
								<!-- Image Fallback. Typically the same as the poster image. -->
								<!--<img src="<?php echo "images/cupcakes_play.png" ?>" width="480" height="270" alt="Poster Image" title="No video playback capabilities." />-->
							  </object>
							</video>
						</div>
					</div>
				</div>
			</div>
			<div class="four columns">			
				<form>
					<fieldset>
						<h5>Report a Problem</h5>
						<p>Whats wrong with <?php echo $movie->name; ?>?</p>

						<label>Problem</label>
									<select>
									  <option SELECTED>Incorrect Video</option>
									  <option>Poor Quality</option>
									  <option>Incorrect Information</option>
									  <option>Doesn't Play</option>
									</select>
								<label>Comment</label>
								<input type="text" class="input-text">
								<input type="submit" value="Submit" />
								
					</fieldset>
				</form>
			</div>
</div>

<?php

}
?>
		

	<?php 
	include TEMPLATE_PATH."/footer.php";
	?>
