<body>

<?php 
date_default_timezone_set('America/Chicago');
include "config.php";
$apikey="189812DEFDFC361E";
if(isset($_GET["series_id"])) {
$seriesid = $_GET["series_id"];
	if(isset($_GET["auth_id"])) {
	$authorid = $_GET["auth_id"];
	} else {
	echo "I don't know you...";
	exit;
	}
} else {
echo "ID not given...";
exit;
}

$tableoutput = '<table style="align: center;"><tr></tr>';
$startarray = explode(" ", microtime());
$starttime = $startarray[1] + $startarray[0];
$tableoutput .= "<tr><td>thetvdb.com</td><td>Checking API</td><td>Starting Update</td><td>0 sec</td></tr>";

function addtoOutput($item, $action="", $result){
    $endarray = explode(" ", microtime());
    $endtime = $endarray[1] + $endarray[0];
    $totaltime = $endtime-$GLOBALS['starttime']; 
    $totaltime = round($totaltime,5);
    $GLOBALS['tableoutput'] .= "<tr><td>".$item."</td><td>".$action."</td><td>".$result."</td><td>".$totaltime." sec</td></tr>";
}

function check_DB_Episode($episode_id){
    $dbstuff = new databee();
    $res = $dbstuff->query("SELECT * FROM v_episode WHERE tvdb_episode_id='".addSlashes($episode_id)."';");
    if(mysql_num_rows($res) != 0){
        return true;
    }else{
        return false;
    }
}

function curl($url){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
}


$file = "http://www.thetvdb.com/api/".$apikey."/series/".$seriesid."/all/en.xml";

//print "<p>$file</p>";
				
//Process Local XML files
$xmlcontent=curl($file) or trigger_error("Sorry but an error occured gathering information for this episode from thetvdb.com  Please try again shortly by refreshing this page");
	
