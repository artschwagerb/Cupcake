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
<!-- Modal Popups -->
<div id="buypremium" class="reveal-modal">
     <h2>Premium</h2>
     <p class="lead">You are being a mooch, you should donate some money.</p>
     
     <p>Websites don't run off hopes and dreams, well dreams sort of... but money, yeah money.</p>
     <img src="images/funny/jackie-chan-whut.jpg" /><br />
     <a class="close-reveal-modal">&#215;</a>
</div>
<div id="newdomain" class="reveal-modal">
     <h2>New Domain</h2>
     <p class="lead"><a href="http://www.cupcakesfor.me">cupcakesfor.me</a></p>
     
     <p>Please update your bookmarks... and thanks for putting up with the long address.</p>
	 <img src="http://i.imgur.com/8KwUy.jpg" /><br />
     <a class="close-reveal-modal">&#215;</a>
</div>
<!-- End of Modal Popups -->

<div class="row">
    <div class="seven columns">
        <div class="row">
            
            <?php 
            if(!$fgmembersite->CheckPremium()) { 
                //User isnt premium, show modal popup
                echo "<script type='text/javascript'> $(document).ready(function() { $('#buypremium').reveal(); }); </script>"; 
            ?>
                <br />
            <center>
                <div class="alert-box error">Your Account is Limited, Premium is Available...
                <a href="" class="close">&times;</a>
                </div>
                <br /> 
            </center>
            <?php 
            } 
            //Check for Old Domain
            $pos = strpos($_SERVER['HTTP_HOST'], "feralhosting.com");
            if($pos === false) {
                //The server name doesnt contain feralhosting.com , Do nothing
            } else {
                //Found the server name, show modal popup
                echo "<script type='text/javascript'> $(document).ready(function() { $('#newdomain').reveal(); }); </script>";
            }
            
            $page = new page(1);
            echo $page->body;
            
            ?>
            
        </div>
    </div>

        <div class="five columns">
            <dl class="tabs contained">
                <dd><a href="#feed" class="active">Activity</a></dd>
                <dd><a href="#showupdates">Updated Shows</a></dd>
            </dl>
            <ul class="tabs-content contained">
                <li class="active" id="feedTab">
                    <?php echo $stats->get_newsfeed_summary(72); ?>
                </li>
                <li id="showupdatesTab">
                        <?php 
                        $show = new show(0);
                        $show->getAllBanners("date_added"," DESC LIMIT 5"); 
                        ?>
                </li>

            </ul>	
        </div>
</div>

	
	<?php 
	include TEMPLATE_PATH."/footer.php";
	?>
