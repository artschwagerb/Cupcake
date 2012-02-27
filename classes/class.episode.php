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
		var $date_aired;
                var $viewed;
		
		function __construct($epi_id = 0) {
			
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
					$this->date_aired = $row['date_aired'];
					$this->rating = $row['rating'];
                                        $this->viewed = $this->check_Viewed();
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
					$this->date_aired = $row['date_aired'];
					$this->votes_up = $row['votes_up'];
					$this->votes_down = $row['votes_down'];
				}
			}
			//echo $res;
			// $this->username = $res['username'];
			// $this->email = $res['email'];
		}
		
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
					$this->date_aired = $row['date_aired'];
				}
				
			}
		}
		
		private function set_value($type, $value) {
			$this->$type = $value;
		}
		
		public function getAirDate() {
			if ($this->date_aired=="") {
			return "Unavailable";
			} else {
			return date('F j, Y', strtotime($this->date_aired));
			}
		}
		
		public function getNextEpisode() {
			$nextid = 0;
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT tvdb_episode_id FROM v_episode WHERE tvdb_season_id=".$this->season->tvdb_season_id." and number>".$this->number." LIMIT 1;");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$nextid = $row['tvdb_episode_id'];
				}
			}
			return $nextid;
		}
                
                public function getNextEpisodes() {
			$dbstuff = new databee();
                        $episodes = array();
			$res = $dbstuff->query("SELECT tvdb_episode_id FROM v_episode WHERE tvdb_season_id=".$this->season->tvdb_season_id." and number>".$this->number.";");
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
                                        $nextepisode = new self($row['tvdb_episode_id']);
                                        array_push($episodes, $nextepisode);
                                        //echo '{title:"'.$nextepisode->name.'",artist:"'.$nextepisode->show->name.'",free:true,m4v: "'.$nextepisode->filename.'"},';
                                        
				}
                                return $episodes;
			}
			
		}
                
                
		
		public function getComments() {
			$dbstuff = new databee();
			
			$res = $dbstuff->query("SELECT id FROM c_comment WHERE parent_id=".$this->tvdb_episode_id." and type=0 ORDER BY date_added;");
			
			if(mysql_num_rows($res) != 0){
				while($row = mysql_fetch_assoc($res)) {
					$comment = new comment($row['id']);
					$comment->view();
				}

			} else {
			echo '<p>Be the first to comment on this episode of '.$this->show->name.'...</p>';
			echo '<hr />';
			}
			?>
			
			
			<div class="thinline"></div>
			<?php
		}
                
                public function check_Viewed() {
                    $dbstuff = new databee();
			
                    $res = $dbstuff->query("SELECT id FROM u_activity WHERE parent_id=".$this->tvdb_episode_id." and type_id=1 and user_id ='".$_SESSION['id_of_user']."';");

                    if(mysql_num_rows($res) == 0){
                        return false;
                    } else {
                        return true;
                    }
                    
                }
		
		public function log_View() {
			$dbstuff = new databee();
			$res = $dbstuff->query("SELECT * FROM u_activity WHERE parent_id='".$this->tvdb_episode_id."' and type_id='1' and DATE(date_of_play) = CURDATE() and user_id ='".$_SESSION['id_of_user']."';");
			if(mysql_num_rows($res) == 0){
				//Only log a view if they dont already have a play of this episode today
				$dbstuff->execute("INSERT INTO u_activity (parent_id, user_id, type_id) VALUES ('".$this->tvdb_episode_id."', '".$_SESSION['id_of_user']."', '1')");
			}
		
		}
		
		
	}
	
?>