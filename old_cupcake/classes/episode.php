<?php
	class episode {
		var $id;
		var $show;
		var $season;
		var $user;
		var $name;
		var $filename;
		var $number;
		var $description;
		var $active;
		var $date_added;
		var $tvdb_episode_id;
		var $rating;
		
		function __construct($epi_id) {
			
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_episode WHERE tvdb_episode_id=".$epi_id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$this->id = $row['id'];
					$this->tvdb_episode_id = $row['tvdb_episode_id'];
					$this->show = new show($row['tvdb_series_id']);
					$this->season = new season($row['tvdb_season_id']);
					$this->user = new user($row['author_id']);
					$this->name = $row['name'];
					$this->number = $row['number'];
					$this->filename = $this->show->filepath.sprintf("%0"."2"."d",$this->season->number,2)."/".sprintf("%0"."2"."d",$this->number,2).".mp4";
					$this->description = $row['description'];
					$this->active = $row['active'];
					$this->hits = $row['hits'];
					$this->date_added = $row['date_added'];
					$this->rating = $row['rating'];
				}
			}
		}
		
		function get($epi_id) {
		
			
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_episode WHERE tvdb_episode_id=".$epi_id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					//$this->show = new show($row['show_id']);
					$this->id = $row['id'];
					$this->tvdb_episode_id = $row['tvdb_episode_id'];
					$this->season = new season($row['season_id']);
					$this->user = new user($row['author_id']);
					$this->name = $row['name'];
					$this->number = $row['number'];
					$this->filename = $this->show->filepath.sprintf("%0"."2"."d",$this->season->number,2)."/".sprintf("%0"."2"."d",$this->number,2).".mp4";
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
			// $res = $dbstuff->query("SELECT * FROM v_episodes;");
			// if(mysql_num_rows($res) != 0){
				// while($row = mysql_fetch_assoc($res)) {
					// $episode = new episode(1);
					// $episode->publicationDate = $row['publicationDate'];
					// $episode->title = $row['title'];
					// $episode->summary = $row['summary'];
					// $episode->content = $row['content'];
					// $episode->user = new user($row['id']);
					// $episode->active = $row['active'];
					// $episode->tag = $row['tag'];
					// $episode->hits = $row['hits'];
				// }
				// $episodes[] = $episode;
			// }
     // return $episodes;
		// }
		
		public function fill_values($id) {
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_episode WHERE tvdb_episode_id=".$id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$this->id = $row['id'];
					$this->tvdb_episode_id = $row['tvdb_episode_id'];
					$this->show = new show($row['show_id']);
					$this->season = new season($row['season_id']);
					$this->user = new user($row['author_id']);
					$this->name = $row['name'];
					$this->number = $row['number'];
					$this->filename = $this->show->filepath.sprintf("%0"."2"."d",$this->season->number,2)."/".sprintf("%0"."2"."d",$this->number,2).".mp4";
					$this->description = $row['description'];
					$this->active = $row['active'];
					$this->hits = $row['hits'];
					$this->date_added = $row['date_added'];
				}
				
			}
		}
		
		public function getAll() {
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_episode;");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$episode = new episode();
					$episode->id = $row['id'];
					$episode->tvdb_episode_id = $row['tvdb_episode_id'];
					$this->show = new show($row['show_id']);
					$this->season = new season($row['season_id']);
					$this->user = new user($row['author_id']);
					$this->name = $row['name'];
					$this->number = $row['number'];
					$this->filename = $this->show->filepath.sprintf("%0"."2"."d",$this->season->number,2)."/".sprintf("%0"."2"."d",$this->number,2).".mp4";
					$this->description = $row['description'];
					$this->active = $row['active'];
					$this->hits = $row['hits'];
					$this->date_added = $row['date_added'];
					$this->votes_up = $row['votes_up'];
					$this->votes_down = $row['votes_down'];
					$episodes[] = $episode;
				}
				
			}
			?><ul id="headlines"><?php
			foreach ( $episodes as $episode ) {
				?>
				<li>
					<h2>
						<a href="player.php?id=<?php echo $episode->id; ?>" class="title"><?php echo $episode->title; ?></a>
						<span class="author"><?php echo $episode->user->displayname; ?></span>
						<span class="pubDate"><?php echo $episode->publicationDate; ?></span>
					</h2>
					<p class="summary"><?php echo $episode->summary; ?></p>
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
						<a href="player.php?id=<?php echo $this->id; ?>" class="title"><?php echo $this->title; ?></a>
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
		
		public function getNextEpisode() {
			$nextid = 0;
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_episode WHERE tvdb_season_id=".$this->season->tvdb_season_id." and number>".$this->number." LIMIT 1;");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$nextid = $row['tvdb_episode_id'];
				}
			}
			return $nextid;
			//echo $res;
			// $this->username = $res['username'];
			// $this->email = $res['email'];
		}
		
	}
	
?>