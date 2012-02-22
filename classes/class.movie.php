<?php
	class movie {
		var $id;
		var $user;
		var $name;
		var $filename;
		var $description;
		var $active;
		var $hits;
		var $date_added;
		var $votes_up;
		var $votes_down;
		
		function __construct($mov_id) {
			$this->id = $mov_id;
			
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_movie WHERE id=".$mov_id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$this->user = new user($row['author_id']);
					$this->name = $row['name'];
					$this->filename = $row['filename'];
					$this->description = $row['description'];
					$this->active = $row['active'];
					$this->hits = $row['hits'];
					$this->date_added = $row['date_added'];
					$this->votes_up = $row['votes_up'];
					$this->votes_down = $row['votes_down'];
				}
			}
		}
		
		function get($mov_id) {
		$this->id = $mov_id;
			
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_movie WHERE id=".$mov_id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$this->user = new user($row['author_id']);
					$this->name = $row['name'];
					$this->filename = $row['filename'];
					$this->description = $row['description'];
					$this->active = $row['active'];
					$this->hits = $row['hits'];
					$this->date_added = $row['date_added'];
					$this->votes_up = $row['votes_up'];
					$this->votes_down = $row['votes_down'];
				}
			}
			//echo $res;
			// $this->username = $res['username'];
			// $this->email = $res['email'];
		}
		
		// public function getAll() {
			// $dbstuff = new databee();
			// $res = $dbstuff->query("SELECT * FROM v_movies;");
			// if(mysql_num_rows($res) != 0){
				// while($row = mysql_fetch_assoc($res)) {
					// $movie = new movie(1);
					// $movie->publicationDate = $row['publicationDate'];
					// $movie->title = $row['title'];
					// $movie->summary = $row['summary'];
					// $movie->content = $row['content'];
					// $movie->user = new user($row['id']);
					// $movie->active = $row['active'];
					// $movie->tag = $row['tag'];
					// $movie->hits = $row['hits'];
				// }
				// $episodes[] = $movie;
			// }
     // return $episodes;
		// }
		
		public function fill_values($id) {
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_movie WHERE id=".$id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$this->id = $row['id'];
					$this->user = new user($row['author_id']);
					$this->name = $row['name'];
					$this->filename = $row['filename'];
					$this->description = $row['description'];
					$this->active = $row['active'];
					$this->hits = $row['hits'];
					$this->date_added = $row['date_added'];
					$this->votes_up = $row['votes_up'];
					$this->votes_down = $row['votes_down'];
				}
				
			}
		}
		
		public function getAll() {
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_movie WHERE active = 1 ORDER BY name;");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$movie = new movie(0);
					$movie->id = $row['id'];
					$this->user = new user($row['author_id']);
					$this->name = $row['name'];
					$this->filename = $row['filename'];
					$this->description = $row['description'];
					$this->active = $row['active'];
					$this->hits = $row['hits'];
					$this->date_added = $row['date_added'];
					$this->votes_up = $row['votes_up'];
					$this->votes_down = $row['votes_down'];
					$movies[] = $movie;
				}
				
			}
			foreach ( $movies as $movie ) {
				if(file_exists("images/movies/posters/".$movie->id.".jpg")) {
					?>
					<a title="<?php echo $movie->name; ?>" href="movie.php?id=<?php echo $movie->id; ?>"><img width="300" height="441" src="images/movies/posters/<?php echo $movie->id; ?>.jpg" /></a>
					<?php
				}
			}
		}
		
		public function getAllPosters() {
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_movie WHERE active = 1 ORDER BY name;");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$movie = new movie(0);
					$movie->id = $row['id'];
					$this->user = new user($row['author_id']);
					$this->name = $row['name'];
					$this->filename = $row['filename'];
					$this->description = $row['description'];
					$this->active = $row['active'];
					$this->hits = $row['hits'];
					$this->date_added = $row['date_added'];
					$this->votes_up = $row['votes_up'];
					$this->votes_down = $row['votes_down'];
					$movies[] = $movie;
				}
				
			}
			?>
			<div class="row">
				<ul class="block-grid three-up">
			<?php
			foreach ( $movies as $movie ) {
				if(file_exists("images/movies/posters/".$movie->id.".jpg")) {
				?>
				<li>
				<!--<div class="panel">-->
	  				<a title="<?php echo $movie->name; ?>" href="movie.php?id=<?php echo $movie->id; ?>"><img class="moviePoster" src="images/movies/posters/<?php echo $movie->id; ?>.jpg" /></a>
	  			<!--</div>-->
				</li>
				<?php
				}
			}
			?>
				</ul>
			</div>	
			<?php
		}
		
		private function set_value($type, $value) {
			$this->$type = $value;
		}
		
		public function view() {
			?>
			
			<ul id="headlines">
				<li>
					<h2>
						<a href="player.php?id=<?php echo $this->id; ?>" class="title"><?php echo $this->name; ?></a>
						<span class="author"><?php echo $this->user->displayname; ?></span>
						<span class="pubDate"><?php //echo $this->publicationDate; ?></span>
					</h2>
					<p class="summary"><?php echo $this->description; ?></p>
					<p class="content"><?php //echo $this->content; ?></p>
					<p class="hits"><?php echo $this->hits; ?></p>
				</li>
				</ul>
				
			<?php
		}
                
                public function log_View() {
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM u_activity WHERE parent_id='".$this->id."' and type_id='2' and DATE(date_of_play) = CURDATE() and user_id ='".$_SESSION['id_of_user']."';");
			if(mysql_num_rows($res) == 0){
				//Only log a view if they dont already have a play of this episode today
				$dbstuff->execute("INSERT INTO u_activity (parent_id, user_id, type_id) VALUES ('".$this->id."', '".$_SESSION['id_of_user']."', '2')");
			}
		
		}
		
	}
	
?>