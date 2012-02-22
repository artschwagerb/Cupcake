<?php
	class user {
		var $id;
		var $username;
		var $email;
		var $displayname;
		var $votes_up;
		var $votes_down;
		var $joinDate;
		var $lastDate;
		var $status_id;
		var $last_ip;
		var $premium_ex_date;

		function __construct($id) {
			$this->id = $id;
			
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM u_user WHERE id=".$id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$this->username = $row['username'];
					$this->email = $row['email'];
					$this->displayname = $row['displayname'];
					$this->joinDate = $row['joinDate'];
					$this->lastDate = $row['lastDate'];
					$this->status_id = $row['status_id'];
					$this->last_ip = $row['last_ip'];
					$this->premium_ex_date = $row['premium_ex_date'];
                                        $this->post_count = $this->getPostCount();
				}
			}
			//echo $res;
			// $this->username = $res['username'];
			// $this->email = $res['email'];
		}
		
		private function set_value($type, $value) {
			$this->$type = $value;
		}
		
		function CheckPremium()
		{
			$exp_date = date($this->premium_ex_date);
			$todays_date = date("Y-m-d H:i:s");

			if (strtotime($exp_date) > strtotime($todays_date)) {
				 return true;
			} else {
				if ($this->status_id>=5) {
					return true;
				} else {
					return false;
				}
			}
		}
		
		function get_activity() {
		$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM u_activity WHERE user_id = $this->id ORDER BY date_of_play DESC LIMIT 20;");
			?>
			<div class="row">
                            <div class="eight columns">
                                <b>Video</b>
                            </div>
                            <div class="four columns">
                                <b>Date</b>
                            </div>
			</div>
			<br />
			<?php
			if(mysql_num_rows($res) != 0){
                            while($row = mysql_fetch_assoc($res)) {
                                if($row['type_id']==1){
                                    $episode = new episode($row['parent_id']);
                                ?>
                                        <div class="row">
                                                <div class="four columns">
                                                        <a href="show.php?id=<?php echo $episode->show->tvdb_series_id; ?>"><?php echo $episode->show->name; ?></a>
                                                </div>
                                                <div class="four columns">
                                                        <a href="player.php?id=<?php echo $episode->tvdb_episode_id; ?>"><?php echo $episode->name; ?></a>
                                                </div>
                                                <div class="four columns">
                                                        <?php echo date('F j, Y, g:i a', strtotime(TIME_OFFSET, strtotime($row['date_of_play']))); ?>
                                                </div>
                                        </div>
                                        <hr style="margin-top: 4px; margin-bottom: 4px;"/>
                                <?php
                                }elseif($row['type_id']==2){
                                    $movie = new movie($row['parent_id']);
                                ?>
                                        <div class="row">
                                                <div class="eight columns">
                                                        <a href="movie.php?id=<?php echo $movie->id; ?>"><?php echo $movie->name; ?></a>
                                                </div>
                                                <div class="four columns">
                                                        <?php echo date('F j, Y, g:i a', strtotime(TIME_OFFSET, strtotime($row['date_of_play']))); ?>
                                                </div>
                                        </div>
                                        <hr style="margin-top: 4px; margin-bottom: 4px;"/>
                                <?php    
                                }
                            }
			}
			?>
			<?php
	}
		
		public function getAll() {
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM u_user;");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$user = new user($row['id']);
					$users[] = $user;
				}
				
			}
			?><ul id="headlines"><?php
			foreach ( $users as $user ) {
				?>
				<a href="user.php?id=<?php echo $user->id; ?>"><?php echo $user->username; ?></a>
				<?php
			}
			?></ul><?php
		}
		
		public function view() {
			?>
			<table border="0">
			<tr><td width="200px">Username</td><td><?php echo $this->displayname; ?></td></tr>
			<tr><td width="200px">Join Date</td><td><?php echo date('F j, Y, g:i a', strtotime(TIME_OFFSET, strtotime($this->joinDate))); ?></td></tr>
			<tr><td width="200px">Last Login</td><td>
                        <?php 
                        if(date('F j, Y, g:i a', strtotime(TIME_OFFSET, strtotime($this->lastDate))) == "December 31, 1969, 4:00 pm") { 
                            echo "Never Logged In."; 
                        }else{ 
                            echo date('F j, Y, g:i a', strtotime(TIME_OFFSET, strtotime($this->lastDate))); } 
                        ?>
                        </td></tr>
			<tr><td width="200px">Premium Until</td><td>
			<?php 
			if($this->CheckPremium()==true){
			echo date('F j, Y, g:i a', strtotime(TIME_OFFSET, strtotime($this->premium_ex_date)));
			}else{
			echo 'Expired';
			} 
			?>
			</td></tr>
                        <tr><td width="200px">Comments</td><td><?php echo $this->post_count; ?></td></tr>
			</table>
				
			<?php
		}
                
                function getPostCount(){
                    $dbstuff = new databee();
			$res = $dbstuff->query("SELECT id FROM c_comment WHERE user_id=$this->id;");
			return mysql_num_rows($res);
				
                }


		/* public function getStatusTitle() {
		switch ($this->active) {
			case 0:
				return "banned";
				break;
			case 1:
				return "user";
				break;
			case 2:
				echo "autistic";
				break;
			case 3:
				echo "autistic";
				break;
			case 4:
				echo "autistic";
				break;
			case 5:
				echo "premium user";
				break;
			case 6:
				echo "autistic";
				break;
			case 7:
				echo "autistic";
				break;
			case 8:
				return "moderator";
				break;	
			case 9:
				return "admin";
				break;
			default:
				echo "autistic";
		}
		} */
		
	}
	
	//$user = new user('1');
	
	//$user->set_value('name', 'Brian123 Artschwager');
	
	//echo $user->name;
	
?>
		