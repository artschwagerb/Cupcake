<?php
	class show {
		var $id;
		var $user;
		var $name;
		var $description;
		var $active;
		var $hits;
		var $date_added;
		var $date_aired;
		var $tvdb_series_id;
		var $filepath;
		
		function __construct($show_id) {
			$this->tvdb_series_id = $show_id;
			
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_show WHERE tvdb_series_id=".$show_id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$this->id = $row['id'];
					$this->name = $row['name'];
					$this->description = $row['description'];
					$this->user = new user($row['author_id']);
					$this->active = $row['active'];
					$this->date_added = $row['date_added'];
					$this->date_aired = $row['date_aired'];
					$this->filepath = $row['filepath'];
				}
			}
		}
	
		function get($show_id) {
		$this->tvdb_series_id = $show_id;
			
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_show WHERE tvdb_series_id=".$show_id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$this->id = $row['id'];
					$this->name = $row['name'];
					$this->description = $row['description'];
					$this->user = new user($row['author_id']);
					$this->active = $row['active'];
					$this->date_added = $row['date_added'];
					$this->date_aired = $row['date_aired'];
					$this->filepath = $row['filepath'];
				}
			}
			//echo $res;
			// $this->username = $res['username'];
			// $this->email = $res['email'];
		}
		
		// public function getAll() {
			// $dbstuff = new databee();
			// $res = $dbstuff->query("SELECT * FROM v_shows;");
			// if(mysql_num_rows($res) != 0){
				// while($row = mysql_fetch_assoc($res)) {
					// $show = new show(1);
					// $show->publicationDate = $row['publicationDate'];
					// $show->title = $row['title'];
					// $show->summary = $row['summary'];
					// $show->content = $row['content'];
					// $show->user = new user($row['id']);
					// $show->active = $row['active'];
					// $show->tag = $row['tag'];
					// $show->hits = $row['hits'];
				// }
				// $shows[] = $show;
			// }
     // return $shows;
		// }
		
		public function fill_values($id) {
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_show WHERE tvdb_series_id=".$id.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$this->name = $row['name'];
					$this->description = $row['description'];
					$this->user = new user($row['author_id']);
					$this->active = $row['active'];
					$this->date_added = $row['date_added'];
					$this->date_aired = $row['date_aired'];
					$this->filepath = $row['filepath'];
				}
				
			}
		}
		
		public function getAllBanners() {
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_show ORDER BY name;");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$show = new show($row['tvdb_series_id']);
					$shows[] = $show;
				}
				
			}
			?><center><?php
			foreach ( $shows as $show ) {
			if(file_exists("images/shows/banners/".$show->tvdb_series_id.".jpg")) {
				?>
				<a title="<?php echo $show->name; ?>" href="show.php?id=<?php echo $show->tvdb_series_id; ?>"><img src="images/shows/banners/<?php echo $show->tvdb_series_id; ?>.jpg" /></a>
				<?php
			}
			}
			?></center><?php
		}
		
		public function getBanner() {
		?><center><a title="<?php echo $this->name; ?>" href="show.php?id=<?php echo $this->tvdb_series_id; ?>"><img src="images/shows/banners/<?php echo $this->tvdb_series_id; ?>.jpg" /></a></center><br /><?php
		}
		
		public function getDescription() {
		?><br/><br/><div id="description-spoiler" style="display:none"><?php echo $this->description; ?></div>
		<a href="javascript:;" onmousedown="toggleDiv('description-spoiler');">View/Hide Show Description</a><?php
		}
		
		public function getAllNames() {
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_show ORDER BY name;");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$show = new show($row['tvdb_series_id']);
					$shows[] = $show;
				}
				
			}
			?><?php
			foreach ( $shows as $show ) {
			if(file_exists("images/shows/banners/".$show->tvdb_series_id.".jpg")) {
				?>
				<a href="show.php?id=<?php echo $this->tvdb_series_id; ?>"><?php echo $this->name; ?></a>
				<?php
			}
			}
			?><?php
		}
		
		public function getUpdateLink() {
		?>
		<br />
		<a id="seriesupdatelink" class='button small white' target="_blank" href="get_tv_info.php?id=<?php echo $this->tvdb_series_id; ?>">Update</a>
		<br />
		<?php
		}
		
		public function getSeasons() {
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM v_season WHERE tvdb_series_id='$this->tvdb_series_id' ORDER BY number;");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$season = new season($row['tvdb_season_id']);
					$seasons[] = $season;
				}
				
			}
			$count=0;
			foreach ( $seasons as $season ) {
				if(file_exists($this->filepath.sprintf("%0"."2"."d",$season->number,2))) {
					?>
							<a class='button blue' href="season.php?id=<?php echo $season->tvdb_season_id; ?>" class="title">Season <?php echo $season->number; ?></a>
					<?php
				}
			}
			?><?php
		}
		
		
		private function set_value($type, $value) {
			$this->$type = $value;
		}
		
		public function view() {
			?>
				<center><a title="<?php echo $this->name; ?>" href="show.php?id=<?php echo $this->tvdb_series_id; ?>"><img src="images/shows/banners/<?php echo $this->tvdb_series_id; ?>.jpg" /></a></center>
				<br />
				<div id="description-spoiler" style="display:none"><?php echo $this->description; ?></div>
				<a href="javascript:;" onmousedown="toggleDiv('description-spoiler');">View/Hide Show Description</a>
				<br /><br />
				<?php echo $this->getSeasons(); ?>
			<?php
		}
		
		// function leadingZeros($num,$numDigits) {
			// return sprintf("%0".$numDigits."d",$num);
			// sprintf("%0"."2"."d",$num)
		// }
		
	}
	
?>