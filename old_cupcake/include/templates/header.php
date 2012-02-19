<!DOCTYPE html>
<?php

?>
<html lang="en">
  <head>
    <title>Cupcakes are Yummy</title>
	<link rel="stylesheet" type="text/css" href="buttons.css" />
    <link rel="stylesheet" type="text/css" href="bluestyle.css" />
	<link rel="stylesheet" type="text/css" href="rating.css" />
	<script type="text/javascript" src="jquery-1.4.2.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.button').click(function(){ return false; });
		});
	</script>
	
	<script language="javascript">
  function toggleDiv(divid){
    if(document.getElementById(divid).style.display == 'none'){
      document.getElementById(divid).style.display = 'block';
    }else{
      document.getElementById(divid).style.display = 'none';
    }
  }
</script>
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
    <div id="container">
      
	  
	  <div id="left">
   <p><a href="."><img id="logo" src="images/cupcake_logo.png" title="The Cupcake Baker Cometh" /></a></p>
  </div><!-- left -->
  <div id="right">
   <p id="userinfo">
   <?php    
   //echo 'Welcome, <a href="user.php?id='.$fgmembersite->UserID().'">'.$fgmembersite->UserFullName().'</a>';
   //echo "<br /><br />";
   ?>
	<br /><br /><br />
     <a class='button orange' href="show.php">TV Shows</a>  <a class='button red' href="movie.php">Movies</a>  <a class='button blue' href="user.php"><?php echo $fgmembersite->UserFullName(); ?></a>  <?php if($fgmembersite->UserAdmin()==9) {?><a class='button black' href="admin/index.php">Admin</a><?php }?>  <a class='button green' href="logout.php">Logout</a>
   </p>
  </div><!-- right -->
  <div style="clear: both;"></div>

  <div class="line"></div>
