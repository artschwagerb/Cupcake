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

if (!empty($_POST['create-topic'])) {
        $topictochange = new topic();
	$topictochange->add($_POST['topicname'],$_POST['topicmessage']);
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=topic.php?id='.$topictochange->id.'">';
}

if (!empty($_POST['comment-topic'])) {
        $commenttochange = new comment();
	$commenttochange->add($_POST['comment-message'],3,$_POST['topic_id']);
        //echo '<META HTTP-EQUIV="Refresh" Content="0; URL=topic.php?id='.$topictochange->id.'">';
}

if (!empty($_POST['hide-comment'])) {
	$commenttochange = new comment($_POST['comment-id']);
	$commenttochange->hide();
	
}
if (!empty($_POST['adminhide-comment'])) {
	$commenttochange = new comment($_POST['comment-id']);
	$commenttochange->admin_hide();
	
}
if (!empty($_POST['adminshow-comment'])) {
	$commenttochange = new comment($_POST['comment-id']);
	$commenttochange->admin_show();
	
}
if (!empty($_POST['show-comment'])) {
	$commenttochange = new comment($_POST['comment-id']);
	$commenttochange->show();
	
}
if (!empty($_POST['report-comment'])) {
	$commenttochange = new comment($_POST['comment-id']);
	$commenttochange->report();
	
}
if (!empty($_POST['acknowledge-comment'])) {
	$commenttochange = new comment($_POST['comment-id']);
	$commenttochange->acknowledge();
	
}
if (!empty($_POST['report-problem'])) {
	$commenttochange = new comment();
	$commenttochange->add($_POST['problem']."     ---     ".$_POST['comment'],1,$episode->tvdb_episode_id);
	
}
//--------------------


if(empty($_GET["id"])){
    if(empty($_GET["page"])){
        $firsttopic = 0;
        $page = 0;
    }else{
        $firsttopic = $_GET['page']*10;
        $page = $_GET['page'];
    }
$topic = new topic(0);
?>

	<div class="row">
		<div class="eight columns">
                    <div class="row">
                    <?php echo $topic->getAllTopics($firsttopic); ?>
                    </div>
                    <div class="row">
                    <?php echo $topic->getPages($page); ?>
                    </div>
		</div>
                
		<div class="four columns">
			<form name="create_topic" method="post" class="nice">
			<fieldset>
                            <h5>Create a Discussion</h5>
                            <p>Whats on your Mind?</p>

                            <label>Topic</label>
                            <input type="text" name="topicname" class="input-text">
                            <label>Message</label>
                            <textarea name="topicmessage" class="input-text"></textarea>
                            <input type="submit" name="create-topic" value="Submit" />

                        </fieldset>
			</form>
		</div>
	</div>

<?php
}else{
$topic = new topic(addslashes($_GET["id"]));
?>
<script type="text/javascript">
	$(document).ready(function() {
		$(".thumb").thumbs();
	});
</script>
<div class="row">
			<div class="twelve columns">
                                <ul class="breadcrumbs">
                                    <li><a href="topic.php">Discussions</a></li>
                                    <li class="current"><a href="#"><?php echo $topic->name; ?></a></li>
                                </ul>
                            <div class="row">
                                <div class="twelve columns">
                                            <h5><?php echo $topic->name; ?></h5>
                                </div>
                            </div>
                            <hr style="margin-top: 4px; margin-bottom: 4px;"/>
                            <div class="row">
                                <div class="twelve columns">
                                        <?php echo $topic->getComments(); ?>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                
                            <dl class="tabs contained">
                                <dd><a href="#comment" class="active">New Comment</a></dd>
                                <dd><a href="#codesnippets">Code Snippets</a></dd>
                            </dl>
                            <ul class="tabs-content contained">
                                <li class="active" id="commentTab">
                                    <form name="comment_topic" method="post" class="nice">
					<fieldset>
                                                <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>" />

                                                <label>Comment</label>
                                                <textarea name="comment-message" class="input-text" style="width:100%; background:none;"></textarea>
                                                <input type="submit" name="comment-topic"  value="Submit" />
								
					</fieldset>
                                    </form>
                                </li>
                                <li id="codesnippetsTab">
                                    <script type="text/javascript" src="http://snipt.net/embed/a631dae255a19a7dad37987d234f3766"></script>
                                </li>
                                
                            </ul>    
                                
                                
                                
                            </div>
			</div>
</div>
<?php

}
?>
		

	<?php 
	include TEMPLATE_PATH."/footer.php";
	?>
