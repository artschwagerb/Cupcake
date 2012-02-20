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

$stats = new statistics();
?>
                <div class="row">
			<div class="eight columns">
                            <div class="row">
                                    <center>
                                    <h5>BETA - Everyone Gets Premium</h5>

                                    <?php if(!$fgmembersite->CheckPremium()) { ?>
                                            <br />
                                            <p class="alert-box warning">Your Account is Limited, Premium is Available...</p>
                                    <?php } ?>
                                    <br />
                                    <img src="http://i.imgur.com/4iLu2.jpg" />
                                    </center>
                            </div>
			
			</div>

			<div class="four columns">
                            <div class="row">
                                <div id="featured" style="width: 568px; text-align: right;"> 
                                    <?php 
                                    $show = new show(0);
                                    $show->getAllBanners("RAND()"); 

                                    ?>
                                </div>
                            </div>
                            <br />

				<?php echo $stats->get_newsfeed_summary(24); ?>
			</div>
		</div>

	
	<?php 
	include TEMPLATE_PATH."/footer.php";
	?>
