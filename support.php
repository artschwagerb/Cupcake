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
					<h4>Browser Compatibility</h4>	
					<p>As of right now the site works awesome in Chrome, everything else is an interesting struggle...</p>
					<ul class="nice">
                                            <span class="green label">Google Chrome</span>
                                            <li>Everything works great, USE IT.</li>
                                            <span class="red label">Firefox</span>
                                            <li>Videos(mp4) are not supported.</li>
                                            <span class="blue label">Internet Explorer</span>
                                            <li>seems to work, but I don't recommend it.</li>
					</ul>
				</div>
                                <div class="row">
					<h4>Rules</h4>	
					<p>Don't be an asshat, I will ban...</p>
					<ul class="nice">
                                            <li>No Spamming.</li>
                                            <li><p>Keep things safe for work, if they are not... wrap them in <span class="spoiler">Spoiler Tags</span>.</p></li>
                                            <li>Don't make my life difficult, if you are being malicious or breaking things... you will be banned.</li>
					</ul>
				</div>
                                <div class="row">
                                    <h4>How to use Spoiler Tags</h4>
                                    <p>Create spoilers using the code example below.</p>
                                    <img src="images/support/spoiler-code.PNG" />
                                    <p>This is how they will look on the page, just click the spoiler to display it.</p>
                                    <img src="images/support/spoiler-view.PNG" />
                                </div>
                                <div class="row">
                                    <h4>Good Luck, Have Fun...</h4>
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