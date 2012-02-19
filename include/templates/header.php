<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />

	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width" />
	<LINK REL="SHORTCUT ICON" HREF="images/favicon.ico">
	<title>Cupcake</title>
  
	<!-- Included CSS Files -->
	<link rel="stylesheet" href="stylesheets/foundation.css">
	<link rel="stylesheet" href="stylesheets/app.css">
	<link rel="stylesheet" href="stylesheets/randomness.css">
        <link rel="stylesheet" href="stylesteets/orbit.css">
	<!--[if lt IE 9]>
		<link rel="stylesheet" href="stylesheets/ie.css">
	<![endif]-->


	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="javascripts/jquery.min.js" type="text/javascript"></script>
        <script src="javascripts/jquery.orbit.min.js" type="text/javascript"></script>
	<script language="javascript">
  function toggleDiv(divid,caller){
    if(document.getElementById(divid).style.display == 'none'){
      document.getElementById(divid).style.display = 'block';
	  caller.innerHTML = '^';
    }else{
      document.getElementById(divid).style.display = 'none';
	  caller.innerHTML = 'v';
    }
  }
  function toggleDiv(divid){
    if(document.getElementById(divid).style.display == 'none'){
      document.getElementById(divid).style.display = 'block';
    }else{
      document.getElementById(divid).style.display = 'none';
    }
  }
</script>

<script type="text/javascript">
     $(window).load(function() {
         $('#featured').orbit();
     });
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
	<?php //include_once("include/analyticstracking.php"); ?>
	<!-- container -->
	<div class="container">

		<div class="row">
			<div class="six columns">
				<a href="."><img width="300px" id="logo" src="images/cupcake_logo.png" title="The Cupcake Baker Cometh" /></a>
			</div>
			<br />
			<br />
			<br />
			<div class="six columns">
				<div style="text-align: right;">
					<a class='small orange nice button radius ' href="show.php">TV Shows</a>  <?php if($fgmembersite->CheckPremium()) {?><a class='small red nice button radius' href="movie.php">Movies</a><?php } ?>  <a class='small blue nice button radius' href="user.php"><?php echo $fgmembersite->UserFullName(); ?></a>  <?php if($fgmembersite->CheckAdmin()) {?><a class='small black nice button radius' href="admin.php">Admin</a><?php }?>  <a class='small green nice button radius ' href="logout.php">Logout</a>
				</div>
			</div>
		</div>
<hr />