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
                                                    <p style="text-align: right; font-size: 10px; margin-bottom: 0px;"><?php echo date('F j, Y, g:i a', strtotime(TIME_OFFSET, strtotime($this->last_post->date_added))); ?></p>
                                            </div>
					</div>
				</div>
			</div>
			<hr style="margin-top: 4px; margin-bottom: 4px;"/>
			<?php
		}
                
                public function getAllTopics() {
                $dbstuff = new databee();

                    $res = $dbstuff->query("SELECT t.id, c.date_added FROM c_topic as t, c_comment as c WHERE t.status=1 AND t.id=c.parent_id GROUP BY t.id ORDER BY c.date_added ASC;");
                    if(mysql_num_rows($res) != 0){
                        while($row = mysql_fetch_assoc($res)) {
                            
                            $topic = new topic($row['id']);
                            $topic->view();
                        }
                    }
                    
                    
                }
		
		public function getComments() {
			$dbstuff = new databee();

			$res = $dbstuff->query("SELECT id FROM c_comment WHERE parent_id=".$this->id." AND type=3 and status_id=1 ORDER BY date_added;");

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
			$dbstuff->execute("INSERT INTO c_topic (name, user_id, status) VALUES ('".addSlashes($name)."', '".addSlashes($_SESSION['id_of_user'])."', '1')");
                        $res = $dbstuff->query("SELECT id FROM c_topic WHERE name='".addSlashes($name)."' AND user_id='".addSlashes($_SESSION['id_of_user'])."' ORDER BY date_created LIMIT 1;");

			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
                                    $dbstuff->execute("INSERT INTO c_comment (user_id, message, status_id, type, parent_id) VALUES ('".addSlashes($_SESSION['id_of_user'])."', '".addSlashes($message)."', '1', '3', '".addSlashes($row['id'])."')");
                                
                                    $this->id = $row['id'];
                                }
                
                        }        
                }
                
                function get_Comment_Count(){
                    $dbstuff = new databee();
                    $res = $dbstuff->query("SELECT id FROM c_comment WHERE parent_id=".$this->id." AND type=3 and status_id=1 ORDER BY date_added;");
                    return mysql_num_rows($res);
                }
                
                public function get_Last_Post() {
			$dbstuff = new databee();

			$res = $dbstuff->query("SELECT id FROM c_comment WHERE parent_id=".$this->id." AND type=3 and status_id=1 ORDER BY date_added DESC LIMIT 1;");

			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					return $comment = new comment($row['id']);
				}

			}
			
		}
                
		
	}
	
?>