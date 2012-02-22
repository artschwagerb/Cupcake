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

if (!empty($_POST['add-user'])) {
        $admin = new admin();
        $result = $admin->addUser();
        ?>
        <script type='text/javascript'> $(document).ready(function() { $('#add_User_Modal').reveal(); }); </script>
        <div id="add_User_Modal" class="reveal-modal">
            <?php if($result > 0){ 
            //Created User       
            ?>
            <h2>User Created</h2>
            <p class="lead">Just thought I would let you know...</p>
            <p>I went ahead and created that user for you.</p>
                
            <?php 
            $user = new user($result);
            echo $user->view(); 
            
            }else{ 
            //Problem Creating User    
            ?>
            <h2>User Creation Failed</h2>
            <p class="lead">Just thought I would let you know...</p>
            <p>There was a problem creating that user for you.</p>
            
            <a class="close-reveal-modal">&#215;</a>
            <?php } ?>
        </div>
        <?php
	//$dbstuff->execute("UPDATE c_comment SET status = 0 WHERE id = ".$_POST['comment-id']." and parent_id = ".$episode->tvdb_episode_id);
   //do something here;
}

$stats = new statistics();

?>
		<div class="row">
			<div class="twelve columns">
				<div class="row">
				<dl class="nice contained tabs">
					<dd><a href="#activity" class="active">Activity</a></dd>
					<dd><a href="#database">Database</a></dd>
					<dd><a href="#moderation">Moderation</a></dd>
                                        <dd><a href="#users">Users</a></dd>
				</dl>
				<ul class="nice tabs-content contained">
				<li class="active" id="activityTab">
						<?php echo $stats->get_shows_watched_summary(24); ?>
                                                <?php echo $stats->get_movies_watched_summary(24); ?>
						<?php echo $stats->get_newsfeed(24); ?>
				</li>
				<li id="databaseTab">
                                    <fieldset>
					<form name="seriesscript" action="get_tv_info.php" method="get" class="nice">
                                            
							<h5>Add/Update a Series</h5>
							<p>Wish you could type less and get more?</p>
							<input type="hidden" name="authid" value="<?php echo $fgmembersite->UserID(); ?>">
						
							<label>Series ID</label>
							<input type="text" name="id" class="input-text">
							<input type="submit" value="Submit" />
                                            
					</form>
                                   </fieldset>
                                   <hr />
					<?php echo $stats->get_shows(); ?>
				</li>
				<li id="moderationTab">
					<?php echo $stats->get_requests(); ?>
                                        <?php echo $stats->get_episode_problems(); ?>
				</li>
                                <li id="usersTab">
                                    <div class="row">
                                        <div class="eleven columns">
                                                <h6>Add a User</h6>
                                        </div>
                                        <div class="one column">
                                                <p><a class="xsmall white nice button radius" href="javascript:;" onmousedown="toggleDiv('add_user',this);">v</a></p>
                                        </div>
                                    </div>
					<div id="add_user" style="display: none; " class="row">
                                            <div class="panel">
                                                <form name="seriesscript" method="post" class="nice">

                                                    <h5>Add User</h5>
                                                    <p>Need to create a new user?</p>
                                                    <input type="hidden" name="authid" value="<?php echo $fgmembersite->UserID(); ?>">
                                                    <div class="row">
                                                    <div class="six columns">

                                                            <label>Name</label>
                                                            <input type="text" name="user-name" maxlength="128" class="input-text">
                                                            <label>Email</label>
                                                            <input type="text" name="user-email" maxlength="64" class="input-text">
                                                            <label>Display Name</label>
                                                            <input type="text" name="user-displayname" maxlength="32" class="input-text">

                                                    </div>
                                                    <div class="six columns">    

                                                            <label>Username</label>
                                                            <input type="text" name="user-username" maxlength="16" class="input-text">
                                                            <label>Password</label>
                                                            <input type="text" name="user-password" maxlength="32" class="input-text">
                                                            <label>Premium Until</label>
                                                            <input type="text" name="user-premium_ex_date" class="input-text" value="<?php echo date('y/m/d G:i:s',strtotime('+1 week')); ?>">

                                                    </div>
                                                    </div>
                                                    <div class="row">

                                                            <label for="customDropdown">User Level</label>
                                                            <input type="radio" name="user-status_id" value="0" /> Banned  
                                                            <input type="radio" name="user-status_id" value="1" /> Normal  
                                                            <input type="radio" name="user-status_id" value="5" /> Lifetime Premium  
                                                            <input type="radio" name="user-status_id" value="9" /> Administrator  

                                                    </div>
                                                    <br />
                                                    <input type="submit" value="Submit" name="add-user" />

                                                </form>
                                            </div>
                                        </div>
                                    <?php echo $stats->get_users_active(24); ?>
				</li>
				</ul>
				</div>
			</div>
		</div>
		
	<?php 
	include TEMPLATE_PATH."/footer.php";
	?>