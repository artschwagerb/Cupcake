<body>

<?php 
include "config.php";
$APIKEY="189812DEFDFC361E";
if(isset($_GET["id"])) {
$seriesid = $_GET["id"];
} else {
echo "ID not given...";
exit;
}


$file = "http://www.thetvdb.com/api/189812DEFDFC361E/series/".$seriesid."/all/en.xml";

print "<p>$file</p>";
				
//Process Local XML files
$xmlcontent=curl($file) or trigger_error("Sorry but an error occured gathering information for this episode from thetvdb.com  Please try again shortly by refreshing this page");
	
$xml = new SimpleXMLElement($xmlcontent);
	// if($xml->Series != '') {
		// $series_id= $xml->Series[0]->id;
		// $series_name= $xml->Series[0]->SeriesName;
		$series_banner= "http://thetvdb.com/banners/".$xml->Series[0]->banner;
		if(!file_exists("images/shows/banners/".$xml->Series[0]->id.".jpg")){
		file_put_contents("images/shows/banners/".$xml->Series[0]->id.".jpg", file_get_contents($series_banner));
		}
		// $series_overview= $xml->Series[0]->Overview;
		// $series_aired= $xml->Series[0]->FirstAired;
		// $series_imdb= $xml->Series[0]->IMDB_ID;	
		// echo strtolower($series_name);
		// echo strtolower(str_replace("_"," ",$showname));
		// if(strpos(strtolower($series_name),strtolower(str_replace("_"," ",$showname))) == FALSE){
			// echo "Found the wrong Series";
		// } else {
			// echo "Found the right Series";
		// }
	// }else{
		// echo "Bad Search";
	// }
	
	$dbstuff = new databee();
	$res = $dbstuff->query("SELECT * FROM v_show WHERE tvdb_series_id=".$xml->Series[0]->id.";");
	if(mysql_num_rows($res) == 0){
	//Series not in database
		if(file_exists(addSlashes(strtolower("videos/tv/".str_replace(" ","_",$xml->Series[0]->SeriesName))))){
		//Series folder exists
		echo "Series - Created - '".$xml->Series[0]->SeriesName."'";
		$dbstuff->execute("INSERT INTO v_show (name, description, author_id, active, date_added, date_aired, tvdb_series_id, filepath) VALUES ('".addSlashes($xml->Series[0]->SeriesName)."', '".addSlashes($xml->Series[0]->Overview)."', '"."0"."', '"."1"."', '".addSlashes(date("Y-m-d"))."', '".addSlashes($xml->Series[0]->FirstAired)."', '".addSlashes($xml->Series[0]->id)."', '".addSlashes(strtolower("videos/tv/".str_replace(" ","_",$xml->Series[0]->SeriesName)))."/')");
		}else {
		$seriespath = addSlashes(strtolower("videos/tv/".str_replace(" ","_",$xml->Series[0]->SeriesName)));
		echo "Series - Folder does not Exist - '".$xml->Series[0]->SeriesName."'";
		
		}
		
	} else {
	//Series in database
		while($row = mysql_fetch_assoc($res)) {
			echo "Series - Database - ".$xml->Series[0]->SeriesName." - Exists";
			$seriespath = $row['filepath'];
			if($seriespath=="") {
				echo "Series - Folder does not Exist - ".addSlashes(strtolower("videos/tv/".str_replace(" ","_",$xml->Series[0]->SeriesName)));
				exit;
			}
		}
	}	
	
