<?php
ini_set( "display_errors", true );
//date_default_timezone_set( "America/Chicago" );  // http://www.php.net/manual/en/timezones.php
define("DB_HOST", "localhost");
define( "DB_USERNAME", "" );
define( "DB_PASSWORD", "" );
define( "DB_DATABASE", "cupcake" );

define( "EMAIL_USERNAME", "noreply@cupcakesfor.me");
define( "EMAIL_ADDRESS", "noreply@cupcakesfor.me");
define( "EMAIL_PASSWORD", "AL1e4aVQAJl1u4u10");
define( "EMAIL_NAME", "Cupcake");
define( "EMAIL_HOST", "smtp.gmail.com");


define( "CLASS_PATH", "classes" );
define( "INCLUDE_PATH", "include" );
define( "TEMPLATE_PATH", "include/templates" );

define( "HOMEPAGE_NUM_ITEMS", 5 );
define( "TIME_OFFSET", "0 hours");

require_once( CLASS_PATH . "/class.user.php" );
require_once( CLASS_PATH . "/class.databee.php" );
require_once( CLASS_PATH . "/class.episode.php" );
require_once( CLASS_PATH . "/class.season.php" );
require_once( CLASS_PATH . "/class.show.php" );
require_once( CLASS_PATH . "/class.movie.php" );
require_once( CLASS_PATH . "/class.statistics.php" );
require_once( CLASS_PATH . "/class.comment.php" );
require_once( CLASS_PATH . "/class.topic.php" );
require_once( CLASS_PATH . "/class.admin.php" );
require_once( CLASS_PATH . "/class.page.php");
?>
