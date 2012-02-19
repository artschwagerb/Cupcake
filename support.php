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

if(empty($_GET["prevpage"])){
$prevpage = 'not provided';
}else{
$prevpage = $_GET["prevpage"];
}
?>
		<div class="row">
			<div class="eight columns">
				<div class="row">
					<div class="twelve columns">
					<h4>Browser Compatibility</h4>	
					<p>As of right now the site works awesome in Chrome, everything else is an interesting struggle...</p>
					<ul>
					<li>Firefox doesnt support HTML5 mp4's</li>
					<li>Internet Explorer just plain sucks...</li>
					</ul>
					</div>
				</div>
			</div>

			<div class="four columns">			
				<form>
					<fieldset>
						<h5>Report a Problem</h5>
						<p>Is something just not quite right?</p>
						<input type="hidden" value="<?php echo $prevpage; ?>">
						
						<label>Problem</label>
									<select>
									  <option SELECTED>Incorrect Information</option>
									  <option>Dead Link</option>
									  <option>Video Broken</option>
									  <option>Page Looks Funny</option>
									  <option>Other</option>
									</select>
								<label>Comment</label>
								<input type="text" class="input-text">
								<input type="submit" value="Submit" />
								
					</fieldset>
				</form>
			</div>
		</div>
		
	<?php 
	include TEMPLATE_PATH."/footer.php";
	?>