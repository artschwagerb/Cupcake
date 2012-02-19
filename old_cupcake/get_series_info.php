<head>


</head>
<body>

<?php 

$APIKEY="189812DEFDFC361E";

$showname = $_GET["name"];

$seriesid = "";

function getSeriesInfo() {
	$file = "http://www.thetvdb.com/api/GetSeries.php?seriesname=".$showname;
	print "<p>$file</p>";
				
	//Process Local XML files
		$xmlcontent=curl($file) or trigger_error("Sorry but an error occured gathering information for this episode from thetvdb.com  Please try again shortly by refreshing this page");
		
		$xml = new SimpleXMLElement($xmlcontent);
		if($xml->Series != '') {
		$series_id= $xml->Series[0]->seriesid;
		$series_name= $xml->Series[0]->SeriesName;
		$series_banner= "http://thetvdb.com/banners/".$xml->Series[0]->banner;
		$series_overview= $xml->Series[0]->Overview;
		$series_aired= $xml->Series[0]->FirstAired;
		$series_imdb= $xml->Series[0]->IMDB_ID;	
		echo strtolower($series_name);
		echo strtolower(str_replace("_"," ",$showname));
			if(strpos(strtolower($series_name),strtolower(str_replace("_"," ",$showname))) == FALSE){
			echo "Found the wrong Series";
			} else {
			echo "Found the right Series";
			}
		}else{
			echo "Bad Search";
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
?>
</body>
</html>