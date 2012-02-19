<?php
	class cupcake {
		var $id;
		var $publicationDate;
		var $title;
		var $summary;
		var $content;
		var $user;
		var $tag;
		var $hits;
		var $active;
		
		function __construct() {
			
		}
		
		function get($cup_id) {
		$this->id = $cup_id;
			
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM cupcakes WHERE id=".$cup_id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$this->publicationDate = $row['publicationDate'];
					$this->title = $row['title'];
					$this->summary = $row['summary'];
					$this->content = $row['content'];
					$this->user = new user($row['id']);
					$this->active = $row['active'];
					$this->tag = $row['tag'];
					$this->hits = $row['hits'];
				}
			}
			//echo $res;
			// $this->username = $res['username'];
			// $this->email = $res['email'];
		}
		
		// public function getAll() {
			// $dbstuff = new databee();
			// $res = $dbstuff->query("SELECT * FROM cupcakes;");
			// if(mysql_num_rows($res) != 0){
				// while($row = mysql_fetch_assoc($res)) {
					// $cupcake = new cupcake(1);
					// $cupcake->publicationDate = $row['publicationDate'];
					// $cupcake->title = $row['title'];
					// $cupcake->summary = $row['summary'];
					// $cupcake->content = $row['content'];
					// $cupcake->user = new user($row['id']);
					// $cupcake->active = $row['active'];
					// $cupcake->tag = $row['tag'];
					// $cupcake->hits = $row['hits'];
				// }
				// $cupcakes[] = $cupcake;
			// }
     // return $cupcakes;
		// }
		
		public function fill_values($id) {
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM cupcakes WHERE id=".$id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$this->id = $row['id'];
					$this->publicationDate = $row['publicationDate'];
					$this->title = $row['title'];
					$this->summary = $row['summary'];
					$this->content = $row['content'];
					$this->user = new user($row['id']);
					$this->active = $row['active'];
					$this->tag = $row['tag'];
					$this->hits = $row['hits'];
				}
				
			}
		}
		
		public function getAll() {
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM cupcakes;");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$cupcake = new cupcake();
					$cupcake->id = $row['id'];
					$cupcake->publicationDate = $row['publicationDate'];
					$cupcake->title = $row['title'];
					$cupcake->summary = $row['summary'];
					$cupcake->content = $row['content'];
					$cupcake->user = new user($row['id']);
					$cupcake->active = $row['active'];
					$cupcake->tag = $row['tag'];
					$cupcake->hits = $row['hits'];
					$cupcakes[] = $cupcake;
				}
				
			}
			?><ul id="headlines"><?php
			foreach ( $cupcakes as $cupcake ) {
				?>
				<li>
					<h2>
						<a href="cupcake.php?id=<?php echo $cupcake->id; ?>" class="title"><?php echo $cupcake->title; ?></a>
						<span class="author"><?php echo $cupcake->user->displayname; ?></span>
						<span class="pubDate"><?php echo $cupcake->publicationDate; ?></span>
					</h2>
					<p class="summary"><?php echo $cupcake->summary; ?></p>
				</li>
				<?php
			}
			?></ul><?php
		}
		
		
		private function set_value($type, $value) {
			$this->$type = $value;
		}
		
		public function view() {
			?>
			
			<ul id="headlines">
				<li>
					<h2>
						<a href="cupcake.php?id=<?php echo $this->id; ?>" class="title"><?php echo $this->title; ?></a>
						<span class="author"><?php echo $this->user->displayname; ?></span>
						<span class="pubDate"><?php echo $this->publicationDate; ?></span>
					</h2>
					<p class="summary"><?php echo $this->summary; ?></p>
					<p class="content"><?php echo $this->content; ?></p>
					<p class="tag"><?php echo $this->tag; ?></p>
					<p class="hits"><?php echo $this->hits; ?></p>
				</li>
				</ul>
				
			<?php
		}
		
	}
	
?>