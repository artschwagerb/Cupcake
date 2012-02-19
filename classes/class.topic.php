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
		
		function __construct($topic_id) {
			
			
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM topic WHERE id=".$topic_id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$this->id = $comment_id;
					$this->user = new user($row['user_id']);
					$this->name = $row['name'];
					$this->message = $row['message'];
					$this->date_added = $row['date_added'];
					$this->date_modified = $row['date_modified'];
					$this->status = $row['status'];
					$this->type = $row['type'];
				}
			}
		}

		public function view() {
			?>
			<div class="row">
				<div class="eleven columns">
					<div class="row">
						<div class="six columns">
							<p><a href="user.php?id=<?php echo $this->user->id; ?>"><?php echo ucfirst($this->user->displayname); ?></a></p>
						</div>
						<div class="five columns">
							<p style="text-align: right; font-size: 10px; "><?php echo date('F j, Y, g:i a', strtotime($this->date_added)); ?></p>
						</div>
					</div>
					<div class="row">
						<?php if($this->status==0) {echo '<p style="color: #C0C0C0; ">This message has been deleted at the request of the user.';}else{echo "<p>".nl2br($this->message)."</p>";} ?></p>
					</div>
				</div>

				<div class="one columns" style="text-align: right; display: block; ">
					<div class="row">
					<a class="xsmall white nice button radius" href="#">Report</a>
					</div>
					<?php 

					if($_SESSION['id_of_user'] == $this->user->id or $_SESSION['status_of_user'] == 9) {
						if($this->status==1) {
							?>
								<div class="row">
								<form name="delete_comment" method="post" class="nice">
								<input type="submit" name="delete-comment" value="Delete" class="xsmall red nice button radius"/>
								</form>
								</div>
							<?php 
						} 
					} else {
						?>
							<div class="row">
							<form name="delete_comment" method="post" class="nice">
							<input type="submit" name="delete-comment" value="Un-Delete" class="xsmall red nice button radius"/>
							</form>
							</div>
						<?php 
						
					}
					?>
				</div>
			</div>
			<hr />	
			<?php
		}
		
		public function getComments() {
			$dbstuff = new databee();

			$res = $dbstuff->query("SELECT id FROM topic WHERE id=".$this->id." ORDER BY date_added;");

			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$comment = new comment($row['id']);
				
					$comment->view();
			
				}

			}
			?><div class="thinline"></div><?php
		}		
		
	}
	
?>