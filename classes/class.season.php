<?php
require_once("./include/membersite_config.php");
	class season {
		var $id;
		var $tvdb_season_id;
		var $show;
		var $user;
		var $number;
		var $active;
		var $hits;
		var $date_added;
		var $date_aired;
		
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
					$this->date_aired = $row['date_aired'];
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
					$this->date_aired = $row['date_aired'];
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
					$this->date_aired = $row['date_aired'];
				}
				
			}
		}
		
		public function getEpisodes($premium) {
                        
                    
                    
			$dbstuff = new databee();
			if (!$premium){
			$res = $dbstuff->query("SELECT tvdb_episode_id FROM v_episode WHERE tvdb_season_id=".$this->tvdb_season_id." AND server_name='localhost' ORDER BY number LIMIT 5;");
			} else {
			$res = $dbstuff->query("SELECT tvdb_episode_id FROM v_episode WHERE tvdb_season_id=".$this->tvdb_season_id." ORDER BY number;");
			}
                        
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
                                    
                                    $episode = new episode($row['tvdb_episode_id']);
				
                                    if($episode->server != "notfound") {
                                    //Only display episodes that have been uploaded/exist
                                            ?>					
                                            <div class="row">
                                                    <div style="vertical-align: middle; ">
                                                            <div class="one column">
                                                                            <p><?php echo $episode->number; ?></p>
                                                            </div>
                                                            <div class="five columns">
                                                                            <p><a href="player.php?id=<?php echo $episode->tvdb_episode_id; ?>"><?php echo $episode->name; ?></a></p>
                                                            </div>
                                                            <div class="two columns">
                                                                            <div class="hide-on-desktops"><p><a class="xsmall white nice button radius" href="player.php?id=<?php echo $episode->tvdb_episode_id; ?>">WATCH</a></p></div>
                                                            </div>
                                                            <div class="one column">
                                                                <?php
                                                                if($episode->check_Viewed() == true){
                                                                    echo '<p style="vertical-align: middle; margin-top: 4px;"><img src="images/eye-icon.png" title="Previously Watched" /></p>';
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="two columns">
                                                                    <div class="rating"><div class="cover"></div><div class="progress" style='width: <?php echo $episode->rating*10 . "%"; ?>;'></div></div>
                                                            </div>
                                                            <div class="one column">
                                                                            <p><a class="xsmall white nice button radius" href="javascript:;" onmousedown="toggleDiv('description-spoiler-<?php echo $episode->tvdb_episode_id; ?>',this);">v</a></p>
                                                            </div>
                                                    </div>
                                            </div>
                                            <div id="description-spoiler-<?php echo $episode->tvdb_episode_id; ?>" style="display: none; " class="row">
                                                    <div class="twelve columns">
                                                            <div class="panel">
                                                                    <p><?php echo $episode->description; ?></p>
                                                            </div>
                                                    </div>
                                            </div>

                                            <?php
                                    }

                            }
				if(!$premium){
				echo '<span class="red label">Non-Premium Accounts are Limited to 5 Episodes...</span>';
				}
			}
			?><div class="thinline"></div><?php
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