<?php
	class comment {
		var $id;
		var $user;
		var $message;
		var $date_added;
		var $date_modified;
		var $status;
		var $type;
		var $parent_id;
		
		function __construct($comment_id = 0) {
			
			
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM c_comment, c_status WHERE c_comment.id=".$comment_id." and c_comment.status_id=c_status.id;");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$this->id = $comment_id;
					$this->user = new user($row['user_id']);
					$this->message = $row['message'];
					$this->date_added = $row['date_added'];
					$this->date_modified = $row['date_modified'];
					$this->status = $row['status_id'];
					$this->type = $row['type'];
					$this->parent_id = $row['parent_id'];
				}
			}
		}

		public function view() {
			?>
			<div class="row">
				<div class="twelve columns">
					<div class="row">
						<div class="one column">
							<?php echo "#".$this->id; ?>
						</div>
						<div class="four columns">
							<p><a href="user.php?id=<?php echo $this->user->id; ?>"><?php echo ucfirst($this->user->displayname); ?></a></p>
						</div>
						<div class="three columns" style="display: table-cell; text-align: right;">
							<form method="post" class="none" style="margin-bottom: 0px; ">
							<input type="hidden" name="comment-id" value="<?php echo $this->id; ?>"/>
							<?php 
							if($_SESSION['id_of_user'] == $this->user->id or $_SESSION['status_of_user'] == 9) {
								if($this->status==1) {
									?>
										<!--<input type="submit" name="hide-comment" value="Hide" class="xsmall white nice button radius"/>-->
									<?php 
								} elseif($this->status==0) {
									?>
										<!--<input type="submit" name="show-comment" value="Show" class="xsmall orange nice button radius"/>-->
									<?php 
								}
							}
							if($this->get_report_count() == 2) {
								if($_SESSION['status_of_user'] == 9) {
								?>
									<!--<input type="submit" name="acknowledge-comment" value="Acknowledge" class="xsmall red nice button radius"/>-->
								<?php 
								}else{
								?>
									<!--<a class="xsmall red nice button radius" href="#">Reported</a>-->
								<?php 
								}
							} elseif($this->status == 1) {
								?>
									<!--<input type="submit" name="report-comment" value="Report" class="xsmall white nice button radius"/>-->
								<?php 
							}
							?>
							</form>
						</div>
						<div class="four columns">
							<p style="text-align: right; font-size: 10px; "><?php echo date('F j, Y, g:i a', strtotime(TIME_OFFSET, strtotime($this->date_added))); ?></p>
						</div>
					</div>
					<div class="row">
						<?php 
						if($this->status==0) {
							echo '<p style="color: #C0C0C0; ">This message has been hidden at the request of the user.';
						}elseif($this->status==2){
							echo '<p style="color: #C0C0C0; ">This message has been hidden at the request of the user.';
						}else {
							echo "<p>".nl2br(strip_tags($this->message, '<p><a><img><span>'))."</p>";
						} 
							
						?></p>
					</div>
				</div>
			</div>
			<hr style="margin-top: 6px; margin-bottom: 6px; "/>
			
			<?php
		}
		
		public function get_report_count() {
		
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM c_reported WHERE comment_id=".$this->id." and status_id=2;");
			return mysql_num_rows($res);
		}
		
		public function hide() {
			if($_SESSION['id_of_user'] == $this->user->id) {
				$dbstuff = new databee();
				$dbstuff->execute("UPDATE c_comment SET status_id = 0 WHERE id = ".$this->id);
			}
		}
		
		public function show() {
			if($_SESSION['id_of_user'] == $this->user->id) {
				$dbstuff = new databee();
				$dbstuff->execute("UPDATE c_comment SET status_id = 1 WHERE id = ".$this->id);
			}
		}
		
		public function add($message,$type_id,$parent_id) {
			$dbstuff = new databee();
			$dbstuff->execute("INSERT INTO c_comment (user_id, message, status_id, type, parent_id) VALUES ('".addSlashes($_SESSION['id_of_user'])."', '".addSlashes($message)."', '1', '".$type_id."', '".addSlashes($parent_id)."')");
                        $dbstuff->execute("UPDATE c_topic SET date_modified = '".date('y-m-d G:i:s')."' WHERE id='$parent_id'");
                        
			//$randomint = rand(1, 10);
                        //$randomint == 7 || 
			if(strpos(strtolower($message),'gordon') !== FALSE || strpos(strtolower($message),'ramsay') !== FALSE || strpos(strtolower($message),'kitchen') !== FALSE) {
				$dbstuff = new databee();
				$dbstuff->execute("INSERT INTO c_comment (user_id, message, status_id, type, parent_id) VALUES ('0', '".addSlashes($this->bot_gordon_post())."', '1', '".$type_id."', '".addSlashes($parent_id)."')");
			}elseif(strpos(strtolower($message),'house') !== FALSE || strpos(strtolower($message),'hospital') !== FALSE || strpos(strtolower($message),'life') !== FALSE){
				$dbstuff = new databee();
				$dbstuff->execute("INSERT INTO c_comment (user_id, message, status_id, type, parent_id) VALUES ('8', '".addSlashes($this->bot_house_post())."', '1', '".$type_id."', '".addSlashes($parent_id)."')");
			}
		}
		
		public function report() {
			$dbstuff = new databee();
			$dbstuff->execute("INSERT INTO c_reported (comment_id, user_id, status_id) VALUES ('".$this->id."', '".addSlashes($_SESSION['id_of_user'])."', '2')");
		}
		
		public function acknowledge() {
			if($_SESSION['status_of_user'] == 9) {
				$dbstuff = new databee();
				if($this->status == 2) {
					$dbstuff->execute("UPDATE c_reported SET status_id = 3 WHERE comment_id = ".$this->id);
				}
			}
		}
		
		public function bot_gordon_post() {
			$quote[0]="You couldn't run a bath let alone a kitchen!";
			$quote[1]="The place is so plastic. I would have felt more at home if I'd covered myself in clingfilm.";
			$quote[2]="What I suggest you do is buy a restuarant and put one table in it, anymore than that and you'd be fucked.";
			$quote[3]="This is supposed to be the most powerful nation, not the most pathetic.";
			$quote[4]="Everything I do has to be perfect, everything I cook has to be delicious! So, yeah, sometimes I freak out to people when they don't do the best they can.";
			$quote[5]="People have no idea about the pressure that's resting on my shoulders. If I would be baking hamburgers in a snack bar, I would be a very relaxed dude, but I'm on the top! When something goes wrong here, it really goes wrong, and there are a lot of people waiting for that to happen.";
			$quote[6]="I have a very assertive way. It's wake up, move your ass, or piss off home.";
			$quote[7]="I maintain standards and I strive for perfection. That level of pressure is conveyed in a very bullish way and that's what commenting is all about.";
			$quote[8]="What makes you think that anyone would be interested in reading that?";
			$quote[9]="I'm quite a chauvinistic person.";
			$quote[10]="Do you know how much time I wasted reading your comment?  None.";
			$quote[11]="The problem with Yanks is they are wimps.";
			
			return $quote[array_rand($quote)];
		
		}
		
		public function bot_house_post() {
			$quote[0]="Everybody lies.";
			$quote[1]="I've found that when you want to know the truth about someone that someone is probably the last person you should ask.";
			$quote[2]="All of those clever reasons were wrong.";
			$quote[3]="Reality is almost always wrong.";
			$quote[4]="...there's no I in 'team'. There is a me, though, if you jumble it up.";
			$quote[5]="Everybody does stupid things, it shouldn't cost them everything they want in life.";
			$quote[6]="It's been established that time is not a rigid construct.";
			$quote[7]="It's one of the great tragedies of life, something always changes.";
			$quote[8]="I was never that great at math, but next to nothing is higher than nothing, right?";
			$quote[9]="I am right, you are wrong.";
			$quote[10]="...the answer...to life itself: Sex.";
			
			
			return $quote[array_rand($quote)];
		
		}
	}
	
?>