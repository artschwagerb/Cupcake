<?php
	class topic {
		var $id;
		var $user;
		var $name;
		var $message;
		var $date_added;
		var $date_modified;
		var $status;
		var $type;
                var $post_count;
                var $last_post;
		
		function __construct($topic_id = 0) {
			
			
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM c_topic WHERE id=".$topic_id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$this->id = $topic_id;
					$this->user = new user($row['user_id']);
					$this->name = $row['name'];
					$this->date_created = $row['date_created'];
                                        $this->date_modified = $row['date_modified'];
					$this->status = $row['status'];
                                        $this->post_count = $this->get_Comment_Count();
                                        $this->last_post = $this->get_Last_Post();
				}
			}
		}

		public function view() {
			?>
			<div class="row">
				<div class="twelve columns">
					<div class="row">
                                            <div class="eight columns">
						<?php echo '<h5><a href=topic.php?id='.$this->id.'>'.addSlashes($this->name).'</a></h5>'; ?>
                                            </div>
                                            <div class="two columns">
                                                <?php echo '<p style="text-align: right; font-size: 10px; margin-bottom: 0px;">Posts: '.addSlashes($this->post_count).'</p>'; ?>
                                            </div>
					</div>
                                        <div class="row">
                                            <div class="eight columns">
                                                    <p style="text-align: left; font-size: 10px; margin-bottom: 0px;"><a class="clean" href="user.php?id=<?php echo $this->last_post->user->id; ?>"><?php echo ucfirst($this->last_post->user->displayname); ?></a></p>
                                            </div>
                                            <div class="four columns">
                                                    <p style="text-align: right; font-size: 10px; margin-bottom: 0px;"><?php echo date('F j, Y, g:i a', strtotime(TIME_OFFSET, strtotime($this->date_modified))); ?></p>
                                            </div>
					</div>
				</div>
			</div>
			<hr style="margin-top: 4px; margin-bottom: 4px;"/>
			<?php
		}
                
                public function getAllTopics($firsttopic = 0) {
                $dbstuff = new databee();

                    //$res = $dbstuff->query("select id, date_created, (select max(date_added) from c_comment where parent_id = t.id ) as moddate  from c_topic t where id in (Select parent_id From c_comment GROUP BY parent_id) order by (select max(date_added) from c_comment where parent_id = t.id ) DESC");
                    $res = $dbstuff->query("select id from c_topic WHERE status=1 ORDER BY date_modified DESC LIMIT ".$firsttopic.", 10;");
                    if(mysql_num_rows($res) != 0){
                        while($row = mysql_fetch_assoc($res)) {
                            
                            $topic = new topic($row['id']);
                            $topic->view();
                        }
                    }
                    
                    
                }
                
                public function getPages($currentpage = 0) {
                $dbstuff = new databee();

                    //$res = $dbstuff->query("select id, date_created, (select max(date_added) from c_comment where parent_id = t.id ) as moddate  from c_topic t where id in (Select parent_id From c_comment GROUP BY parent_id) order by (select max(date_added) from c_comment where parent_id = t.id ) DESC");
                    $res = $dbstuff->query("select id from c_topic ORDER BY date_modified DESC;");
                    if(mysql_num_rows($res) != 0){
                        ?>
                        <div class="row">
                            <div class="six columns centered">
                                <ul class="pagination">
                                    
                                    <li class="unavailable"><a href="<?php if($currentpage == 0){ echo '#'; }else{ echo 'topic.php?page='.($currentpage-1);} ?>">&laquo;</a></li>
                        <?php
                        for ($i=0; $i<=((mysql_num_rows($res)/10)-1); $i++) { 
                            
                            if($i == $currentpage){
                            echo "<li class='current'><a href='?page=".$i."'>".$i."</a></li>";
                            }else{
                            echo "<li><a href='?page=".$i."'>".$i."</a></li>";
                            }
                        }; 
                        ?>
                                    <li><a href="<?php if($currentpage == mysql_num_rows($res)/10){ echo '#'; }else{ echo 'topic.php?page='.($currentpage+1);} ?>">&raquo;</a></li>
                                </ul>    
                            </div>
                        </div>            
                        <?php                    
                    }
                }
		
		public function getComments() {
			$dbstuff = new databee();

			$res = $dbstuff->query("SELECT id FROM c_comment WHERE parent_id=".$this->id." AND type=3 ORDER BY date_added;");

			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$comment = new comment($row['id']);
				
					$comment->view();
			
				}

			}
			?><div class="thinline"></div><?php
		}
                
                public function add($name,$message) {
					$dbstuff = new databee();
					$dbstuff->execute("INSERT INTO c_topic (name, user_id, status, date_modified) VALUES ('".addSlashes($name)."', '".addSlashes($_SESSION['id_of_user'])."', '1', '".date('y-m-d G:i:s')."')");
                    $dbstuff->execute("INSERT INTO c_comment (user_id, message, status_id, type, parent_id) VALUES ('".addSlashes($_SESSION['id_of_user'])."', '".addSlashes($message)."', '1', '3', '".mysql_insert_id()."')");
                }
                
                function get_Comment_Count() {
                    $dbstuff = new databee();
                    $res = $dbstuff->query("SELECT id FROM c_comment WHERE parent_id=".$this->id." AND type=3 AND status_id=1 ORDER BY date_added;");
                    return mysql_num_rows($res);
                }
                
                public function get_Last_Post() {
			$dbstuff = new databee();

			$res = $dbstuff->query("SELECT id FROM c_comment WHERE parent_id=".$this->id." AND type=3 AND status_id=1 ORDER BY date_added DESC LIMIT 1;");

			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					return $comment = new comment($row['id']);
				}

			}
			
		}
                
                public function log_View() {
		//	$dbstuff = new databee();
		//	$res = $dbstuff->query("SELECT * FROM u_activity WHERE parent_id='".$this->id."' and type_id='0' and DATE(date_of_play) = CURDATE() and user_id ='".$_SESSION['id_of_user']."';");
		//	if(mysql_num_rows($res) == 0){
		//		//Only log a view if they dont already have a play of this episode today
		//		$dbstuff->execute("INSERT INTO u_activity (parent_id, user_id, type_id) VALUES ('".$this->id."', '".$_SESSION['id_of_user']."', '0')");
		//	}
		
		}
                
		
	}
	
?>