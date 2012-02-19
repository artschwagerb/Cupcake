<?php
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

</head>

<body>
<?php 	

//$episode = new episode();
//$episode->fill_values($_GET["id"]);
//$filename = $episode->filename; 
$preview = "images/cupcakes_play.png";
?>
<!-- Begin VideoJS -->
<center>
<video width="512" height="384" controls="controls" poster="<?php echo $preview; ?>">
  <source src="01.mp4" type="video/mp4" />
  Your browser does not support the video tag.
</video>
</center>
<!-- End VideoJS -->

</html>