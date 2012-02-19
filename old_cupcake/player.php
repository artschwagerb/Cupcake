<?php

require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

include "config.php";
include TEMPLATE_PATH."/header.php";
?>
<head>

<script src="video-js/video.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="video-js/video-js.css" type="text/css" media="screen" title="Video JS" charset="utf-8">
<!-- VideoJS Optional Skins -->
<link rel="stylesheet" href="video-js/skins/vim.css" >
<script type="text/javascript" charset="utf-8">
    // Add VideoJS to all video tags on the page when the DOM is ready
    VideoJS.setupAllWhenReady();
</script>
<title></title>
</head>

<body>

<?php
$episode = new episode($_GET["id"]);		
?>

<!-- Begin VideoJS -->
<center>
<a title="<?php echo $episode->show->name; ?>" href="show.php?id=<?php echo $episode->show->tvdb_series_id; ?>"><img src="images/shows/banners/<?php echo $episode->show->tvdb_series_id; ?>.jpg" /></a>
<div id="Episode Info"><?php echo $episode->name;?><br /><?php echo "Season ".$episode->season->number." - Episode ".$episode->number;?></div>
  <div class="video-js-box vim-css">
    <video class="video-js" width="480" height="270" controls preload>
      <source src="<?php echo $episode->filename;?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' />
        <!-- Image Fallback. Typically the same as the poster image. -->
        <!-- <img src="<?php echo "images/shows/previews/".$episode->tvdb_episode_id.".jpg"; ?>" width="480" height="270" alt="Poster Image" title="No video playback capabilities." /> -->
      </object>
    </video>
  </div>
  
<?php
$nextepisode = new episode($episode->getNextEpisode()); 
if(!$nextepisode->tvdb_episode_id==0) {	
?>
<br />  
<a class='button black' href="player.php?id=<?php echo $nextepisode->tvdb_episode_id; ?>">Next Episode?</a>
<?php
}
?>
</center>
<!-- End VideoJS -->

</html>