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
		var $title;
		var $active;
		
		function __construct($id) {
			$this->id = $id;
			
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM users WHERE id=".$id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$this->username = $row['username'];
					$this->email = $row['email'];
					$this->displayname = $row['displayname'];
					$this->votes_up = $row['votes_up'];
					$this->votes_down = $row['votes_down'];
					$this->joinDate = $row['joinDate'];
					$this->lastDate = $row['lastDate'];
					$this->title = $row['title'];
					$this->active = $row['active'];
				}
			}
			//echo $res;
			// $this->username = $res['username'];
			// $this->email = $res['email'];
		}
		
		private function set_value($type, $value) {
			$this->$type = $value;
		}
		
		public function getAll() {
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM users;");
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
<tr><td width="200px">ID</td><td><?php echo $this->id; ?></td></tr>
<tr><td width="200px">Username</td><td><?php echo $this->username; ?></td></tr>
<tr><td width="200px">Email</td><td><?php echo $this->email; ?></td></tr>
<tr><td width="200px">Display Name</td><td><?php echo $this->displayname; ?></td></tr>
<tr><td width="200px">Rating</td><td><?php echo $this->votes_up."/".$this->votes_down; ?></td></tr>
<tr><td width="200px">Join Date</td><td><?php echo $this->joinDate; ?></td></tr>
<tr><td width="200px">Last Online</td><td><?php echo $this->lastDate; ?></td></tr>
<tr><td width="200px">Status</td><td><?php echo $this->active; ?></td></tr>
</table>
				
			<?php
		}
		
	}
	
	//$user = new user('1');
	
	//$user->set_value('name', 'Brian123 Artschwager');
	
	//echo $user->name;
	
	
?>
		