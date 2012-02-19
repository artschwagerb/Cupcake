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
if(empty($_GET["id"])){
$movie = new movie(0);
$movie->getAll();
}else{
$movie = new movie($_GET["id"]);
//$movie->view();
?>

<center>
<div id="Episode Info"><?php echo $movie->name;?></div>
  <div class="video-js-box vim-css">
    <video class="video-js" width="480" height="270" controls preload>
      <source src="<?php echo $movie->filename;?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' />
        <!-- Image Fallback. Typically the same as the poster image. -->
        <img src="<?php echo "images/cupcakes_play.png" ?>" width="480" height="270" alt="Poster Image" title="No video playback capabilities." />
      </object>
    </video>
  </div>
</center>

<?php

}
		
?>

</html>