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
        <link rel="stylesheet" href="stylesheets/randomness.css">
	<link rel="stylesheet" href="stylesheets/foundation.css">
	<link rel="stylesheet" href="stylesheets/app.css">
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
         $('#featured').orbit({
            animation: 'fade',                  // fade, horizontal-slide, vertical-slide, horizontal-push
            animationSpeed: 800,                // how fast animtions are
            timer: true, 			 // true or false to have the timer
            advanceSpeed: 4000, 		 // if timer is enabled, time between transitions 
            pauseOnHover: false, 		 // if you hover pauses the slider
            startClockOnMouseOut: false, 	 // if clock should start on MouseOut
            startClockOnMouseOutAfter: 1000, 	 // how long after MouseOut should the timer start again
            directionalNav: false, 		 // manual advancing directional navs
            captions: true, 			 // do you want captions?
            captionAnimation: 'fade', 		 // fade, slideOpen, none
            captionAnimationSpeed: 800, 	 // if so how quickly should they animate in
            bullets: false,			 // true or false to activate the bullet navigation
            bulletThumbs: false,		 // thumbnails for the bullets
            bulletThumbLocation: '',		 // location from this file where thumbs will be
            afterSlideChange: function(){}, 	 // empty function 
            fluid: true                         // or set a aspect ratio for content slides (ex: '4x3') 
        });
     });
</script>

<script type="text/javascript">
$(document).ready(function() { 

	$("span.spoiler").hide();

	 $('<a class="label red" style="cursor: pointer; cursor: hand; color: #FFFFFF;">Reveal Spoiler</a> ').insertBefore('.spoiler');

	$("a.label.red").click(function(){
		$(this).parents("p").children("span.spoiler").fadeIn(2500);
		$(this).parents("p").children("a.label.red").fadeOut(600);
	});

});
</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-29123919-1']);
  _gaq.push(['_setDomainName', 'cupcakesfor.me']);
  _gaq.push(['_trackPageview']);
  
  _gaq.push(['_setCustomVar',
      1,             // This custom var is set to slot #1.  Required parameter.
      'User ID',   // The name of the custom variable.  Required parameter.
      '<?php echo $_SESSION['id_of_user']?>',      // Sets the value of "User Type" to "Member" or "Visitor" depending on status.  Required parameter.
       2             // Sets the scope to session-level.  Optional parameter.
   ]);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>


<link href="stylesheets/skin/blue.monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="stylesteets/jquery.thumbs.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
<script type="text/javascript" src="javascripts/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="javascripts/jplayer.playlist.min.js"></script>
<script src="javascripts/jquery.thumbs.js" type="text/javascript"></script>
<script src="javascripts/jquery.jeditable.mini.js" type="text/javascript"></script>

<script src="video-js/video.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="video-js/video-js.css" type="text/css" media="screen" title="Video JS" charset="utf-8">
<!-- VideoJS Optional Skins -->
<link rel="stylesheet" href="video-js/skins/vim.css" >
<script type="text/javascript">
    // Add VideoJS to all video tags on the page when the DOM is ready
    VideoJS.setupAllWhenReady();
</script>

<?php
        //beginning of page load time
        //$starttime = microtime();
        $startarray = explode(" ", microtime());
        $starttime = $startarray[1] + $startarray[0];
        ?>

<?php
if(empty($_GET["css"])){
//normal view
}else{
//add user's css
    echo '<link rel="stylesheet" href="'.$_GET['css'].'">';
}
?>

</head>
<body>
	<!-- container -->
	<div class="container">

		<div class="row">
			<div class="four columns">
				<a href="."><img width="300px" id="logo" src="images/cupcake_logo.png" title="The Cupcake Baker Cometh" /></a>
			</div>
			<br />
			<br />
			<br />
			<div class="eight columns">
				<div style="text-align: right;">
					<a class='small orange nice button radius ' href="show.php">TV Shows</a>  <?php if($fgmembersite->CheckPremium()) {?><a class='small red nice button radius' href="movie.php">Movies</a><?php } ?>  <a class='small purple nice button radius' href="topic.php">Boards</a>  <a class='small blue nice button radius' href="user.php"><?php echo $fgmembersite->UserFullName(); ?></a>  <?php if($fgmembersite->CheckAdmin()) {?><a class='small black nice button radius' href="admin.php">Admin</a><?php }?>  <a class='small green nice button radius ' href="logout.php">Logout</a>
				</div>
			</div>
		</div>
<hr />