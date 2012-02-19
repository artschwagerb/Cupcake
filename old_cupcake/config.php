<?php
ini_set( "display_errors", true );
date_default_timezone_set( "Australia/Sydney" );  // http://www.php.net/manual/en/timezones.php
define( "DB_HOST", "localhost" );
define( "DB_USERNAME", "cup" );
define( "DB_PASSWORD", "RYYpZduhZsBsa8ha" );
define( "DB_DATABASE", "cupcake" );
define( "CLASS_PATH", "classes" );
define( "TEMPLATE_PATH", "include/templates" );
define( "HOMEPAGE_NUM_ITEMS", 5 );
require( CLASS_PATH . "/user.php" );
require( CLASS_PATH . "/databee.php" );
require( CLASS_PATH . "/cupcake.php" );
require( CLASS_PATH . "/episode.php" );
require( CLASS_PATH . "/season.php" );
require( CLASS_PATH . "/show.php" );
require( CLASS_PATH . "/movie.php" );
?>
