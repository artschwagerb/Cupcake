<?php
require_once("config.php");

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if (empty($_GET["ep_id"])) {
    echo "Variables not Provided...<br />";
    exit;
}

$ep_id = $_GET['ep_id'];
//$server_id = $_GET['s_id'];

$json = file_get_contents("http://10.0.50.26/cupcake/api.episode.php?q=".$ep_id."&type=json&api=brianrocks123");
$data = json_decode($json);

$dbstuff = new databee();
$episoderes = $dbstuff->query("SELECT * FROM v_episode WHERE tvdb_episode_id='".addSlashes($data->episodes[0]->episode->tvdb_episode_id)."';");
if(mysql_num_rows($episoderes) == 0){
  
  echo "Adding - ".$data->episodes[0]->episode->name.", to the Database<br />";
  
  $dbstuff->execute("INSERT INTO v_episode (author_id, name, number, description, date_added, date_aired, rating, tvdb_episode_id, tvdb_season_id, tvdb_series_id, server_id) VALUES ('"."0"."', '".addSlashes($data->episodes[0]->episode->name)."', '".addSlashes($data->episodes[0]->episode->number)."', '".addSlashes($data->episodes[0]->episode->description)."', '".date("Y-m-d")."', '".$data->episodes[0]->episode->date_aired."', '".addSlashes($data->episodes[0]->episode->rating)."', '".addSlashes($data->episodes[0]->episode->tvdb_episode_id)."', '".addSlashes($data->episodes[0]->episode->tvdb_season_id)."', '".addSlashes($data->episodes[0]->episode->tvdb_series_id)."', '".addSlashes("1")."')");
  
  echo "Added to Database Successfully...";
//Not Found
}else{
  echo $data->episodes[0]->episode->tvdb_episode_id." is already in the database"; 
//Found
}
echo "<br /><br />";
//print_r($data);


?>
