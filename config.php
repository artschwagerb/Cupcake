<?php
ini_set( "display_errors", true );
//date_default_timezone_set( "America/Chicago" );  // http://www.php.net/manual/en/timezones.php
define("DB_HOST", "localhost");
define( "DB_USERNAME", "" );
define( "DB_PASSWORD", "" );
define( "DB_DATABASE", "cupcake" );
define( "CLASS_PATH", "classes" );
define( "INCLUDE_PATH", "include" );
define( "TEMPLATE_PATH", "include/templates" );
define( "HOMEPAGE_NUM_ITEMS", 5 );
define( "TIME_OFFSET", "0 hours");

require( CLASS_PATH . "/class.user.php" );
require( CLASS_PATH . "/class.databee.php" );
require( CLASS_PATH . "/class.episode.php" );
require( CLASS_PATH . "/class.season.php" );
require( CLASS_PATH . "/class.show.php" );
require( CLASS_PATH . "/class.movie.php" );
require( CLASS_PATH . "/class.statistics.php" );
require( CLASS_PATH . "/class.comment.php" );
require( CLASS_PATH . "/class.topic.php" );
?>