foreach ($xml->Episode as $Episode) { 
	
	
	if($Episode->SeasonNumber>=1){
	//Episode from Season 1 or later
		if($Episode->EpisodeName!="TBA"){
		//Real episode?
			$dbstuff = new databee();
			$episoderes = $dbstuff->query("SELECT * FROM v_episode WHERE tvdb_episode_id='".addSlashes($Episode->id)."';");
			if(mysql_num_rows($episoderes) == 0){
			//Episode not in Database
			echo "Episode ".$Episode->EpisodeNumber." - Checking - '".$Episode->EpisodeName."'<br />";
				$seasonres = $dbstuff->query("SELECT * FROM v_season WHERE tvdb_season_id='".addSlashes($Episode->seasonid)."';");
				if(mysql_num_rows($seasonres) == 0){
				//Season not in Database
					echo "Season ".$Episode->SeasonNumber." - Database - Does not Exist.<br />";
					if(file_exists($seriespath.sprintf("%0"."2"."d",$Episode->SeasonNumber,2)."/")){
						//season folder exists
						echo "Season - Created - ".$Episode->seasonid;
						$dbstuff->execute("INSERT INTO v_season (author_id, number, date_added, date_aired, tvdb_season_id, tvdb_series_id) VALUES ('"."0"."', '".addSlashes($Episode->SeasonNumber)."', '".date("Y-m-d")."', '".addSlashes($Episode->FirstAired)."', '".addSlashes($Episode->seasonid)."', '".addSlashes($Episode->seriesid)."')");
						if(file_exists($seriespath.sprintf("%0"."2"."d",$Episode->SeasonNumber,2)."/".sprintf("%0"."2"."d",$Episode->EpisodeNumber,2).".mp4")){
							if(!file_exists("images/shows/previews/".$Episode->id.".jpg")){
							//preview picture not on server, download
								echo "Preview - Downloaded - '".$Episode->EpisodeName."'<br />";
								file_put_contents("images/shows/previews/".$Episode->id.".jpg", file_get_contents("http://thetvdb.com/banners/_cache/".$Episode->filename));
							}
						}
					} else {
					//season folder doesnt exist
					echo "Season ".$Episode->SeasonNumber." - Folder - Does not Exist.<br />";
					}
				} else {
				//season already in database
				echo "Season - Database - ".$Episode->SeasonNumber." - Exists<br />";
				
				}
				if(file_exists($seriespath.sprintf("%0"."2"."d",$Episode->SeasonNumber,2)."/".sprintf("%0"."2"."d",$Episode->EpisodeNumber,2).".mp4")){
					//episode file exists, add to db
					echo "Episode ".$Episode->EpisodeNumber." - Created ".$Episode->id." - '".$Episode->EpisodeName."'<br />"; 
					$dbstuff->execute("INSERT INTO v_episode (author_id, name, number, description, date_added, rating, tvdb_episode_id, tvdb_season_id, tvdb_series_id) VALUES ('"."0"."', '".addSlashes($Episode->EpisodeName)."', '".addSlashes($Episode->EpisodeNumber)."', '".addSlashes($Episode->Overview)."', '".date("Y-m-d")."', '".addSlashes($Episode->Rating)."', '".addSlashes($Episode->id)."', '".addSlashes($Episode->seasonid)."', '".addSlashes($Episode->seriesid)."')");	
				}
				// echo $Episode->seriesid; // Episode Series
				// echo "<br />";
				// echo $Episode->id; // ID of Episode
				// echo "<br />";
				// echo $Episode->SeasonNumber; // Season of Episode
				// echo "<br />";
				//echo $Episode->EpisodeName; // Name of Episode
				// echo "<br />";
				// echo $Episode->EpisodeNumber; // Number of Episode
				// echo "<br />";
				// echo $Episode->Overview; // Episode Description
				// echo "<br />";
				// echo $Episode->Rating; // Episode Rating
				// echo "<br />";
				// echo $Episode->FirstAired; // Episode First Aired on
				// echo "<br />";
				// echo "http://www.thetvdb.com/banners/".$Episode->filename; // Episode Preview
				// echo "<br />";
				// echo $Episode->seasonid; // Episode Season
				// echo "<br />";
			} else {
			//Episode already in database, updating
				echo "Episode ".$Episode->EpisodeNumber." - Updated - ".$Episode->id." - '".$Episode->EpisodeName."'<br />";
				$dbstuff->execute("UPDATE v_episode SET author_id='0', name='".addSlashes($Episode->EpisodeName)."', number='".addSlashes($Episode->EpisodeNumber)."', description='".addSlashes($Episode->Overview)."', date_added='".addSlashes(date("Y-m-d"))."', rating='".addSlashes($Episode->Rating)."', tvdb_episode_id='".addSlashes($Episode->id)."', tvdb_series_id='".addSlashes($Episode->seriesid)."', tvdb_season_id='".addSlashes($Episode->seasonid)."' WHERE tvdb_episode_id='".addSlashes($Episode->id)."'");	
				
				if(file_exists($seriespath.sprintf("%0"."2"."d",$Episode->SeasonNumber,2)."/".sprintf("%0"."2"."d",$Episode->EpisodeNumber,2).".mp4")){
					if(!file_exists("images/shows/previews/".$Episode->id.".jpg")){
					//preview picture not on server, download
						echo "Preview - Downloaded - '".$Episode->EpisodeName."'<br />";
						file_put_contents("images/shows/previews/".$Episode->id.".jpg", file_get_contents("http://thetvdb.com/banners/_cache/".$Episode->filename));
					}
				}
				
				$seasonres = $dbstuff->query("SELECT * FROM v_season WHERE tvdb_season_id='".addSlashes($Episode->seasonid)."';");
				if(mysql_num_rows($seasonres) == 0){
				//season not in database, adding
					echo "Season - Created - ".$Episode->SeasonNumber;
					$dbstuff->execute("INSERT INTO v_season (author_id, number, date_added, date_aired, tvdb_season_id, tvdb_series_id) VALUES ('"."0"."', '".addSlashes($Episode->SeasonNumber)."', '".date("Y-m-d")."', '".addSlashes($Episode->FirstAired)."', '".addSlashes($Episode->seasonid)."', '".addSlashes($Episode->seriesid)."')");
				}
			}	
		}
	}
		echo "<br />";
} 
		
function curl($url){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
}		
?>
</body>
</html>