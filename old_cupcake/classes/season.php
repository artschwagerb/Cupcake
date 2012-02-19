<?php
	class season {
		var $id;
		var $tvdb_season_id;
		var $show;
		var $user;
		var $number;
		var $active;
		var $hits;
		var $date_added;
		
		function __construct($sea_id) {
			
			$this->tvdb_season_id = $sea_id;
			
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_season WHERE tvdb_season_id=".$sea_id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$this->id = $row['id'];
					$this->show = new show($row['tvdb_series_id']);
					$this->user = new user($row['author_id']);
					$this->number = $row['number'];
					$this->active = $row['active'];
					$this->date_added = $row['date_added'];
				}
			}
		}
		
		function get($sea_id) {
		$this->tvdb_season_id = $sea_id;
			
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_season WHERE tvdb_season_id=".$sea_id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$show = new show($row['tvdb_series_id']);
					$this->id = $row['id'];
					$this->show = $show->get($row['show_id']);
					$this->user = new user($row['author_id']);
					$this->number = $row['number'];
					$this->active = $row['active'];
					$this->date_added = $row['date_added'];
				}
			}
			//echo $res;
			// $this->usernumber = $res['usernumber'];
			// $this->email = $res['email'];
		}
		
		// public function getAll() {
			// $dbstuff = new databee();
			// $res = $dbstuff->query("SELECT * FROM v_seasons;");
			// if(mysql_num_rows($res) != 0){
				// while($row = mysql_fetch_assoc($res)) {
					// $season = new season(1);
					// $season->publicationDate = $row['publicationDate'];
					// $season->title = $row['title'];
					// $season->summary = $row['summary'];
					// $season->content = $row['content'];
					// $season->user = new user($row['id']);
					// $season->active = $row['active'];
					// $season->tag = $row['tag'];
					// $season->hits = $row['hits'];
				// }
				// $seasons[] = $season;
			// }
     // return $seasons;
		// }
		
		public function fill_values($id) {
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_season WHERE tvdb_season_id=".$id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$show = new show($row['tvdb_series_id']);
					$this->tvdb_season_id = $row['tvdb_season_id'];
					$this->id = $row['id'];
					$this->show = $show->get($row['show_id']);
					$this->user = new user($row['author_id']);
					$this->number = $row['number'];
					$this->active = $row['active'];
					$this->date_added = $row['date_added'];
				}
				
			}
		}
		
		public function getAll() {
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_season;");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$season = new season($row['tvdb_season_id']);
					$seasons[] = $season;
				}
				
			}
			?><ul id="headlines"><?php
			foreach ( $seasons as $season ) {
				?>
				<li>
					<h2>
						<a href="season.php?id=<?php echo $season->id; ?>" class="title"><?php echo $season->title; ?></a>
						<span class="author"><?php echo $season->user->displaynumber; ?></span>
						<span class="pubDate"><?php echo $season->publicationDate; ?></span>
					</h2>
					<p class="summary"><?php echo $season->summary; ?></p>
				</li>
				<?php
			}
			?></ul><?php
		}
		
		public function getEpisodes() {
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_episode WHERE tvdb_season_id=".$this->tvdb_season_id." ORDER BY number;");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$episode = new episode($row['tvdb_episode_id']);
				
				if(file_exists($episode->filename)) {
				//Only display episodes that have been uploaded/exist
					?>
					<div class="thinline"></div>
					<div id="episode">
						<p class="episodenumber"><?php echo $episode->number; ?></p>
						<p class="episodename"><a  href="player.php?id=<?php echo $episode->tvdb_episode_id; ?>" class="title"><?php echo $episode->name; ?></a></p>
						
						<p class="episodespoiler"><a class='button small' href="javascript:;" onmousedown="toggleDiv('description-spoiler-<?php echo $episode->tvdb_episode_id; ?>');">View/Hide Episode Summary</a></p>
						<div style="clear: both;"></div>
						<div id="description-spoiler-<?php echo $episode->tvdb_episode_id; ?>" style="display:none">TVDB Rating: <div class="rating"><div class="cover"></div><div class="progress" style="width: <?php echo $episode->rating*10; ?>%;"></div></div><br />
						<?php echo $episode->description; ?>

						</div>
					</div>
					
					<?php
				}
			
			}
				
			}
			?><div class="thinline"></div><?php
		}
		
		public function getBanner() {
		?><center><a title="<?php echo $this->show->name; ?>" href="show.php?id=<?php echo $this->show->tvdb_series_id; ?>"><img src="images/shows/banners/<?php echo $this->show->tvdb_series_id; ?>.jpg" /></a></center><?php
		}
		
		
		private function set_value($type, $value) {
			$this->$type = $value;
		}
		
		public function view() {
			?>
			
			<ul id="headlines">
				<li>
					<h2>
						<a href="player.php?id=<?php echo $this->tvdb_episode_id; ?>" class="title"><?php echo "Season ".$this->number; ?></a>
						<span class="author"><?php echo $this->user->displaynumber; ?></span>
						<span class="pubDate"><?php echo $this->date_added; ?></span>
					</h2>
				</li>
				</ul>
				
			<?php
		}
		
	}
	
?>