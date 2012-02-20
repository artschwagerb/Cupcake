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

if(empty($_GET["id"])){
$topic = new topic(0);
?>

	<div class="row">
		<div class="eight columns">
                    <div class="row">
                    <?php echo $topic->getAllTopics(); ?>
                    </div>
                    <div class="row">
                        <div class="six columns centered">
                            <ul class="pagination">
                                <li class="unavailable"><a href="">&laquo;</a></li>
                                <li class="current"><a href="">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li class="unavailable"><a href="#123">&hellip;</a></li>
                                <li><a href="#">12</a></li>
                                <li><a href="#">13</a></li>
                                <li><a href="#">&raquo;</a></li>
                            </ul>    
                        </div>
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
<div class="row">
			<div class="twelve columns">
                            <div class="row">
                                <div class="twelve columns">
                                            <p><a href="topic.php">Discussions</a> &raquo; <?php echo $topic->name; ?></p>
                                </div>
                            </div>
                            
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
                                <form name="comment_topic" method="post" class="nice">
					<fieldset>
                                                <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>" />

                                                <label>Comment</label>
                                                <textarea name="comment-message" class="input-text" style="width:100%; background:none;"></textarea>
                                                <input type="submit" name="comment-topic"  value="Submit" />
								
					</fieldset>
				</form>
                            </div>
			</div>
</div>
<?php

}
?>
		

	<?php 
	include TEMPLATE_PATH."/footer.php";
	?>
