<?php
require_once("config.php");

if (empty($_GET["ep_id"]) || empty($_GET["type"])) {
    echo "Variables not Provided...<br />";
    exit;
}

if (empty($_GET['api'])) {
    echo "API Key is not Provided...<br />";
    exit;
} else {
    if ($_GET['api'] != 'brianrocks123') {
        echo "API Key is not Valid...<br />";
        exit;
    }
}

if ($_GET['type'] == 'json') {
//get a connection to mysql
    $dbstuff = new databee();
    $result = $dbstuff->query("SELECT * FROM v_episode WHERE tvdb_episode_id='".addSlashes($_GET['ep_id'])."'");
    if(mysql_num_rows($result) != 0){
        //run a while loop get your data.
        while ($episode = mysql_fetch_array($result, MYSQL_ASSOC)) {

            $episodes[] = array('episode' => $episode);
        }

        $output = json_encode(array('episodes' => $episodes));
        echo $output;
    }else{
        echo "notfound";
    }
        
} elseif ($_GET['type'] == 'xml') {

//get a connection to mysql
    $dbstuff = new databee();
    $result2 = $dbstuff->query("SELECT * FROM v_episode WHERE tvdb_episode_id='".addSlashes($_GET['ep_id'])."'");

//header("Content-type: text/xml");
//run a while loop get your data.
    header("Content-type: text/xml");
    echo trim('<?xml version="1.0"?>');
    echo trim('<episodes>');
    while ($episode = mysql_fetch_array($result2)) {
        $output = '<episode>';
        $output .= '<id>' . $episode['id'] . '</id>';
        $output .= '<name>' . $episode['name'] . '</name>';
        $output .= '<number>' . $episode['number'] . '</number>';
        $output .= '<description>' . $episode['description'] . '</description>';
        $output .= '<active>' . $episode['active'] . '</active>';
        $output .= '<date_added>' . $episode['date_added'] . '</date_added>';
        $output .= '<rating>' . $episode['rating'] . '</rating>';
        $output .= '<tvdb_episode_id>' . $episode['tvdb_episode_id'] . '</tvdb_episode_id>';
        $output .= '<tvdb_season_id>' . $episode['tvdb_season_id'] . '</tvdb_season_id>';
        $output .= '<tvdb_series_id>' . $episode['tvdb_series_id'] . '</tvdb_series_id>';
        $output .= '<date_aired>' . $episode['date_aired'] . '</date_aired>';
        $output .= '</episode>';
        echo $output;
    }
    echo '</episodes>';
} else {

    echo "<h1>No results to show for you query</h1>";
}
?>