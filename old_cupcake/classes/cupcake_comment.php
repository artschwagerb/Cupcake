<?php
	class cupcake_comment {
		var $id;
		var $publicationDate;
		var $content;
		var $user;
		var $active;
		
		function __construct($cup_id) {
			$this->id = $cup_id;
			
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM comments WHERE id=".$c_id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$this->publicationDate = $row['publicationDate'];
					$this->content = $row['content'];
					$this->user = new user($row['id']);
					$this->active = $row['active'];
				}
			}
		}
		
		private function set_value($type, $value) {
			$this->$type = $value;
		}
		
	}
	
?>