$xml = new SimpleXMLElement($xmlcontent);
        echo '<h2>"'.$xml->Series[0]->SeriesName.'" Updated</h2>';
        echo '<p class="lead">Just thought I would let you know...</p>';
        echo '<p>I went ahead and updated "'.$xml->Series[0]->SeriesName.'" for you.</p>';
	// if($xml->Series != '') {
		// $series_id= $xml->Series[0]->id;
		// $series_name= $xml->Series[0]->SeriesName;
		
		if(!file_exists("images/shows/banners/".$xml->Series[0]->id.".jpg")){
                    $series_banner= "http://thetvdb.com/banners/".$xml->Series[0]->banner;
                    file_put_contents("images/shows/banners/".$xml->Series[0]->id.".jpg", file_get_contents($series_banner));
                    echo "Series - Banner Downloaded - images/shows/banners/".$xml->Series[0]->id.".jpg<br />";
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
	$seriespath = addSlashes(strtolower("videos/tv/".str_replace(" ","_",$xml->Series[0]->SeriesName)."/"));
	
	$dbstuff = new databee();
	$res = $dbstuff->query("SELECT * FROM v_show WHERE tvdb_series_id=".$xml->Series[0]->id.";");
	if(mysql_num_rows($res) == 0){
		//Series not in database
		if(file_exists($seriespath)){
			//Series folder exists
			addtoOutput($xml->Series[0]->SeriesName,"Creating DB");
                        addtoOutput($xml->Series[0]->SeriesName,"Using folder at ".$seriespath); 
			$dbstuff->execute("INSERT INTO v_show (name, description, author_id, active, date_added, date_aired, tvdb_series_id, filepath, genre, airs_dayofweek, airs_time, content_rating, network, actors, imdb_id, runtime) VALUES ('".addSlashes($xml->Series[0]->SeriesName)."', '".addSlashes($xml->Series[0]->Overview)."', '".$authorid."', '"."1"."', '".addSlashes(date("Y-m-d"))."', '".addSlashes($xml->Series[0]->FirstAired)."', '".addSlashes($xml->Series[0]->id)."', '".addSlashes(strtolower("videos/tv/".str_replace(" ","_",$xml->Series[0]->SeriesName)))."/', '".addSlashes($xml->Series[0]->Genre)."', '".addSlashes($xml->Series[0]->Airs_DayOfWeek)."', '".addSlashes($xml->Series[0]->Airs_Time)."', '".addSlashes($xml->Series[0]->ContentRating)."', '".addSlashes($xml->Series[0]->Network)."', '".addSlashes($xml->Series[0]->Actors)."', '".addSlashes($xml->Series[0]->IMDB_ID)."', '".addSlashes($xml->Series[0]->Runtime)."')");
		}else {
			addtoOutput($xml->Series[0]->SeriesName,"Folder doesn't exist at  ".$seriespath); 
			exit;
		}
		
	} else {
		//Series in database
		$dbstuff->execute("UPDATE v_show SET name = '".addSlashes($xml->Series[0]->SeriesName)."', description = '".addSlashes($xml->Series[0]->Overview)."', author_id = '".$authorid."', active = '1', date_added = '".addSlashes(date("Y-m-d"))."', date_aired = '".addSlashes($xml->Series[0]->FirstAired)."', tvdb_series_id = '".addSlashes($xml->Series[0]->id)."', filepath = '".addSlashes(strtolower("videos/tv/".str_replace(" ","_",$xml->Series[0]->SeriesName)))."/', genre = '".addSlashes($xml->Series[0]->Genre)."', airs_dayofweek = '".addSlashes($xml->Series[0]->Airs_DayOfWeek)."', airs_time = '".addSlashes($xml->Series[0]->Airs_Time)."', content_rating = '".addSlashes($xml->Series[0]->ContentRating)."', network = '".addSlashes($xml->Series[0]->Network)."', actors = '".addSlashes($xml->Series[0]->Actors)."', imdb_id = '".addSlashes($xml->Series[0]->IMDB_ID)."', runtime = '".addSlashes($xml->Series[0]->Runtime)."' WHERE tvdb_series_id = '".addSlashes($xml->Series[0]->id)."'");
                addtoOutput($xml->Series[0]->SeriesName,"Updating","Updated DB"); 

		if(file_exists($seriespath)) {
                        addtoOutput($xml->Series[0]->SeriesName,"Using Folder",$seriespath); 
		}else{
                    addtoOutput($xml->Series[0]->SeriesName,"Folder doesn't exist at",$seriespath); 
			exit;
		}
		
	}	
	
foreach ($xml->Episode as $Episode) { 
	
	
	if($Episode->SeasonNumber>=1){
	//Episode from Season 1 or later
		if($Episode->EpisodeName!="TBA"){
		//Real episode?
			if(check_DB_Episode($Episode->id)){
                            //Episode already in database, updating
                            if(file_exists($seriespath.sprintf("%0"."2"."d",$Episode->SeasonNumber,2)."/".sprintf("%0"."2"."d",$Episode->EpisodeNumber,2).".mp4")){
                                addtoOutput("Episode ".$Episode->EpisodeNumber,"Updated",$Episode->EpisodeName);
                                $dbstuff->execute("UPDATE v_episode SET author_id='0', name='".addSlashes($Episode->EpisodeName)."', number='".addSlashes($Episode->EpisodeNumber)."', description='".addSlashes($Episode->Overview)."', date_added='".addSlashes(date("Y-m-d"))."', date_aired='".addSlashes($Episode->FirstAired)."', rating='".addSlashes($Episode->Rating)."', tvdb_episode_id='".addSlashes($Episode->id)."', tvdb_series_id='".addSlashes($Episode->seriesid)."', tvdb_season_id='".addSlashes($Episode->seasonid)."', server_name='".addSlashes("localhost")."' WHERE tvdb_episode_id='".addSlashes($Episode->id)."'");
                            }
                            
                            $seasonres = $dbstuff->query("SELECT * FROM v_season WHERE tvdb_season_id='".addSlashes($Episode->seasonid)."';");
                            if(mysql_num_rows($seasonres) == 0){
                            //season not in database, adding
                                if(file_exists($seriespath.sprintf("%0"."2"."d",$Episode->SeasonNumber,2)."/")){
                                    addtoOutput("Season ".$Episode->SeasonNumber,"Created","Added to DB");
                                    $dbstuff->execute("INSERT INTO v_season (author_id, number, date_added, date_aired, tvdb_season_id, tvdb_series_id) VALUES ('"."0"."', '".addSlashes($Episode->SeasonNumber)."', '".date("Y-m-d")."', '".addSlashes($Episode->FirstAired)."', '".addSlashes($Episode->seasonid)."', '".addSlashes($Episode->seriesid)."')");
                                }
                            }
                            
			} else {
			//Episode not in Database
                            addtoOutput("Episode ".$Episode->EpisodeNumber,"Checking",$Episode->EpisodeName);    
				$seasonres = $dbstuff->query("SELECT * FROM v_season WHERE tvdb_season_id='".addSlashes($Episode->seasonid)."';");
				if(mysql_num_rows($seasonres) == 0){
				//Season not in Database
					
					if(file_exists($seriespath.sprintf("%0"."2"."d",$Episode->SeasonNumber,2)."/")){
						//season folder exists
                                                addtoOutput("Season ".$Episode->SeasonNumber,"Created","Added to DB");
						$dbstuff->execute("INSERT INTO v_season (author_id, number, date_added, date_aired, tvdb_season_id, tvdb_series_id) VALUES ('"."0"."', '".addSlashes($Episode->SeasonNumber)."', '".date("Y-m-d")."', '".addSlashes($Episode->FirstAired)."', '".addSlashes($Episode->seasonid)."', '".addSlashes($Episode->seriesid)."')");
					} else {
					//season folder doesnt exist
                                        addtoOutput("Season ".$Episode->SeasonNumber, "Folder - Does not Exist","looked ".$seriespath.sprintf("%0"."2"."d",$Episode->SeasonNumber,2)."/");
					}
				} else {
				//season already in database
                                addtoOutput("Season ".$Episode->SeasonNumber,"Exists in DB");
				}
				if(file_exists($seriespath.sprintf("%0"."2"."d",$Episode->SeasonNumber,2)."/".sprintf("%0"."2"."d",$Episode->EpisodeNumber,2).".mp4")){
					//episode file exists, add to db
                                        addtoOutput("Episode ".$Episode->EpisodeNumber," Created ",$Episode->id." - ".$Episode->EpisodeName);
					$dbstuff->execute("INSERT INTO v_episode (author_id, name, number, description, date_added, date_aired, rating, tvdb_episode_id, tvdb_season_id, tvdb_series_id, server_name) VALUES ('"."0"."', '".addSlashes($Episode->EpisodeName)."', '".addSlashes($Episode->EpisodeNumber)."', '".addSlashes($Episode->Overview)."', '".date("Y-m-d")."', '".$Episode->FirstAired."', '".addSlashes($Episode->Rating)."', '".addSlashes($Episode->id)."', '".addSlashes($Episode->seasonid)."', '".addSlashes($Episode->seriesid)."', '".addSlashes("localhost")."')");	
				} 
			}	
		}
	}	
} 
echo $tableoutput."</table>";
?>
</body>
</html>